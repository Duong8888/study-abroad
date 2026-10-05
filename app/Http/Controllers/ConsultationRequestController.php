<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConsultationRequestController extends Controller
{
    const STATUS_LABELS = [
        ConsultationRequest::STATUS_NEW => 'Mới',
        ConsultationRequest::STATUS_PROCESSING => 'Đang xử lý',
        ConsultationRequest::STATUS_DONE => 'Đã tư vấn',
        ConsultationRequest::STATUS_UNREACHABLE => 'Không liên hệ được',
    ];

    /**
     * Danh sách yêu cầu (admin): tìm kiếm, lọc, sắp xếp, phân trang.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;

        $data = $this->filteredQuery($request)->paginate($perPage);

        return response()->json($data);
    }

    /**
     * Thống kê cho trang quản lý yêu cầu tư vấn.
     */
    public function stats()
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $count = fn (Carbon $from, ?Carbon $to = null) => ConsultationRequest::query()
            ->where('created_at', '>=', $from)
            ->when($to, fn ($q) => $q->where('created_at', '<', $to))
            ->count();

        $byStatus = ConsultationRequest::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $statusCounts = [];
        foreach (ConsultationRequest::STATUSES as $status) {
            $statusCounts[$status] = (int) ($byStatus[$status] ?? 0);
        }
        $total = array_sum($statusCounts);

        // Số yêu cầu theo ngày trong 30 ngày gần nhất (đủ cả ngày không có yêu cầu)
        $dailyFrom = $today->copy()->subDays(29);
        $dailyRows = ConsultationRequest::query()
            ->where('created_at', '>=', $dailyFrom)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');
        $daily = [];
        for ($day = $dailyFrom->copy(); $day <= $today; $day->addDay()) {
            $key = $day->toDateString();
            $daily[] = ['date' => $key, 'total' => (int) ($dailyRows[$key] ?? 0)];
        }

        // Thời gian phản hồi trung bình (giờ) của 200 yêu cầu được xử lý gần nhất
        $handled = ConsultationRequest::query()
            ->whereNotNull('handled_at')
            ->latest('handled_at')
            ->limit(200)
            ->get(['created_at', 'handled_at']);
        $avgResponseHours = $handled->isEmpty() ? null : round(
            $handled->avg(fn ($row) => max(0, $row->created_at->diffInMinutes($row->handled_at))) / 60,
            1
        );

        $sources = ConsultationRequest::query()
            ->where('created_at', '>=', $today->copy()->subDays(89))
            ->selectRaw("COALESCE(NULLIF(source, ''), '') as src, COUNT(*) as total")
            ->groupBy('src')
            ->orderByDesc('total')
            ->limit(6)
            ->get()
            ->map(fn ($row) => ['source' => $row->src, 'total' => (int) $row->total]);

        $handledCount = $statusCounts[ConsultationRequest::STATUS_DONE] + $statusCounts[ConsultationRequest::STATUS_UNREACHABLE];

        return response()->json([
            'total' => $total,
            'status' => $statusCounts,
            'today' => $count($today),
            'yesterday' => $count($today->copy()->subDay(), $today),
            'last7' => $count($today->copy()->subDays(6)),
            'prev7' => $count($today->copy()->subDays(13), $today->copy()->subDays(6)),
            'this_month' => $count($now->copy()->startOfMonth()),
            'last_month' => $count($now->copy()->subMonthNoOverflow()->startOfMonth(), $now->copy()->startOfMonth()),
            'done_rate' => $handledCount ? round($statusCounts[ConsultationRequest::STATUS_DONE] / $handledCount * 100) : null,
            'avg_response_hours' => $avgResponseHours,
            'daily' => $daily,
            'sources' => $sources,
        ]);
    }

    /**
     * Khách gửi form tư vấn (công khai).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'content' => 'nullable|string|max:5000',
            'source' => 'nullable|string|max:255',
        ]);

        try {
            ConsultationRequest::create([
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $request->email ?? null,
                'content' => $request->content ?? '',
                'source' => $request->source ?? null,
                'status' => ConsultationRequest::STATUS_NEW,
            ]);
            return response()->json(['success' => true, 'message' => 'Xin cảm ơn, form đã được gửi thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gửi yêu cầu thất bại, vui lòng thử lại.'], 500);
        }
    }

    /**
     * Cập nhật trạng thái / ghi chú của một yêu cầu.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['nullable', 'integer', Rule::in(ConsultationRequest::STATUSES)],
            'note' => 'nullable|string|max:5000',
        ]);

        try {
            $item = ConsultationRequest::query()->findOrFail($id);
            // Không gửi status (giao diện cũ) = đánh dấu đã tư vấn
            if (!$request->has('status') && !$request->has('note')) {
                $request->merge(['status' => ConsultationRequest::STATUS_DONE]);
            }
            if ($request->has('status')) {
                $this->applyStatus($item, (int) $request->input('status'));
            }
            if ($request->has('note')) {
                $item->note = $request->input('note');
            }
            $item->save();

            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.', 'data' => $item]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Cập nhật thất bại.'], 500);
        }
    }

    /**
     * Đổi trạng thái nhiều yêu cầu cùng lúc.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1|max:500',
            'ids.*' => 'integer',
            'status' => ['required', 'integer', Rule::in(ConsultationRequest::STATUSES)],
        ]);

        $items = ConsultationRequest::query()->whereIn('id', $request->input('ids'))->get();
        foreach ($items as $item) {
            $this->applyStatus($item, (int) $request->input('status'));
            $item->save();
        }

        return response()->json(['success' => true, 'message' => "Đã cập nhật {$items->count()} yêu cầu."]);
    }

    public function destroy(string $id)
    {
        ConsultationRequest::query()->findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Đã xóa yêu cầu.']);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1|max:500',
            'ids.*' => 'integer',
        ]);
        $deleted = ConsultationRequest::query()->whereIn('id', $request->input('ids'))->delete();
        return response()->json(['success' => true, 'message' => "Đã xóa {$deleted} yêu cầu."]);
    }

    /**
     * Xuất danh sách (theo bộ lọc hiện tại) ra file CSV mở được bằng Excel.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = $this->filteredQuery($request);
        $fileName = 'yeu-cau-tu-van-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM để Excel đọc đúng tiếng Việt
            fputcsv($out, ['ID', 'Họ tên', 'Số điện thoại', 'Email', 'Nội dung', 'Trạng thái', 'Ghi chú', 'Nguồn', 'Thời gian gửi', 'Thời gian xử lý']);
            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $row) {
                    fputcsv($out, [
                        $row->id,
                        $row->name,
                        // Thêm ="..." để Excel giữ số 0 đầu số điện thoại
                        '="' . $row->phone_number . '"',
                        $row->email,
                        $row->content,
                        self::STATUS_LABELS[$row->status] ?? $row->status,
                        $row->note,
                        $row->source,
                        optional($row->created_at)->format('d/m/Y H:i'),
                        optional($row->handled_at)->format('d/m/Y H:i'),
                    ]);
                }
            });
            fclose($out);
        }, $fileName, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Truy vấn dùng chung cho danh sách và xuất file.
     */
    private function filteredQuery(Request $request): Builder
    {
        $query = ConsultationRequest::query();

        if ($keyword = trim((string) $request->input('q'))) {
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $keyword) . '%';
            $phone = preg_replace('/\D/', '', $keyword);
            $query->where(function ($q) use ($like, $phone) {
                $q->where('name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('content', 'like', $like)
                    ->orWhere('note', 'like', $like);
                if ($phone !== '') {
                    $q->orWhere('phone_number', 'like', "%{$phone}%");
                }
            });
        }

        $status = $request->input('status');
        if ($status !== null && $status !== '' && $status !== 'all') {
            $query->where('status', (int) $status);
        }

        if ($from = $this->parseDate($request->input('from'))) {
            $query->where('created_at', '>=', $from->startOfDay());
        }
        if ($to = $this->parseDate($request->input('to'))) {
            $query->where('created_at', '<=', $to->endOfDay());
        }

        $request->input('sort') === 'oldest'
            ? $query->orderBy('created_at')->orderBy('id')
            : $query->orderByDesc('created_at')->orderByDesc('id');

        return $query;
    }

    private function parseDate($value): ?Carbon
    {
        if (!$value) return null;
        try {
            return Carbon::createFromFormat('Y-m-d', $value);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function applyStatus(ConsultationRequest $item, int $status): void
    {
        $item->status = $status;
        if ($status === ConsultationRequest::STATUS_NEW) {
            $item->handled_at = null;
        } elseif (!$item->handled_at) {
            $item->handled_at = now();
        }
    }
}

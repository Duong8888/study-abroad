<template>
    <div class="rq-page">
        <!-- Tiêu đề -->
        <div class="rq-head">
            <div>
                <h1 class="rq-title">Yêu cầu tư vấn</h1>
                <p class="rq-subtitle">Theo dõi và xử lý khách hàng đăng ký tư vấn từ website</p>
            </div>
            <div class="rq-head__actions">
                <button type="button" class="rq-btn rq-btn--ghost" :disabled="refreshing" @click="refreshAll">
                    <i class="fas fa-sync-alt" :class="{'fa-spin': refreshing}"></i> Làm mới
                </button>
                <button type="button" class="rq-btn rq-btn--primary" :disabled="exporting" @click="exportCsv">
                    <i class="fas" :class="exporting ? 'fa-spinner fa-spin' : 'fa-file-excel'"></i> Xuất Excel
                </button>
            </div>
        </div>

        <!-- Thẻ số liệu -->
        <div class="rq-kpis">
            <div v-for="kpi in kpis" :key="kpi.key" class="rq-kpi" :class="{'rq-kpi--accent': kpi.accent, 'rq-kpi--clickable': kpi.onClick}"
                 :role="kpi.onClick ? 'button' : null" :tabindex="kpi.onClick ? 0 : null"
                 @click="kpi.onClick && kpi.onClick()" @keydown.enter="kpi.onClick && kpi.onClick()">
                <div class="rq-kpi__icon"><i :class="kpi.icon"></i></div>
                <div class="rq-kpi__body">
                    <div class="rq-kpi__label">{{ kpi.label }}</div>
                    <div class="rq-kpi__value">{{ kpi.value }}</div>
                    <div class="rq-kpi__sub">
                        <span v-if="kpi.delta" class="rq-delta" :class="kpi.delta.type">
                            <i class="fas" :class="kpi.delta.type === 'up' ? 'fa-arrow-up' : (kpi.delta.type === 'down' ? 'fa-arrow-down' : 'fa-minus')"></i>
                            {{ kpi.delta.text }}
                        </span>
                        {{ kpi.sub }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="rq-charts">
            <section class="rq-card rq-chart">
                <div class="rq-card__head">
                    <div>
                        <h2 class="rq-card__title">Yêu cầu theo ngày</h2>
                        <p class="rq-card__desc">30 ngày gần nhất · tổng {{ dailyTotal }} yêu cầu</p>
                    </div>
                    <button type="button" class="rq-link" @click="showDailyTable = !showDailyTable">
                        {{ showDailyTable ? 'Xem biểu đồ' : 'Xem bảng số liệu' }}
                    </button>
                </div>

                <div v-if="!showDailyTable" class="rq-bars" role="img"
                     :aria-label="`Biểu đồ số yêu cầu theo ngày, 30 ngày gần nhất, tổng ${dailyTotal}`"
                     @mouseleave="hoverDay = null">
                    <div class="rq-bars__grid">
                        <div v-for="tick in dailyTicks" :key="tick" class="rq-bars__gridline"
                             :style="{bottom: (tick / dailyMax * 100) + '%'}">
                            <span>{{ tick }}</span>
                        </div>
                    </div>
                    <div class="rq-bars__plot">
                        <div v-for="(day, index) in daily" :key="day.date" class="rq-bars__slot"
                             @mouseenter="hoverDay = index">
                            <div class="rq-bars__bar" :class="{active: hoverDay === index}"
                                 :style="{height: (day.total / dailyMax * 100) + '%'}"></div>
                            <div v-if="hoverDay === index" class="rq-tooltip"
                                 :class="{'rq-tooltip--left': index > daily.length - 5, 'rq-tooltip--right': index < 4}">
                                <div class="rq-tooltip__label">{{ formatDayLong(day.date) }}</div>
                                <div class="rq-tooltip__value">{{ day.total }} yêu cầu</div>
                            </div>
                            <span v-if="index % 5 === 4 || index === daily.length - 1" class="rq-bars__x">
                                {{ formatDayShort(day.date) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div v-else class="rq-day-table">
                    <table>
                        <thead><tr><th>Ngày</th><th class="text-right">Số yêu cầu</th></tr></thead>
                        <tbody>
                        <tr v-for="day in [...daily].reverse()" :key="day.date">
                            <td>{{ formatDayLong(day.date) }}</td>
                            <td class="text-right">{{ day.total }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rq-card">
                <div class="rq-card__head">
                    <div>
                        <h2 class="rq-card__title">Theo trạng thái</h2>
                        <p class="rq-card__desc">Toàn bộ {{ stats?.total ?? 0 }} yêu cầu</p>
                    </div>
                </div>
                <ul class="rq-breakdown">
                    <li v-for="item in statusBreakdown" :key="item.value" role="button" tabindex="0"
                        @click="setStatusFilter(item.value)" @keydown.enter="setStatusFilter(item.value)">
                        <div class="rq-breakdown__row">
                            <span class="rq-breakdown__label">
                                <i class="fas" :class="item.icon" :style="{color: item.color}"></i>{{ item.label }}
                            </span>
                            <span class="rq-breakdown__value">{{ item.count }} <small>· {{ item.percent }}%</small></span>
                        </div>
                        <div class="rq-meter"><div :style="{width: item.percent + '%', background: item.color}"></div></div>
                    </li>
                </ul>

            </section>

            <section class="rq-card">
                <div class="rq-card__head">
                    <div>
                        <h2 class="rq-card__title">Nguồn gửi form</h2>
                        <p class="rq-card__desc">Trang khách đang xem khi gửi · 90 ngày</p>
                    </div>
                </div>
                <ul v-if="sources.length" class="rq-breakdown rq-breakdown--compact">
                    <li v-for="item in sources" :key="item.source">
                        <div class="rq-breakdown__row">
                            <span class="rq-breakdown__label rq-ellipsis" :title="item.source || 'Không rõ'">{{ sourceLabel(item.source) }}</span>
                            <span class="rq-breakdown__value">{{ item.total }}</span>
                        </div>
                        <div class="rq-meter"><div :style="{width: item.percent + '%'}"></div></div>
                    </li>
                </ul>
                <p v-else class="rq-empty-text">Chưa có dữ liệu nguồn.</p>
            </section>
        </div>

        <!-- Danh sách -->
        <section class="rq-card rq-list">
            <div class="rq-tabs" role="tablist">
                <button v-for="tab in statusTabs" :key="tab.value" type="button" role="tab" class="rq-tab"
                        :class="{active: filters.status === tab.value}" :aria-selected="filters.status === tab.value"
                        @click="setStatusFilter(tab.value)">
                    <i v-if="tab.icon" class="fas" :class="tab.icon" :style="{color: tab.color}"></i>
                    {{ tab.label }}
                    <span class="rq-tab__count">{{ tab.count }}</span>
                </button>
            </div>

            <div class="rq-filters">
                <div class="rq-search">
                    <i class="fas fa-search"></i>
                    <input v-model="searchInput" type="search" placeholder="Tìm theo tên, số điện thoại, email, nội dung..."
                           aria-label="Tìm kiếm yêu cầu">
                </div>
                <select v-model="filters.range" class="rq-select" aria-label="Khoảng thời gian">
                    <option v-for="option in rangeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                </select>
                <template v-if="filters.range === 'custom'">
                    <input v-model="filters.from" type="date" class="rq-select" aria-label="Từ ngày" :max="filters.to || undefined">
                    <span class="rq-filters__sep">→</span>
                    <input v-model="filters.to" type="date" class="rq-select" aria-label="Đến ngày" :min="filters.from || undefined">
                </template>
                <select v-model="filters.sort" class="rq-select" aria-label="Sắp xếp">
                    <option value="newest">Mới nhất trước</option>
                    <option value="oldest">Cũ nhất trước</option>
                </select>
                <button v-if="hasActiveFilters" type="button" class="rq-link" @click="resetFilters">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </button>
            </div>

            <!-- Thao tác hàng loạt -->
            <div v-if="selectedIds.length" class="rq-bulk">
                <span><b>{{ selectedIds.length }}</b> yêu cầu đã chọn</span>
                <div class="rq-bulk__actions">
                    <span class="rq-bulk__label">Chuyển sang:</span>
                    <button v-for="status in STATUS_LIST" :key="status.value" type="button" class="rq-btn rq-btn--sm"
                            @click="bulkSetStatus(status.value)">
                        <i class="fas" :class="status.icon" :style="{color: status.color}"></i> {{ status.label }}
                    </button>
                    <button type="button" class="rq-btn rq-btn--sm rq-btn--danger" @click="askDelete(selectedIds)">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </button>
                    <button type="button" class="rq-link" @click="selectedIds = []">Bỏ chọn</button>
                </div>
            </div>

            <div class="rq-table-wrap">
                <table class="rq-table">
                    <thead>
                    <tr>
                        <th class="rq-col-check">
                            <input type="checkbox" :checked="allOnPageSelected" :indeterminate.prop="someOnPageSelected"
                                   aria-label="Chọn tất cả trên trang" @change="toggleSelectPage">
                        </th>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Nội dung &amp; nguồn</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                        <th class="rq-col-actions"></th>
                    </tr>
                    </thead>
                    <tbody v-if="loading && !rows.length">
                    <tr v-for="n in 6" :key="n" class="rq-skeleton-row">
                        <td colspan="7"><div class="rq-sk"></div></td>
                    </tr>
                    </tbody>
                    <tbody v-else-if="!rows.length">
                    <tr>
                        <td colspan="7">
                            <div class="rq-empty">
                                <i class="fas fa-inbox"></i>
                                <b>{{ hasActiveFilters ? 'Không có yêu cầu nào khớp bộ lọc' : 'Chưa có yêu cầu tư vấn nào' }}</b>
                                <span v-if="hasActiveFilters">Thử đổi từ khóa hoặc <button type="button" class="rq-link" @click="resetFilters">xóa bộ lọc</button></span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else :class="{'rq-loading': loading}">
                    <tr v-for="row in rows" :key="row.id" class="rq-row"
                        :class="{'rq-row--new': row.status === 0, 'rq-row--selected': selectedIds.includes(row.id)}"
                        @click="openDetail(row)">
                        <td class="rq-col-check" @click.stop>
                            <input type="checkbox" :value="row.id" v-model="selectedIds" :aria-label="`Chọn ${row.name}`">
                        </td>
                        <td>
                            <div class="rq-customer">
                                <span class="rq-avatar" :style="{background: avatarColor(row.name)}">{{ initials(row.name) }}</span>
                                <div class="rq-customer__info">
                                    <div class="rq-customer__name">{{ row.name }}</div>
                                    <div v-if="row.email" class="rq-customer__sub">{{ row.email }}</div>
                                    <div v-if="row.note" class="rq-customer__note" :title="row.note">
                                        <i class="fas fa-sticky-note"></i> {{ row.note }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td @click.stop>
                            <div class="rq-phone">
                                <a :href="`tel:${row.phone_number}`" class="rq-phone__number" title="Gọi">{{ formatPhone(row.phone_number) }}</a>
                                <div class="rq-phone__actions">
                                    <a :href="`tel:${row.phone_number}`" title="Gọi điện"><i class="fas fa-phone-alt"></i></a>
                                    <a :href="zaloLink(row.phone_number)" target="_blank" rel="noopener" title="Nhắn Zalo" class="rq-zalo">Zalo</a>
                                    <button type="button" title="Sao chép số" @click="copy(row.phone_number)"><i class="far fa-copy"></i></button>
                                </div>
                            </div>
                        </td>
                        <td class="rq-col-content">
                            <div class="rq-clamp" :title="row.content">{{ row.content || 'Không ghi nội dung' }}</div>
                            <span class="rq-source" :title="row.source || ''"><i class="fas fa-globe-asia"></i> {{ sourceLabel(row.source) }}</span>
                        </td>
                        <td @click.stop>
                            <div class="rq-status-select" :class="`rq-status--${row.status}`">
                                <i class="fas" :class="statusMeta(row.status).icon"></i>
                                <select :value="row.status" :aria-label="`Trạng thái của ${row.name}`"
                                        @change="changeStatus(row, Number($event.target.value))">
                                    <option v-for="status in STATUS_LIST" :key="status.value" :value="status.value">{{ status.label }}</option>
                                </select>
                                <i class="fas fa-chevron-down rq-status-select__caret"></i>
                            </div>
                        </td>
                        <td class="rq-col-time">
                            <div :title="formatDateTime(row.created_at)">{{ timeAgo(row.created_at) }}</div>
                            <small>{{ formatDateTime(row.created_at) }}</small>
                        </td>
                        <td class="rq-col-actions" @click.stop>
                            <button type="button" class="rq-icon-btn" title="Xem chi tiết" @click="openDetail(row)"><i class="far fa-eye"></i></button>
                            <button type="button" class="rq-icon-btn rq-icon-btn--danger" title="Xóa" @click="askDelete([row.id])"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div v-if="list.total" class="rq-pagination">
                <span class="rq-pagination__info">Hiển thị {{ list.from }}–{{ list.to }} trên tổng {{ list.total }}</span>
                <div class="rq-pagination__controls">
                    <select v-model.number="filters.per_page" class="rq-select rq-select--sm" aria-label="Số dòng mỗi trang">
                        <option v-for="n in [10, 20, 50, 100]" :key="n" :value="n">{{ n }} / trang</option>
                    </select>
                    <button type="button" class="rq-page-btn" :disabled="list.current_page <= 1" aria-label="Trang trước"
                            @click="goToPage(list.current_page - 1)"><i class="fas fa-chevron-left"></i></button>
                    <button v-for="page in pageNumbers" :key="page.key" type="button" class="rq-page-btn"
                            :class="{active: page.value === list.current_page}" :disabled="!page.value"
                            @click="page.value && goToPage(page.value)">{{ page.label }}</button>
                    <button type="button" class="rq-page-btn" :disabled="list.current_page >= list.last_page" aria-label="Trang sau"
                            @click="goToPage(list.current_page + 1)"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>

        <!-- Chi tiết yêu cầu -->
        <transition name="rq-fade">
            <div v-if="detail" class="rq-overlay" @click="closeDetail"></div>
        </transition>
        <transition name="rq-slide">
            <aside v-if="detail" class="rq-drawer" role="dialog" aria-label="Chi tiết yêu cầu" @keydown.esc="closeDetail">
                <div class="rq-drawer__head">
                    <div class="rq-customer">
                        <span class="rq-avatar rq-avatar--lg" :style="{background: avatarColor(detail.name)}">{{ initials(detail.name) }}</span>
                        <div>
                            <div class="rq-drawer__name">{{ detail.name }}</div>
                            <span class="rq-badge" :class="`rq-status--${detail.status}`">
                                <i class="fas" :class="statusMeta(detail.status).icon"></i> {{ statusMeta(detail.status).label }}
                            </span>
                        </div>
                    </div>
                    <button type="button" class="rq-icon-btn" title="Đóng" @click="closeDetail"><i class="fas fa-times"></i></button>
                </div>

                <div class="rq-drawer__body">
                    <div class="rq-quick">
                        <a :href="`tel:${detail.phone_number}`" class="rq-quick__btn"><i class="fas fa-phone-alt"></i> Gọi điện</a>
                        <a :href="zaloLink(detail.phone_number)" target="_blank" rel="noopener" class="rq-quick__btn"><b class="rq-zalo-text">Zalo</b> Nhắn tin</a>
                        <a v-if="detail.email" :href="`mailto:${detail.email}`" class="rq-quick__btn"><i class="far fa-envelope"></i> Email</a>
                    </div>

                    <dl class="rq-info">
                        <dt>Số điện thoại</dt>
                        <dd>
                            {{ formatPhone(detail.phone_number) }}
                            <button type="button" class="rq-link" @click="copy(detail.phone_number)"><i class="far fa-copy"></i> Sao chép</button>
                        </dd>
                        <dt>Email</dt>
                        <dd>{{ detail.email || '—' }}</dd>
                        <dt>Nguồn</dt>
                        <dd>
                            <a v-if="detail.source" :href="detail.source" target="_blank" rel="noopener">{{ sourceLabel(detail.source) }} <i class="fas fa-external-link-alt"></i></a>
                            <span v-else>Không rõ</span>
                        </dd>
                        <dt>Gửi lúc</dt>
                        <dd>{{ formatDateTime(detail.created_at) }} <small class="text-muted">({{ timeAgo(detail.created_at) }})</small></dd>
                        <dt>Xử lý lúc</dt>
                        <dd>
                            <template v-if="detail.handled_at">
                                {{ formatDateTime(detail.handled_at) }}
                                <small class="text-muted">(sau {{ formatDuration(detail.created_at, detail.handled_at) }})</small>
                            </template>
                            <span v-else class="text-muted">Chưa xử lý</span>
                        </dd>
                    </dl>

                    <div class="rq-block">
                        <div class="rq-block__title">Nội dung khách gửi</div>
                        <div class="rq-message">{{ detail.content || 'Khách không ghi nội dung.' }}</div>
                    </div>

                    <div class="rq-block">
                        <div class="rq-block__title">Trạng thái</div>
                        <div class="rq-segment">
                            <button v-for="status in STATUS_LIST" :key="status.value" type="button"
                                    :class="{active: detail.status === status.value}" :style="detail.status === status.value ? {borderColor: status.color} : null"
                                    @click="changeStatus(detail, status.value)">
                                <i class="fas" :class="status.icon" :style="{color: status.color}"></i> {{ status.label }}
                            </button>
                        </div>
                    </div>

                    <div class="rq-block">
                        <div class="rq-block__title">Ghi chú nội bộ</div>
                        <textarea v-model="noteDraft" rows="4" class="rq-textarea"
                                  placeholder="Vd: Đã gọi lúc 9h, khách hẹn gọi lại chiều thứ 6. Quan tâm du học Hàn ngành CNTT..."></textarea>
                        <div class="rq-block__actions">
                            <small class="text-muted">Chỉ admin xem được ghi chú này</small>
                            <button type="button" class="rq-btn rq-btn--primary rq-btn--sm"
                                    :disabled="savingNote || noteDraft === (detail.note || '')" @click="saveNote">
                                <span v-if="savingNote" class="spinner-border spinner-border-sm"></span> Lưu ghi chú
                            </button>
                        </div>
                    </div>
                </div>

                <div class="rq-drawer__foot">
                    <button type="button" class="rq-link rq-link--danger" @click="askDelete([detail.id])">
                        <i class="far fa-trash-alt"></i> Xóa yêu cầu này
                    </button>
                </div>
            </aside>
        </transition>

        <!-- Xác nhận xóa -->
        <transition name="rq-fade">
            <div v-if="confirmDelete" class="rq-dialog-backdrop" @click.self="confirmDelete = null">
                <div class="rq-dialog" role="alertdialog" aria-modal="true">
                    <div class="rq-dialog__icon"><i class="fas fa-trash-alt"></i></div>
                    <h3>Xóa {{ confirmDelete.length > 1 ? `${confirmDelete.length} yêu cầu` : 'yêu cầu này' }}?</h3>
                    <p>Thông tin khách hàng sẽ bị xóa vĩnh viễn và không thể khôi phục.</p>
                    <div class="rq-dialog__actions">
                        <button type="button" class="rq-btn rq-btn--ghost" @click="confirmDelete = null">Hủy</button>
                        <button type="button" class="rq-btn rq-btn--danger-solid" :disabled="deleting" @click="doDelete">
                            <span v-if="deleting" class="spinner-border spinner-border-sm"></span> Xóa
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

// Thứ tự hiển thị theo luồng xử lý. Màu trạng thái luôn đi kèm icon + nhãn, không dùng màu đơn lẻ.
const STATUS_LIST = [
    {value: 0, label: 'Mới', icon: 'fa-bell', color: '#2f6fec'},
    {value: 2, label: 'Đang xử lý', icon: 'fa-hourglass-half', color: '#e8a10c'},
    {value: 1, label: 'Đã tư vấn', icon: 'fa-check-circle', color: '#0ca30c'},
    {value: 3, label: 'Không liên hệ được', icon: 'fa-phone-slash', color: '#d03b3b'},
];
const AVATAR_COLORS = ['#b21818', '#2f6fec', '#0e9384', '#7a5af8', '#dd2590', '#e8590c', '#3e4784', '#15803d'];
const RANGE_OPTIONS = [
    {value: 'all', label: 'Tất cả thời gian'},
    {value: 'today', label: 'Hôm nay'},
    {value: '7d', label: '7 ngày qua'},
    {value: '30d', label: '30 ngày qua'},
    {value: 'month', label: 'Tháng này'},
    {value: 'custom', label: 'Tùy chọn ngày...'},
];
const DEFAULT_FILTERS = {status: 'all', q: '', range: 'all', from: '', to: '', sort: 'newest', per_page: 20, page: 1};

function toDateInput(date) {
    const pad = n => String(n).padStart(2, '0');
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;
}

export default {
    name: "Request",
    data() {
        const q = this.$route.query;
        return {
            STATUS_LIST,
            rangeOptions: RANGE_OPTIONS,
            filters: {
                ...DEFAULT_FILTERS,
                status: q.status !== undefined && q.status !== 'all' ? Number(q.status) : 'all',
                q: q.q || '',
                range: q.range || 'all',
                from: q.from || '',
                to: q.to || '',
                sort: q.sort || 'newest',
                per_page: Number(q.per_page) || 20,
                page: Number(q.page) || 1,
            },
            searchInput: q.q || '',
            selectedIds: [],
            detail: null,
            noteDraft: '',
            savingNote: false,
            confirmDelete: null,
            deleting: false,
            exporting: false,
            refreshing: false,
            hoverDay: null,
            showDailyTable: false,
        };
    },
    computed: {
        ...mapGetters('request', ['requestList', 'requestStats', 'requestLoading']),
        list() {
            return this.requestList;
        },
        rows() {
            return this.list.data || [];
        },
        loading() {
            return this.requestLoading;
        },
        stats() {
            return this.requestStats;
        },
        // Tham số gửi lên server
        queryParams() {
            const f = this.filters;
            const params = {page: f.page, per_page: f.per_page, sort: f.sort};
            if (f.status !== 'all') params.status = f.status;
            if (f.q) params.q = f.q;
            const {from, to} = this.dateRange;
            if (from) params.from = from;
            if (to) params.to = to;
            return params;
        },
        dateRange() {
            const today = new Date();
            const daysAgo = n => toDateInput(new Date(today.getFullYear(), today.getMonth(), today.getDate() - n));
            switch (this.filters.range) {
                case 'today': return {from: daysAgo(0), to: daysAgo(0)};
                case '7d': return {from: daysAgo(6), to: daysAgo(0)};
                case '30d': return {from: daysAgo(29), to: daysAgo(0)};
                case 'month': return {from: toDateInput(new Date(today.getFullYear(), today.getMonth(), 1)), to: daysAgo(0)};
                case 'custom': return {from: this.filters.from, to: this.filters.to};
                default: return {from: '', to: ''};
            }
        },
        hasActiveFilters() {
            const f = this.filters;
            return f.status !== 'all' || !!f.q || f.range !== 'all';
        },
        statusTabs() {
            const counts = this.stats?.status || {};
            return [
                {value: 'all', label: 'Tất cả', count: this.stats?.total ?? 0},
                ...STATUS_LIST.map(s => ({...s, count: counts[s.value] ?? 0})),
            ];
        },
        statusBreakdown() {
            const total = this.stats?.total || 0;
            return STATUS_LIST.map(s => {
                const count = this.stats?.status?.[s.value] ?? 0;
                return {...s, count, percent: total ? Math.round(count / total * 100) : 0};
            });
        },
        sources() {
            const rows = this.stats?.sources || [];
            const max = Math.max(1, ...rows.map(r => r.total));
            return rows.map(r => ({...r, percent: Math.round(r.total / max * 100)}));
        },
        daily() {
            return this.stats?.daily || [];
        },
        dailyTotal() {
            return this.daily.reduce((sum, d) => sum + d.total, 0);
        },
        // Trục y: 4 khoảng chia, bước là số nguyên đẹp (1, 2, 5, 10, 20...)
        dailyStep() {
            const max = Math.max(1, ...this.daily.map(d => d.total));
            const raw = max / 4;
            const magnitude = Math.pow(10, Math.floor(Math.log10(raw)));
            const step = [1, 2, 5, 10].map(m => m * magnitude).find(v => v >= raw);
            return Math.max(1, step);
        },
        dailyMax() {
            const max = Math.max(1, ...this.daily.map(d => d.total));
            return Math.ceil(max / this.dailyStep) * this.dailyStep;
        },
        dailyTicks() {
            const ticks = [];
            for (let v = 0; v <= this.dailyMax; v += this.dailyStep) ticks.push(v);
            return ticks;
        },
        kpis() {
            const s = this.stats || {};
            const status = s.status || {};
            return [
                {
                    key: 'total', label: 'Tổng yêu cầu', icon: 'fas fa-inbox', value: this.formatNumber(s.total),
                    delta: this.compare(s.this_month, s.last_month), sub: `tháng này: ${s.this_month ?? 0}`,
                },
                {
                    key: 'new', label: 'Chờ liên hệ', icon: 'fas fa-bell', value: this.formatNumber(status[0]), accent: (status[0] || 0) > 0,
                    sub: (status[2] ? `+ ${status[2]} đang xử lý` : 'yêu cầu mới chưa xử lý'),
                    onClick: () => this.setStatusFilter(0),
                },
                {
                    key: 'today', label: 'Hôm nay', icon: 'fas fa-calendar-day', value: this.formatNumber(s.today),
                    delta: this.compare(s.today, s.yesterday), sub: `hôm qua: ${s.yesterday ?? 0}`,
                    onClick: () => this.setRange('today'),
                },
                {
                    key: 'week', label: '7 ngày qua', icon: 'fas fa-chart-line', value: this.formatNumber(s.last7),
                    delta: this.compare(s.last7, s.prev7), sub: 'so với tuần trước',
                    onClick: () => this.setRange('7d'),
                },
                {
                    key: 'rate', label: 'Tỉ lệ thành công', icon: 'fas fa-check-double',
                    value: s.done_rate === null || s.done_rate === undefined ? '—' : `${s.done_rate}%`,
                    sub: 'trên số đã xử lý xong',
                },
                {
                    key: 'response', label: 'Phản hồi TB', icon: 'fas fa-stopwatch',
                    value: s.avg_response_hours === null || s.avg_response_hours === undefined ? '—' : this.formatHours(s.avg_response_hours),
                    sub: 'từ lúc gửi đến khi xử lý',
                },
            ];
        },
        allOnPageSelected() {
            return this.rows.length > 0 && this.rows.every(r => this.selectedIds.includes(r.id));
        },
        someOnPageSelected() {
            return !this.allOnPageSelected && this.rows.some(r => this.selectedIds.includes(r.id));
        },
        pageNumbers() {
            const current = this.list.current_page, last = this.list.last_page;
            const pages = new Set([1, last, current - 1, current, current + 1].filter(p => p >= 1 && p <= last));
            const sorted = [...pages].sort((a, b) => a - b);
            const result = [];
            sorted.forEach((page, index) => {
                if (index && page - sorted[index - 1] > 1) result.push({key: `gap-${page}`, label: '…', value: null});
                result.push({key: page, label: page, value: page});
            });
            return result;
        },
    },
    watch: {
        searchInput(value) {
            clearTimeout(this.searchTimer);
            this.searchTimer = setTimeout(() => {
                this.filters.q = value.trim();
            }, 350);
        },
        // Đổi bộ lọc -> về trang 1
        'filters.status'() { this.filters.page = 1; },
        'filters.q'() { this.filters.page = 1; },
        'filters.range'(value) {
            this.filters.page = 1;
            if (value === 'custom' && !this.filters.from) {
                this.filters.from = this.dateRange.from || toDateInput(new Date(Date.now() - 29 * 864e5));
                this.filters.to = toDateInput(new Date());
            }
        },
        'filters.from'() { this.filters.page = 1; },
        'filters.to'() { this.filters.page = 1; },
        'filters.sort'() { this.filters.page = 1; },
        'filters.per_page'() { this.filters.page = 1; },
        queryParams: {
            handler() {
                this.syncUrl();
                this.loadList();
            },
            deep: true,
        },
    },
    created() {
        this.loadList();
        this.fetchStats();
    },
    mounted() {
        document.addEventListener('keydown', this.onKeydown);
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.onKeydown);
        clearTimeout(this.searchTimer);
    },
    methods: {
        ...mapActions('request', ['fetchRequests', 'fetchStats', 'updateRequest', 'bulkUpdate', 'deleteRequests', 'exportRequests']),

        // ---------- Dữ liệu ----------
        loadList() {
            return this.fetchRequests(this.queryParams);
        },
        async refreshAll() {
            this.refreshing = true;
            await Promise.all([this.loadList(), this.fetchStats()]);
            this.refreshing = false;
        },
        syncUrl() {
            const query = {};
            const f = this.filters;
            if (f.status !== 'all') query.status = String(f.status);
            if (f.q) query.q = f.q;
            if (f.range !== 'all') query.range = f.range;
            if (f.range === 'custom') {
                if (f.from) query.from = f.from;
                if (f.to) query.to = f.to;
            }
            if (f.sort !== 'newest') query.sort = f.sort;
            if (f.per_page !== 20) query.per_page = String(f.per_page);
            if (f.page > 1) query.page = String(f.page);
            this.$router.replace({query}).catch(() => {});
        },

        // ---------- Bộ lọc ----------
        setStatusFilter(value) {
            this.filters.status = value;
            this.scrollToList();
        },
        setRange(value) {
            this.filters.range = value;
            this.scrollToList();
        },
        resetFilters() {
            this.searchInput = '';
            Object.assign(this.filters, DEFAULT_FILTERS, {per_page: this.filters.per_page});
        },
        goToPage(page) {
            this.filters.page = page;
            this.scrollToList();
        },
        scrollToList() {
            this.$nextTick(() => {
                const el = this.$el.querySelector('.rq-list');
                if (el && el.getBoundingClientRect().top < 0) {
                    window.scrollTo({top: el.getBoundingClientRect().top + window.scrollY - 80, behavior: 'smooth'});
                }
            });
        },

        // ---------- Chọn ----------
        toggleSelectPage(event) {
            const ids = this.rows.map(r => r.id);
            this.selectedIds = event.target.checked
                ? [...new Set([...this.selectedIds, ...ids])]
                : this.selectedIds.filter(id => !ids.includes(id));
        },

        // ---------- Thao tác ----------
        async changeStatus(row, status) {
            if (row.status === status) return;
            const ok = await this.updateRequest({id: row.id, data: {status}, toast: this.$toast});
            if (ok) {
                if (this.detail && this.detail.id === row.id) {
                    this.detail = this.rows.find(r => r.id === row.id) || {...this.detail, status};
                }
                this.fetchStats();
                if (this.filters.status !== 'all') this.loadList();
            }
        },
        async bulkSetStatus(status) {
            const ok = await this.bulkUpdate({ids: this.selectedIds, status, toast: this.$toast});
            if (ok) {
                this.selectedIds = [];
                this.refreshAll();
            }
        },
        askDelete(ids) {
            this.confirmDelete = [...ids];
        },
        async doDelete() {
            this.deleting = true;
            const ids = this.confirmDelete;
            const ok = await this.deleteRequests({ids, toast: this.$toast});
            this.deleting = false;
            if (ok) {
                this.confirmDelete = null;
                this.selectedIds = this.selectedIds.filter(id => !ids.includes(id));
                if (this.detail && ids.includes(this.detail.id)) this.closeDetail();
                // Xóa hết dòng của trang cuối -> lùi một trang
                if (ids.length >= this.rows.length && this.filters.page > 1) this.filters.page--;
                this.refreshAll();
            }
        },
        async exportCsv() {
            this.exporting = true;
            const {page, per_page, ...params} = this.queryParams;
            await this.exportRequests({params, toast: this.$toast});
            this.exporting = false;
        },

        // ---------- Chi tiết ----------
        openDetail(row) {
            this.detail = {...row};
            this.noteDraft = row.note || '';
        },
        closeDetail() {
            if (this.detail && this.noteDraft !== (this.detail.note || '')
                && !window.confirm('Ghi chú chưa được lưu. Vẫn đóng?')) return;
            this.detail = null;
        },
        async saveNote() {
            this.savingNote = true;
            const ok = await this.updateRequest({id: this.detail.id, data: {note: this.noteDraft}, toast: this.$toast});
            this.savingNote = false;
            if (ok) this.detail = {...this.detail, note: this.noteDraft};
        },
        onKeydown(event) {
            if (event.key !== 'Escape') return;
            if (this.confirmDelete) this.confirmDelete = null;
            else if (this.detail) this.closeDetail();
        },

        // ---------- Hiển thị ----------
        statusMeta(value) {
            return STATUS_LIST.find(s => s.value === value) || STATUS_LIST[0];
        },
        initials(name) {
            const parts = (name || '?').trim().split(/\s+/);
            const last = parts[parts.length - 1] || '?';
            return (parts.length > 1 ? parts[0][0] + last[0] : last.slice(0, 2)).toUpperCase();
        },
        avatarColor(name) {
            let hash = 0;
            for (const char of name || '') hash = (hash * 31 + char.charCodeAt(0)) >>> 0;
            return AVATAR_COLORS[hash % AVATAR_COLORS.length];
        },
        formatPhone(phone) {
            const digits = (phone || '').replace(/\D/g, '');
            if (digits.length === 10) return digits.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
            return phone;
        },
        zaloLink(phone) {
            return `https://zalo.me/${(phone || '').replace(/\D/g, '')}`;
        },
        sourceLabel(source) {
            if (!source) return 'Không rõ';
            if (source === '/') return 'Trang chủ';
            const blog = source.match(/^\/blogs\/([^/?#]+)/);
            if (blog) return 'Bài: ' + decodeURIComponent(blog[1]).replace(/-/g, ' ');
            if (source.startsWith('/blogs')) return 'Danh sách bài viết';
            return source;
        },
        async copy(text) {
            try {
                await navigator.clipboard.writeText(text);
                this.$toast.open({message: 'Đã sao chép ' + text, type: 'success', position: 'top'});
            } catch (e) {
                window.prompt('Sao chép số điện thoại:', text);
            }
        },
        formatNumber(value) {
            return (value ?? 0).toLocaleString('vi-VN');
        },
        compare(current, previous) {
            current = current || 0;
            previous = previous || 0;
            if (!previous && !current) return null;
            if (!previous) return {type: 'up', text: 'mới'};
            const percent = Math.round((current - previous) / previous * 100);
            if (percent === 0) return {type: 'flat', text: '0%'};
            return {type: percent > 0 ? 'up' : 'down', text: `${Math.abs(percent)}%`};
        },
        formatHours(hours) {
            if (hours < 1) return `${Math.max(1, Math.round(hours * 60))} phút`;
            if (hours < 48) return `${Math.round(hours * 10) / 10} giờ`;
            return `${Math.round(hours / 24 * 10) / 10} ngày`;
        },
        formatDuration(from, to) {
            return this.formatHours((new Date(to) - new Date(from)) / 36e5);
        },
        formatDateTime(value) {
            if (!value) return '';
            const date = new Date(value);
            return date.toLocaleString('vi-VN', {hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit', year: 'numeric'});
        },
        timeAgo(value) {
            const diff = (Date.now() - new Date(value)) / 1000;
            if (diff < 60) return 'Vừa xong';
            if (diff < 3600) return `${Math.floor(diff / 60)} phút trước`;
            if (diff < 86400) return `${Math.floor(diff / 3600)} giờ trước`;
            if (diff < 86400 * 7) return `${Math.floor(diff / 86400)} ngày trước`;
            return new Date(value).toLocaleDateString('vi-VN');
        },
        formatDayShort(date) {
            const [, m, d] = date.split('-');
            return `${d}/${m}`;
        },
        formatDayLong(date) {
            const [y, m, d] = date.split('-').map(Number);
            return new Date(y, m - 1, d).toLocaleDateString('vi-VN', {weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric'});
        },
    },
}
</script>

<style scoped>
.rq-page {
    --brand: #b21818;
    --ink: #1f2937;
    --ink-2: #4b5563;
    --muted: #6b7280;
    --line: #e7e9ee;
    --surface: #fff;
    padding: 4px 24px 40px;
    color: var(--ink);
}

/* ---------- Tiêu đề ---------- */
.rq-head {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
}
.rq-title {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: var(--ink);
}
.rq-subtitle {
    margin: 4px 0 0;
    font-size: 14px;
    color: var(--muted);
}
.rq-head__actions {
    display: flex;
    gap: 8px;
}

/* ---------- Nút ---------- */
.rq-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 38px;
    padding: 0 14px;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: var(--surface);
    color: var(--ink-2);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
}
.rq-btn:hover:not(:disabled) {
    border-color: #cbd0d8;
    background: #f9fafb;
}
.rq-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
}
.rq-btn--primary {
    border-color: var(--brand);
    background: var(--brand);
    color: #fff;
}
.rq-btn--primary:hover:not(:disabled) {
    border-color: #961313;
    background: #961313;
}
.rq-btn--sm {
    height: 32px;
    padding: 0 10px;
    font-size: 13px;
}
.rq-btn--danger {
    color: #b42318;
}
.rq-btn--danger-solid {
    border-color: #d03b3b;
    background: #d03b3b;
    color: #fff;
}
.rq-btn--danger-solid:hover:not(:disabled) {
    background: #b42318;
}
.rq-link {
    padding: 0;
    border: 0;
    background: none;
    color: #2563eb;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}
.rq-link:hover {
    text-decoration: underline;
}
.rq-link--danger {
    color: #b42318;
}
.rq-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: 0;
    border-radius: 8px;
    background: transparent;
    color: var(--muted);
    cursor: pointer;
}
.rq-icon-btn:hover {
    background: #f3f4f6;
    color: var(--ink);
}
.rq-icon-btn--danger:hover {
    background: #fdecec;
    color: #b42318;
}

/* ---------- Thẻ số liệu ---------- */
.rq-kpis {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}
.rq-kpi {
    display: flex;
    gap: 12px;
    padding: 16px;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: var(--surface);
    transition: border-color .15s, box-shadow .15s;
}
.rq-kpi--clickable {
    cursor: pointer;
}
.rq-kpi--clickable:hover {
    border-color: #cbd0d8;
    box-shadow: 0 6px 18px -12px rgba(15, 23, 42, .35);
}
.rq-kpi--accent {
    border-color: #f3c0c0;
    background: linear-gradient(135deg, #fff 0%, #fff5f5 100%);
}
.rq-kpi__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #f3f4f6;
    color: var(--ink-2);
    font-size: 16px;
}
.rq-kpi--accent .rq-kpi__icon {
    background: var(--brand);
    color: #fff;
}
.rq-kpi__body {
    min-width: 0;
}
.rq-kpi__label {
    font-size: 13px;
    color: var(--muted);
}
.rq-kpi__value {
    margin: 2px 0;
    font-size: 26px;
    font-weight: 700;
    line-height: 1.2;
    color: var(--ink);
    font-variant-numeric: tabular-nums;
}
.rq-kpi__sub {
    font-size: 12px;
    color: var(--muted);
}
.rq-delta {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    margin-right: 4px;
    padding: 1px 6px;
    border-radius: 999px;
    font-weight: 700;
}
.rq-delta i {
    font-size: 10px;
}
.rq-delta.up { background: #e8f8e8; color: #0b6b0b; }
.rq-delta.down { background: #fdecec; color: #a12b2b; }
.rq-delta.flat { background: #f3f4f6; color: var(--ink-2); }

/* ---------- Thẻ ---------- */
.rq-card {
    padding: 18px 20px;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: var(--surface);
}
.rq-card__head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 14px;
}
.rq-card__head--sub {
    align-items: center;
    margin: 20px 0 10px;
    padding-top: 16px;
    border-top: 1px solid #f0f1f4;
}
.rq-card__title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
}
.rq-card__desc {
    margin: 2px 0 0;
    font-size: 12.5px;
    color: var(--muted);
}

/* ---------- Biểu đồ cột theo ngày ---------- */
.rq-charts {
    display: grid;
    grid-template-columns: minmax(0, 2fr) minmax(0, 1fr) minmax(0, 1fr);
    gap: 14px;
    margin-bottom: 18px;
}
.rq-bars {
    position: relative;
    height: 240px;
    padding: 8px 0 26px 32px;
}
.rq-bars__grid {
    position: absolute;
    inset: 8px 0 26px 32px;
    pointer-events: none;
}
.rq-bars__gridline {
    position: absolute;
    left: 0;
    right: 0;
    border-top: 1px solid #eef0f3;
}
.rq-bars__gridline span {
    position: absolute;
    right: calc(100% + 8px);
    top: -8px;
    font-size: 11px;
    color: var(--muted);
    font-variant-numeric: tabular-nums;
}
.rq-bars__plot {
    position: relative;
    display: flex;
    align-items: flex-end;
    height: 100%;
    gap: 2px;
}
.rq-bars__slot {
    position: relative;
    flex: 1;
    height: 100%;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    cursor: default;
}
.rq-bars__bar {
    width: 100%;
    max-width: 24px;
    min-height: 0;
    border-radius: 4px 4px 0 0;
    background: #d9898a;
    transition: background-color .12s;
}
.rq-bars__slot:hover .rq-bars__bar,
.rq-bars__bar.active {
    background: var(--brand);
}
.rq-bars__x {
    position: absolute;
    top: calc(100% + 6px);
    font-size: 11px;
    color: var(--muted);
    white-space: nowrap;
}
.rq-tooltip {
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%;
    z-index: 5;
    transform: translateX(-50%);
    padding: 8px 10px;
    border-radius: 8px;
    background: #111827;
    color: #fff;
    white-space: nowrap;
    pointer-events: none;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .2);
}
.rq-bars__slot .rq-tooltip {
    bottom: auto;
    top: 0;
}
.rq-tooltip--left {
    left: auto;
    right: 0;
    transform: none;
}
.rq-tooltip--right {
    left: 0;
    transform: none;
}
.rq-tooltip__label {
    font-size: 11px;
    color: #d1d5db;
}
.rq-tooltip__value {
    font-size: 14px;
    font-weight: 700;
}
.rq-day-table {
    max-height: 240px;
    overflow-y: auto;
}
.rq-day-table table {
    width: 100%;
    font-size: 13px;
}
.rq-day-table th,
.rq-day-table td {
    padding: 6px 4px;
    border-bottom: 1px solid #f0f1f4;
}
.rq-day-table th {
    position: sticky;
    top: 0;
    background: #fff;
    color: var(--muted);
    font-weight: 600;
}

/* ---------- Phân bố ---------- */
.rq-breakdown {
    margin: 0;
    padding: 0;
    list-style: none;
}
.rq-breakdown li {
    padding: 6px 8px;
    margin: 0 -8px;
    border-radius: 8px;
}
.rq-breakdown li[role="button"] {
    cursor: pointer;
}
.rq-breakdown li[role="button"]:hover {
    background: #f9fafb;
}
.rq-breakdown__row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 5px;
    font-size: 13px;
}
.rq-breakdown__label {
    color: var(--ink-2);
}
.rq-breakdown__label i {
    width: 16px;
    margin-right: 6px;
    text-align: center;
}
.rq-breakdown__value {
    flex-shrink: 0;
    font-weight: 700;
    color: var(--ink);
    font-variant-numeric: tabular-nums;
}
.rq-breakdown__value small {
    font-weight: 400;
    color: var(--muted);
}
.rq-meter {
    height: 8px;
    border-radius: 4px;
    background: #f1f3f6;
    overflow: hidden;
}
.rq-meter div {
    height: 100%;
    border-radius: 0 4px 4px 0;
    background: #94a3b8;
    transition: width .3s;
}
.rq-breakdown--compact li {
    padding: 4px 8px;
}
.rq-breakdown--compact .rq-meter {
    height: 6px;
}
.rq-ellipsis {
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.rq-empty-text {
    margin: 0;
    font-size: 13px;
    color: var(--muted);
}

/* ---------- Danh sách ---------- */
.rq-list {
    padding: 0;
    overflow: hidden;
}
.rq-tabs {
    display: flex;
    gap: 4px;
    padding: 0 12px;
    border-bottom: 1px solid var(--line);
    overflow-x: auto;
}
.rq-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 14px 10px 12px;
    border: 0;
    border-bottom: 2px solid transparent;
    background: none;
    color: var(--muted);
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
}
.rq-tab:hover {
    color: var(--ink);
}
.rq-tab.active {
    border-bottom-color: var(--brand);
    color: var(--ink);
}
.rq-tab__count {
    padding: 0 7px;
    border-radius: 999px;
    background: #f1f3f6;
    color: var(--ink-2);
    font-size: 12px;
    line-height: 20px;
}
.rq-tab.active .rq-tab__count {
    background: var(--brand);
    color: #fff;
}
.rq-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    padding: 14px 20px;
}
.rq-search {
    position: relative;
    flex: 1 1 280px;
}
.rq-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
}
.rq-search input {
    width: 100%;
    height: 38px;
    padding: 0 12px 0 34px;
    border: 1px solid var(--line);
    border-radius: 10px;
    font-size: 14px;
    outline: none;
}
.rq-search input:focus,
.rq-select:focus,
.rq-textarea:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .15);
}
.rq-select {
    height: 38px;
    padding: 0 10px;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: #fff;
    color: var(--ink-2);
    font-size: 14px;
    outline: none;
}
.rq-select--sm {
    height: 32px;
    font-size: 13px;
}
.rq-filters__sep {
    color: var(--muted);
}

.rq-bulk {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin: 0 20px 12px;
    padding: 10px 14px;
    border-radius: 10px;
    background: #eef4ff;
    font-size: 14px;
}
.rq-bulk__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
}
.rq-bulk__label {
    font-size: 13px;
    color: var(--muted);
}

/* ---------- Bảng ---------- */
.rq-table-wrap {
    overflow-x: auto;
}
.rq-table {
    width: 100%;
    min-width: 980px;
    border-collapse: collapse;
    font-size: 14px;
}
.rq-table th {
    padding: 10px 12px;
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
    background: #f9fafb;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .03em;
    text-transform: uppercase;
    text-align: left;
    white-space: nowrap;
}
.rq-table td {
    padding: 12px;
    border-bottom: 1px solid #f0f1f4;
    vertical-align: top;
}
.rq-row {
    cursor: pointer;
    transition: background-color .12s;
}
.rq-row:hover {
    background: #fafbfc;
}
.rq-row--new td:first-child {
    box-shadow: inset 3px 0 0 #2f6fec;
}
.rq-row--selected {
    background: #f5f8ff;
}
.rq-loading {
    opacity: .55;
    transition: opacity .15s;
}
.rq-col-check {
    width: 44px;
    padding-left: 20px !important;
}
.rq-col-check input {
    width: 16px;
    height: 16px;
    cursor: pointer;
}
.rq-col-content {
    min-width: 240px;
    max-width: 380px;
    color: var(--ink-2);
}
.rq-col-content .rq-source {
    margin-top: 6px;
}
.rq-col-time {
    white-space: nowrap;
    color: var(--ink-2);
}
.rq-col-time small {
    display: block;
    color: #9ca3af;
}
.rq-col-actions {
    width: 84px;
    white-space: nowrap;
    text-align: right;
    padding-right: 16px !important;
}
.rq-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.rq-customer {
    display: flex;
    align-items: center;
    gap: 10px;
}
.rq-customer__info {
    min-width: 0;
}
.rq-customer__name {
    font-weight: 700;
    color: var(--ink);
}
.rq-customer__sub {
    font-size: 12.5px;
    color: var(--muted);
}
.rq-customer__note {
    max-width: 220px;
    margin-top: 2px;
    overflow: hidden;
    font-size: 12px;
    color: #92400e;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.rq-avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
}
.rq-avatar--lg {
    width: 48px;
    height: 48px;
    font-size: 16px;
}
.rq-phone__number {
    font-weight: 600;
    color: var(--ink);
    white-space: nowrap;
    font-variant-numeric: tabular-nums;
}
.rq-phone__actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 4px;
    font-size: 12px;
}
.rq-phone__actions a,
.rq-phone__actions button {
    padding: 0;
    border: 0;
    background: none;
    color: var(--muted);
    cursor: pointer;
}
.rq-phone__actions a:hover,
.rq-phone__actions button:hover {
    color: var(--ink);
}
.rq-zalo,
.rq-zalo-text {
    font-weight: 800;
    color: #0068ff !important;
}
.rq-source {
    display: inline-block;
    max-width: 260px;
    padding: 2px 8px;
    overflow: hidden;
    border-radius: 6px;
    background: #f3f4f6;
    color: var(--ink-2);
    font-size: 12px;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: top;
}

/* Trạng thái: luôn có icon + nhãn */
.rq-status-select,
.rq-badge {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    white-space: nowrap;
}
.rq-badge {
    padding: 3px 10px;
}
.rq-status-select {
    padding: 0 26px 0 10px;
    height: 28px;
}
.rq-status-select select {
    padding: 0;
    border: 0;
    outline: none;
    background: transparent;
    color: inherit;
    font-weight: 700;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
}
.rq-status-select__caret {
    position: absolute;
    right: 10px;
    font-size: 9px;
    pointer-events: none;
}
.rq-status--0 { background: #eef4ff; color: #1f4fbf; }
.rq-status--2 { background: #fff6e0; color: #8a5a00; }
.rq-status--1 { background: #e8f8e8; color: #0b6b0b; }
.rq-status--3 { background: #fdecec; color: #a12b2b; }

.rq-skeleton-row td {
    padding: 14px 20px;
}
.rq-sk {
    height: 18px;
    border-radius: 6px;
    background: linear-gradient(90deg, #f1f1f1 25%, #e8e8e8 37%, #f1f1f1 63%);
    background-size: 400% 100%;
    animation: rq-shine 1.4s ease infinite;
}
@keyframes rq-shine {
    0% { background-position: 100% 50%; }
    100% { background-position: 0 50%; }
}
.rq-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 48px 12px;
    color: var(--muted);
    text-align: center;
}
.rq-empty i {
    font-size: 36px;
    color: #cbd0d8;
}
.rq-empty b {
    color: var(--ink);
}

/* ---------- Phân trang ---------- */
.rq-pagination {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 14px 20px;
    font-size: 13px;
    color: var(--muted);
}
.rq-pagination__controls {
    display: flex;
    align-items: center;
    gap: 4px;
}
.rq-pagination__controls select {
    margin-right: 8px;
}
.rq-page-btn {
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border: 1px solid var(--line);
    border-radius: 8px;
    background: #fff;
    color: var(--ink-2);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}
.rq-page-btn:disabled {
    opacity: .45;
    cursor: default;
}
.rq-page-btn.active {
    border-color: var(--brand);
    background: var(--brand);
    color: #fff;
}

/* ---------- Bảng chi tiết ---------- */
.rq-overlay {
    position: fixed;
    inset: 0;
    z-index: 1040;
    background: rgba(15, 23, 42, .35);
}
.rq-drawer {
    position: fixed;
    top: 0;
    right: 0;
    z-index: 1045;
    display: flex;
    flex-direction: column;
    width: min(460px, 100vw);
    height: 100vh;
    background: #fff;
    box-shadow: -16px 0 40px rgba(15, 23, 42, .2);
}
.rq-drawer__head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    padding: 20px;
    border-bottom: 1px solid var(--line);
}
.rq-drawer__name {
    margin-bottom: 4px;
    font-size: 18px;
    font-weight: 700;
    color: var(--ink);
}
.rq-drawer__body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
}
.rq-drawer__foot {
    padding: 14px 20px;
    border-top: 1px solid var(--line);
}
.rq-quick {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
    gap: 8px;
    margin-bottom: 20px;
}
.rq-quick__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    height: 40px;
    border: 1px solid var(--line);
    border-radius: 10px;
    color: var(--ink);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none !important;
}
.rq-quick__btn:hover {
    border-color: #cbd0d8;
    background: #f9fafb;
    color: var(--ink);
}
.rq-info {
    display: grid;
    grid-template-columns: 110px 1fr;
    gap: 10px 12px;
    margin: 0 0 20px;
    font-size: 14px;
}
.rq-info dt {
    font-weight: 400;
    color: var(--muted);
}
.rq-info dd {
    margin: 0;
    color: var(--ink);
    word-break: break-word;
}
.rq-info dd .rq-link {
    margin-left: 8px;
}
.rq-block {
    margin-bottom: 20px;
}
.rq-block__title {
    margin-bottom: 8px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    color: var(--muted);
}
.rq-message {
    padding: 14px;
    border-radius: 10px;
    background: #f9fafb;
    color: var(--ink);
    font-size: 14px;
    line-height: 1.6;
    white-space: pre-line;
}
.rq-segment {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.rq-segment button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    border: 2px solid var(--line);
    border-radius: 10px;
    background: #fff;
    color: var(--ink-2);
    font-size: 13px;
    font-weight: 600;
    text-align: left;
    cursor: pointer;
}
.rq-segment button.active {
    background: #fafafa;
    color: var(--ink);
}
.rq-textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--line);
    border-radius: 10px;
    font-size: 14px;
    outline: none;
    resize: vertical;
}
.rq-block__actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: 8px;
}

/* ---------- Hộp xác nhận ---------- */
.rq-dialog-backdrop {
    position: fixed;
    inset: 0;
    z-index: 1060;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    background: rgba(15, 23, 42, .45);
}
.rq-dialog {
    width: min(400px, 100%);
    padding: 24px;
    border-radius: 16px;
    background: #fff;
    text-align: center;
    box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
}
.rq-dialog__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    margin-bottom: 12px;
    border-radius: 50%;
    background: #fdecec;
    color: #d03b3b;
    font-size: 20px;
}
.rq-dialog h3 {
    margin: 0 0 6px;
    font-size: 18px;
    font-weight: 700;
    color: var(--ink);
}
.rq-dialog p {
    margin: 0 0 20px;
    font-size: 14px;
    color: var(--muted);
}
.rq-dialog__actions {
    display: flex;
    justify-content: center;
    gap: 8px;
}

/* ---------- Hiệu ứng ---------- */
.rq-fade-enter-active,
.rq-fade-leave-active {
    transition: opacity .2s;
}
.rq-fade-enter-from,
.rq-fade-leave-to {
    opacity: 0;
}
.rq-slide-enter-active,
.rq-slide-leave-active {
    transition: transform .25s ease;
}
.rq-slide-enter-from,
.rq-slide-leave-to {
    transform: translateX(100%);
}

@media (max-width: 1699px) {
    .rq-kpis {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    .rq-charts {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .rq-chart {
        grid-column: 1 / -1;
    }
}
@media (max-width: 767px) {
    .rq-charts {
        grid-template-columns: minmax(0, 1fr);
    }
}
@media (max-width: 575px) {
    .rq-kpis {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
    .rq-kpi {
        flex-direction: column;
        gap: 8px;
        padding: 12px;
    }
    .rq-kpi__value {
        font-size: 22px;
    }
}
@media (max-width: 767px) {
    .rq-page {
        padding: 0 12px 32px;
    }
    .rq-filters {
        padding: 12px;
    }
    .rq-bars {
        height: 200px;
    }
    .rq-info {
        grid-template-columns: 1fr;
        gap: 2px;
    }
    .rq-info dd {
        margin-bottom: 8px;
    }
}
</style>

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cài đặt chung của web, sửa trong admin: /admin/settings
        $data = [
            // Nút mạng xã hội nổi bên phải
            'social_tiktok' => 'https://www.tiktok.com/@du.hc.smartedu',
            'social_facebook' => 'https://www.facebook.com/profile.php?id=61555208818668',
            'social_zalo' => 'https://zalo.me/0329155366',

            // Footer
            'footer_intro' => 'Du học SMARTEDU có 4 năm kinh nghiệm trong lĩnh vực du học cả ở thị trường Việt Nam và Hàn Quốc',
            'footer_tiktok' => 'https://www.tiktok.com/@smarteduchuyn.du',
            'footer_facebook' => 'https://www.facebook.com/profile.php?id=61555208818668',
            'footer_zalo' => 'https://zalo.me/0328021619',
            'footer_services' => "Du học Hàn Quốc\nLên chuyên ngành\nTìm việc và đổi visa",
            'footer_office_vn' => "CN1: Số 48, đường Nguyễn Khang, quận Cầu Giấy, Hà Nội\nCN2: 358/1, đường Bắc Kạn, Tổ 5 Hoàng Văn Thụ, TP Thái Nguyên",
            'footer_office_kr' => 'Địa chỉ: Tầng 2, 572-1, Changsin-dong, Jongno-gu, Seoul',
            'contact_phone_kr' => '(+82)10 2253 9715',
            'contact_phone_vn' => '0329 155 366',
            'contact_zalo' => '0329 155 366',
            'contact_email' => 'duhochanquoc.smartedu@gmail.com',
            'footer_map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.2802340463045!2d105.79750437343355!3d21.021470288032482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab5c841661ef%3A0x50d07b06ce1fd6fe!2zNDggxJAuIE5ndXnhu4VuIEtoYW5nLCBZw6puIEhvw6AsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1717644148353!5m2!1sen!2s',
            'footer_copyright' => 'DU HỌC HÀN QUỐC SMARTEDU',
        ];

        // Chỉ thêm key còn thiếu, không ghi đè những gì admin đã sửa
        foreach ($data as $key => $value) {
            Setting::query()->firstOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }
    }
}

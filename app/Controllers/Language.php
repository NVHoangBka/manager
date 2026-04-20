<?php
namespace App\Controllers;

class Language extends BaseController {
    public function switch($lang) {
        if(in_array($lang, ['vi','en','ko'])) {
            // Lưu vào session
            session()->set('lang', $lang);
            
            // Thay đổi locale ngay lập tức
            \Config\Services::language()->setLocale($lang);
            
            // Lưu locale vào session để các request sau dùng luôn
            session()->set('locale', $lang);
        }
        
        return redirect()->back();
    }
}
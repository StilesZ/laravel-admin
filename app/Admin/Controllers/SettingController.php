<?php

namespace App\Admin\Controllers;
use App\AppConfig;
use App\Language;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\App;

class SettingController extends AdminController
{

    public function setLanguage($id){

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('admin')->with([
                'message' => 'This Option Is Disable In Demo Mode',
                'message_important' => true
            ]);
        }

        $lang = Language::find($id);
        if ($lang) {
            App::setLocale($lang->language_code);
            AppConfig::where('name', '=', 'Language')->update(['value' => $id]);
            return redirect('/admin')->with([
                'message' => language_data('Language updated Successfully')
            ]);
        } else {
            return redirect('/admin')->with([
                'message' => language_data('Language not found'),
                'message_important' => true
            ]);
        }
    }
}

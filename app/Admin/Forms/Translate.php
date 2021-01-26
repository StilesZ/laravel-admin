<?php

namespace App\Admin\Forms;

use App\Language;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Translate extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '翻译';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());

        if(request()->isMethod('post')){

            $english_data   = request()->english_data;
            $translate_data = request()->translate_data;
            if (count($english_data) !== count($translate_data)) {
                admin_toastr(__('Please Set max_input_vars in php.ini to 2500'));
                return back();
            }
        }

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        if (request()->isMethod('get')){
            $lid = request()->id;
            $lang = Language::find($lid);
            $lan_name = $lang->language;

            $path = resource_path('lang/'.$lang->language_code.'.json');
            $json_string = file_get_contents($path);
            $lan_data = json_decode($json_string, true);

            $this->html(view('admin.translation', compact('lan_name', 'lan_data', 'lid')));
        }else if(request()->isMethod('post')){
            $lid = request()->lan_id;
            $code = Language::find($lid)->language_code;
            $english_data   = request()->english_data;
            $translate_data = request()->translate_data;
            $lan_data = array_combine($english_data, $translate_data);
            $config = json_encode($lan_data,JSON_UNESCAPED_UNICODE);
            write_file(resource_path('lang'),$code.'.json', $config);
        }

    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'name'       => 'dfd',
            'translate'      => 'John.Doe@gmail.com',
        ];
    }
}

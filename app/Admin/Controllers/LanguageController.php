<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Translate;
use App\Language;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;

class LanguageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '语言';


    public function index(Content $content)
    {
        return $content
            ->title(trans('admin.menu'))
            ->description(trans('admin.list'))
            ->row(function (Row $row) {

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('languages'));

                    $form->select('language_code', __('Language'))->options($this->language());
                    $form->image('icon', trans('Icon'))->move('country_flag');
                    $form->radioCard('status', trans('Status'))->options(['1' => __('Active'), '0'=> __('Inactive')])->default('1');

                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });

                $row->column(6, $this->grid()->render());

            });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Language());

//        $grid->column('id', __('Id'));
        $grid->column('language', __('Language'));
        $grid->column('status', __('Status'))->using(['1' => __('Active'), '0' => __('Inactive')]);
        $grid->column('icon', __('Icon'))->image();
        $grid->column('sort', __('Sort'))->sortable();
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // append一个操作
//            $actions->append('<a href="http://lar-dmin.com/admin/languages/1/edit" class="grid-row-trans"><i class="fa fa-translate"></i></a>');
            $actions->prepend('<a href="http://lar-dmin.com/admin/translate/'.$actions->getKey().'"><i class="fa fa-language"></i></a>');

//            $actions->add(new Translate());
            }
        );
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Language::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('language', __('Language'));
        $show->field('status', __('Status'));
        $show->field('language_code', __('Language code'));
        $show->field('icon', __('Icon'));
        $show->field('sort', __('Sort'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Language());

        $form->display('id', __('Id'));
        $form->hidden('language');
        $form->select('language_code', __('Language'))->options($this->language());

        $form->radioCard('status', __('Status'))->options(['1' => __('Active'), '0'=> __('Inactive')])->default('1');

        $form->image('icon', __('Icon'))->move('country_flag');
        $form->number('sort', __('Sort'));

        $form->ignore(['language']);
        $form->saving(function (Form $form) {
            $data = $this->language();
            $form->language = $data[$form->language_code];
            $path = resource_path('lang/zh-CN.json');
            $lan_data = file_get_contents($path);
            write_file(resource_path('lang'),$form->language_code.'.json', $lan_data);
        });

        return $form;
    }

    public function translate(Content $content)
    {
//        return $content
//            ->title('翻译')
//            ->body(new Translate());

        if (request()->isMethod('post')){

            request()->all();

            if(request()->id != request()->lan_id){
                admin_toastr(__('ID Error'));
                return redirect('admin/translate/'.request()->id)
                    ->withErrors(__('ID Error'))
                    ->withInput();
            }

            $english_data   = request()->english_data;
            $translate_data = request()->translate_data;
            if (count($english_data) !== count($translate_data)) {
                return redirect('/admin/translate/'.request()->id)
                    ->withErrors(__('Please Set max_input_vars in php.ini to 2500'))
                    ->withInput();
            }

            $lid = request()->lan_id;
            $code = Language::find($lid)->language_code;
            $english_data   = request()->english_data;
            $translate_data = request()->translate_data;
            $lan_data = array_combine($english_data, $translate_data);
            $config = json_encode($lan_data,JSON_UNESCAPED_UNICODE);
            write_file(resource_path('lang'),$code.'.json', $config);

            return redirect('admin/languages')->with([
                'message' => language_data('Language Translate Successfully')
            ]);
        }else{
            $lid = request()->id;
            $lang = Language::find($lid);
            $lan_name = $lang->language;

            $path = resource_path('lang/'.$lang->language_code.'.json');
            $json_string = file_get_contents($path);
            $lan_data = json_decode($json_string, true);

            $orderView = view('admin.translation',compact('lan_name', 'lan_data', 'lid'))->render();

            return $content
                ->header('翻译')
                ->description('翻译')
                ->body($orderView);
        }

    }

    protected function language(){
        $lang = [
            "af" => 'Afrikaans',
            "sq" => 'Albanian',
            "am" => 'Amharic',
            "ar" => 'Arabic',
            "hy" => 'Armenian',
            "az" => 'Azerbaijan',
            "bn" => 'Bengali',
            "eu" => 'Basque',
            "be" => 'Belarusian',
            "bg" => 'Bulgarian',
            "ca" => 'Catalan',
            "zh-CN" => 'Chinese',
            "hr" => 'Croatian',
            "cs" => 'Czech',
            "da" => 'Danish',
            "nl" => 'Dutch',
            "en" => 'English',
            "et" => 'Estonian',
            "fi" => 'Finnish',
            "fr" => 'French',
            "gl" => 'Galician',
            "ka" => 'Georgian',
            "de" => 'German',
            "el" => 'Greek',
            "gu" => 'Gujarati',
            "he" => 'Hebrew',
            "hi" => 'Hindi',
            "hu" => 'Hungarian',
            "is" => 'Icelandic',
            "id" => 'Indonesian',
            "ga" => 'Irish',
            "it" => 'Italian',
            "ja" => 'Japanese',
            "kk" => 'Kazakh',
            "ko" => 'Korean',
            "lv" => 'Latvian',
            "lt" => 'Lithuanian',
            "mk" => 'Macedonian',
            "ms" => 'Malay',
            "mn" => 'Mongolian',
            "ne" => 'Nepali',
            "nb" => 'Norwegian-Bokmal',
            "nn" => 'Norwegian-Nynorsk',
            "fa" => 'Persian',
            "pl" => 'Polish',
            "pt" => 'Portuguese',
            "ro" => 'Romanian',
            "ru" => 'Russian',
            "sr" => 'Serbian',
            "si" => 'Sinhala',
            "sk" => 'Slovak',
            "sl" => 'Slovenian',
            "es" => 'Spanish',
            "sw" => 'Swahili',
            "sv" => 'Swedish',
            "ta" => 'Tamil',
            "te" => 'Telugu',
            "th" => 'Thai',
            "tr" => 'Turkish',
            "uk" => 'Ukrainian',
            "ur" => 'Urdu',
            "uz" => 'Uzbek',
            "vi" => 'Vietnamese',
            "cy" => 'Welsh'
        ];

         return $lang;
    }
}

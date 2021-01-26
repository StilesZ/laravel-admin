<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('users', 'UserController');

    $router->resource('app-configs', 'ConfigController');

    $router->resource('languages', LanguageController::class);

    $router->get('language/change/{id}', 'SettingController@setLanguage');

    $router->match(['get', 'post'],'translate/{id}', 'LanguageController@translate');
});


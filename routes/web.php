<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dangnhap','UserController@getDangnhapAdmin');
Route::post('admin/dangnhap','UserController@postDangnhapAdmin');
Route::get('admin/logout','UserController@getDangXuatAdmin');

Route::group(['prefix' => 'admin','middleware'=>'adminLogin'],function(){
    Route::group(['prefix'=>'theloai'],function(){
        //admin/theloai/them
        Route::get('danhsach','TheLoaiController@index');

        Route::get('sua/{theloai}','TheLoaiController@edit');
        Route::post('sua/{theloai}','TheLoaiController@update');

        Route::get('them','TheLoaiController@create');
        Route::post('them','TheLoaiController@store');

        Route::get('xoa/{theloai}','TheLoaiController@destroy');
    });

    Route::group(['prefix'=>'loaitin'],function(){
        //admin/loaitin/them
        Route::get('danhsach','LoaiTinController@index');

        Route::get('sua/{loaitin}','LoaiTinController@edit');
        Route::post('sua/{loaitin}','LoaiTinController@update');

        Route::get('them','LoaiTinController@create');
        Route::post('them','LoaiTinController@store');

        Route::get('xoa/{loaitin}','LoaiTinController@destroy');
    });

    Route::group(['prefix'=>'tintuc'],function(){
        //admin/tintuc/them
        Route::get('danhsach','TinTucController@index');

        Route::get('sua/{tintuc}','TinTucController@edit');
        Route::post('sua/{tintuc}','TinTucController@update');

        Route::get('them','TinTucController@create');
        Route::post('them','TinTucController@store');

        Route::get('xoa/{tintuc}','TinTucController@destroy');
    });

    Route::group(['prefix'=>'slide'],function(){
        //admin/slide/them
        Route::get('danhsach','SlideController@index');

        Route::get('sua/{slide}','SlideController@edit');
        Route::post('sua/{slide}','SlideController@update');

        Route::get('them','SlideController@create');
        Route::post('them','SlideController@store');

        Route::get('xoa/{slide}','slideController@destroy');
    });

    Route::group(['prefix'=>'user'],function(){
        //admin/user/them
        Route::get('danhsach','UserController@index');

        Route::get('sua/{user}','UserController@edit');
        Route::post('sua/{user}','UserController@update');

        Route::get('them','UserController@create');
        Route::post('them','UserController@store');

        Route::get('xoa/{user}','UserController@destroy');
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::get('xoa/{comment}/{tintuc}','CommentConTroller@destroy');
    });

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('loaitin/{idTheLoai}','AjaxConTroller@getLoaiTin');
    });
});
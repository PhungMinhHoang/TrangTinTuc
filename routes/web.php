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

Route::get('thu',function(){
//     $theloai = TheLoai::find(1);
//     foreach ($theloai->loaitin as $loaitin) {
//         # code...
//         echo $loaitin->Ten."<br>";
//     }
    return view('admin.theloai.danhsach');
});

Route::group(['prefix' => 'admin'],function(){
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
        Route::get('danhsach','LoaiTinController@getDanhSach');
        Route::get('sua','LoaiTinController@getSua');
        Route::get('them','LoaiTinController@getThem');
    });

    Route::group(['prefix'=>'tintuc'],function(){
        //admin/tintuc/them
        Route::get('danhsach','TinTucController@getDanhSach');
        Route::get('sua','TinTucController@getSua');
        Route::get('them','TinTucController@getThem');
    });
});
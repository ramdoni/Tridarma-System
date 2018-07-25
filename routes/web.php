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

Route::get('/', function () 
{
    if (!Auth::check() && !Request::is('login')) {
    	return redirect('login');
	}else{
		return redirect('dashboard'); //view('home')->with($params);
	}
});

Route::get('home', function(){
	if (!Auth::check() && !Request::is('login')) {
    	return redirect('login');
	}else{
		return redirect('dashboard'); //return view('home')->with($params);
	}
})->name('home');

Auth::routes();

// ROUTING FINANCE
Route::group(['middleware' => ['auth', 'access:3']], function(){
	/**
	 * Finance Routing
	 */
	//Route::get('finance', 'Finance\IndexController@index')->name('finance.index');
});

// ROUTING LOGIN
Route::group(['middleware' => ['auth']], function(){
	/**
	 * Ajax
	 */
	Route::post('ajax/submit-value-aktiva', 'AjaxController@submitValueAktiva')->name('ajax.submit_value_aktiva');
	Route::post('ajax/submit-value-pasiva', 'AjaxController@submitValuePasiva')->name('ajax.submit_value_pasiva');
	Route::post('ajax/submit-value-biaya', 'AjaxController@submitValueBiaya')->name('ajax.submit_value_biaya');
	Route::post('ajax/submit-value-pendapatan', 'AjaxController@submitValuePendapatan')->name('ajax.submit_value_pendapatan'); 
	Route::post('ajax/submit-cicilan-active', 'AjaxController@submitCicilan')->name('ajax.submit_cicilan_active');
	Route::post('ajax/submit-submit-simpanan-pokok', 'AjaxController@submitSimpananPokok')->name('ajax.submit_simpanan_pokok');
	Route::post('ajax/submit-simpanan-wajib', 'AjaxController@submitSimpananWajib')->name('ajax.submit_simpanan_wajib');
	Route::post('ajax/submit-simpanan-sukarela', 'AjaxController@submitSimpananSukarela')->name('ajax.submit_simpanan_sukarela');
	Route::post('ajax/submit_premi_asuransi', 'AjaxController@submitPremiAsuransi')->name('ajax.submit_premi_asuransi');
	Route::post('ajax/submit_ahli_waris', 'AjaxController@submitAhliWaris')->name('ajax.submit_ahli_waris');
});

// ROUTING ADMIN
Route::group(['middleware' => ['auth', 'access:1']], function(){

	Route::get('topup', 'AnggotaController@topup')->name('topup');

	Route::get('finance', 'Finance\IndexController@index')->name('finance.index');

	Route::get('dashboard', 'IndexController@index');
	Route::get('kwitansi/{id}', 'IndexController@kwitansi')->name('kwitansi');

	/**
	 * Routing anggota
	 */
	Route::resource('anggota', 'AnggotaController', ['only'=> ['index','create','store', 'edit','destroy','update']]);
	Route::get('anggota/detail/{id}', 'AnggotaController@detail')->name('anggota.detail');
	Route::get('anggota/add-pinjaman/{id}', 'AnggotaController@add_pinjaman')->name('anggota.add-pinjaman');
	Route::get('anggota/import', 'AnggotaController@import')->name('anggota.import');
	Route::post('anggota/submit-import', 'AnggotaController@submitImport')->name('anggota.submit-import');
	Route::get('anggota/previewm-import', 'AnggotaController@previewImport')->name('anggota.preview-import');
	Route::get('anggota/delete-temp/{id}', 'AnggotaController@deleteTemp')->name('anggota.delete-temp');
	Route::get('anggota/import-ok', 'AnggotaController@importOk')->name('anggota.import-ok');
	Route::post('submitpinjaman', 'AnggotaController@submitpinjaman')->name('anggota.submitpinjaman');
	Route::get('bayar/{id}', 'AnggotaController@bayar')->name('anggota.bayar');
	Route::get('bayar-endowment/{id}', 'AnggotaController@bayarEndowment')->name('anggota.bayar-endowment');
	Route::get('anggota/cetak-kartu-anggota', 'AnggotaController@cetakKartu')->name('anggota.cetak-data-anggota');
	Route::get('anggota/active/{id}', 'AnggotaController@active')->name('anggota.active');
	Route::get('anggota/inactive/{id}', 'AnggotaController@inactive')->name('anggota.inactive');

	/**
	 * Pinjaman Routing
	 */
	Route::get('pinjaman', 'PinjamanController@index')->name('pinjaman.index');
	Route::get('pinjaman/detail/{id}', 'PinjamanController@detail')->name('pinjaman.detail');
	Route::get('pinjaman/add', 'PinjamanController@add')->name('pinjaman.add');
	Route::post('pinjaman/store-pinjaman', 'PinjamanController@storePinjaman')->name('pinjaman.store-pinjaman');
	Route::get('pinjaman/bayar/{id}', 'PinjamanController@bayar')->name('pinjaman.bayar');

	Route::resource('aktiva', 'AktivaController');
	Route::resource('pasiva', 'PasivaController');
	Route::resource('biaya', 'BiayaController');
	Route::resource('pendapatan', 'PendapatanController');

	/** 
	 * Tagihan Routing
	 */
	Route::get('tagihan', 'TagihanController@index')->name('tagihan.index');
	Route::get('tagihan/bayar{id}', 'TagihanController@bayar')->name('tagihan.bayar');
	
	Route::resource('premi', 'PremiController', ['only'=> ['index','create','store', 'edit','destroy','update']]);
	Route::resource('setting', 'SettingController', ['only'=> ['index','create','store', 'edit','destroy','update']]);

	Route::resource('user', 'UserController', ['only'=> ['index','create','store', 'edit','destroy','update']]);
	Route::get('user/active/{id}', 'UserController@active')->name('user.active');
	Route::get('user/inactive/{id}', 'UserController@inactive')->name('user.inactive');
});
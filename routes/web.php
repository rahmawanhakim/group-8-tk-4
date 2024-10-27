<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Pengguna\RequestController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

//USER TENANT
Route::get('/customer-user', [RequestController::class, 'request_bev'])->name('customer-user');
Route::get('/customer-user/history', [RequestController::class, 'history_bev'])->name('customer-user/history');
Route::get('item_barang_request/{id}', [RequestController::class, 'item_barang_request'])->name('item_barang_request/{id}');


//REQUEST BEVERAGE - USER TENANT

Route::post('add-request', [RequestController::class, 'store_request'])->name('add-request');
Route::post('add_barang_request', [RequestController::class, 'add_barang_request'])->name('add_barang_request');
Route::post('cancel-request-bev', [RequestController::class, 'cancel_request'])->name('cancel-request-bev');
Route::post('receive-request-bev', [RequestController::class, 'receive_request'])->name('receive-request-bev');
Route::post('/checkout_barang', [RequestController::class, 'checkout_barang'])->name('checkout_barang');
Route::post('/delete_cart', [RequestController::class, 'delete_cart'])->name('delete_cart');

//GET BEVERAGE PRICE
Route::post('get-bev-price', [RequestController::class, 'get_active_price'])->name('get-bev-price');

//GET DATA REQUEST
Route::get('get-data-request/{id}', [RequestController::class, 'get_data_request'])->name('get-data-request');
// Route::post('get-stock-bev', [Controller::class, 'get_data_stock'])->name('get-stock-bev');

//BEVERAGE
Route::get('/barang', [BarangController::class, 'barang'])->name('barang');
Route::get('/barang-request-list', [BarangController::class, 'barang_request_list'])->name('barang-request-list');
Route::get('/barang-history', [BarangController::class, 'barang_history'])->name('barang-history');
Route::get('/barang-request-detail/{id}', [BarangController::class, 'barang_request_detail'])->name('barang-request-detail/{id}');
Route::post('barang/tambah-barang', [BarangController::class, 'tambah_barang'])->name('barang/tambah-barang');
Route::get('/harga-barang/{id}', [BarangController::class, 'HargaBarang'])->name('harga-barang/{id}');
Route::post('barang/update-barang', [BarangController::class, 'update_barang'])->name('barang/update-barang');
Route::post('barang/delete-barang', [BarangController::class, 'delete_barang'])->name('barang/delete-barang');
Route::get('/item_upload_barang/{id}', [BarangController::class, 'item_upload_barang'])->name('item_upload_barang');
Route::post('store-barang-receipt', [BarangController::class, 'store_receipt_barang'])->name('store-barang-receipt');
Route::get('/barang_image/{id}', [BarangController::class, 'barang_image'])->name('barang_image');
Route::get('/barang-add-request-list', [BarangController::class, 'add_request_list'])->name('barang-add-request-list');



//BEVERAGE
Route::get('/barang', [BarangController::class, 'barang'])->name('barang');
Route::post('barang/add_barang', [BarangController::class, 'add_barang'])->name('barang/add_barang');
Route::post('barang/update_barang', [BarangController::class, 'update_barang'])->name('barang/update_barang');
Route::post('barang/delete_barang', [BarangController::class, 'delete_barang'])->name('barang/delete_barang');
Route::post('tambah-harga-barang', [BarangController::class, 'tambah_HargaBarang'])->name('tambah-harga-barang');
Route::post('barang/update_barang_price', [BarangController::class, 'update_barang_price'])->name('barang/update_barang_price');
Route::post('barang/delete_barang_price', [BarangController::class, 'delete_barang_price'])->name('barang/delete_barang_price');
Route::get('/item_edit_barang/{id}', [BarangController::class, 'item_edit_barang'])->name('item_edit_barang/{id}');
Route::get('/item_delete_barang/{id}', [BarangController::class, 'item_delete_barang'])->name('item_delete_barang/{id}');
Route::get('/item_edit_barang_price/{id}', [BarangController::class, 'item_edit_barang_price'])->name('item_edit_barang_price/{id}');
Route::get('/item_barang_select/{id}', [BarangController::class, 'item_barang_select'])->name('item_barang_select/{id}');
Route::get('/item_delete_barang_price/{id}', [BarangController::class, 'item_delete_barang_price'])->name('item_delete_barang_price/{id}');
Route::get('item_update_barang_transaction/{id}', [BarangController::class, 'item_update_barang_transaction'])->name('item_update_barang_transaction/{id}');
Route::post('barang/update_barang_transaction', [BarangController::class, 'update_barang_transaction'])->name('barang/update_barang_transaction');
Route::post('barang/change_status_barang_transaction', [BarangController::class, 'change_status_barang_transaction'])->name('barang/change_status_barang_transaction');
Route::post('barang/change_status_barang', [BarangController::class, 'change_status_barang'])->name('barang/change_status_barang');
Route::post('barang/change_status_barang', [BarangController::class, 'change_status_barang'])->name('barang/change_status_barang');
Route::post('tambah-transaksi-stok-barang', [BarangController::class, 'tambah_transaksi_stok_barang'])->name('tambah-transaksi-stok-barang');
Route::get('barang-price/barang-price-detail/{id}', [BarangController::class, 'detail_barang_price'])->name('barang-price/barang-price-detail/{id}');
Route::get('tambah-stok-barang/{id}', [BarangController::class, 'tambah_stok_barang'])->name('tambah-stok-barang/{id}');
Route::post('add_barang_request_admin', [BarangController::class, 'add_barang_request_admin'])->name('add_barang_request_admin');


Route::get('/list-transaksi', [BarangController::class, 'list_transaksi'])->name('list-transaksi');
Route::get('/history-transaksi', [BarangController::class, 'history_transaksi'])->name('history-transaksi');
Route::get('/list-transaksi-customer', [RequestController::class, 'list_transaksi_customer'])->name('list-transaksi-customer');
Route::get('/history-transaksi-customer', [RequestController::class, 'history_transaksi_customer'])->name('history-transaksi-customer');


Route::post('/ubah-status', [BarangController::class, 'ubah_status'])->name('ubah-status');
Route::post('/hapus-transaksi', [BarangController::class, 'hapus_transaksi'])->name('hapus-transaksi');
Route::get('display-barang', [RequestController::class, 'display_barang'])->name('display-barang');
Route::get('item_beverage_request/{id}', [RequestController::class, 'item_beverage_request'])->name('item_beverage_request/{id}');
Route::post('add_beverage_request', [RequestController::class, 'add_beverage_request'])->name('add_beverage_request');
Route::post('/checkout_beverage', [RequestController::class, 'checkout_beverage'])->name('checkout_beverage');


Route::get('/tipe-posisi', [PenggunaController::class, 'hakakses'])->name('tipe-posisi');
Route::get('/pengguna/{id}', [PenggunaController::class, 'pengguna'])->name('pengguna/{id}');
Route::post('/hapus-pengguna', [PenggunaController::class, 'hapus_pengguna'])->name('hapus-pengguna');
Route::post('/edit-pengguna', [PenggunaController::class, 'edit_pengguna'])->name('edit-pengguna');
Route::post('/tambah-pengguna', [PenggunaController::class, 'tambah_pengguna'])->name('tambah-pengguna');
Route::get('/get-item-user/{id}', [PenggunaController::class, 'get_item_user'])->name('get-item-user/{id}');

Route::get('/supplier', [SupplierController::class, 'supplier'])->name('supplier');
Route::post('/hapus-supplier', [SupplierController::class, 'hapus_supplier'])->name('hapus-supplier');
Route::post('/edit-supplier', [SupplierController::class, 'edit_supplier'])->name('edit-supplier');
Route::post('/tambah-supplier', [SupplierController::class, 'tambah_supplier'])->name('tambah-supplier');
Route::get('/get-item-user/{id}', [SupplierController::class, 'get_item_user'])->name('get-item-user/{id}');


// AUTH
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/login', [LoginController::class, 'login'])->name('login_v');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/check-login', [LoginController::class, 'check_login'])->name('check-login');
Route::get('/register', [LoginController::class, 'register'])->name('register');



Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\Controller;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Customer\BillingController as CustomerBillingController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Pengguna\RequestController;
use App\Http\Controllers\Receptionist\DashboardReceptionistController;

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

//show_billing
Route::get('/billing', [BillingController::class, 'show_billing'])->name('billing');
Route::get('get-billing-period/{id}', [BillingController::class, 'get_billing_period'])->name('get-billing-period');
Route::get('billing/category/period/{id}', [BillingController::class, 'get_period'])->name('billing/category/period/');
Route::get('billing/category/{id}', [BillingController::class, 'get_billing_category'])->name('billing/category/');
Route::post('billing/store-billing-period', [BillingController::class, 'store_billing_period'])->name('billing/store-billing-period');
Route::post('billing/update-billing-period', [BillingController::class, 'update_billing_period'])->name('billing/update-billing-period');
Route::post('billing/delete-billing-period', [BillingController::class, 'delete_billing_period'])->name('billing/delete-billing-period');
Route::post('billing/delete-fee', [BillingController::class, 'delete_billing_fee'])->name('billing/delete-fee');
Route::post('billing/update-fee', [BillingController::class, 'update_billing_fee'])->name('billing/update-fee');
Route::post('billing/refresh-period', [BillingController::class, 'update_billing_period'])->name('billing/refresh-period');
Route::get('/item_update_billing/{id}', [BillingController::class, 'item_update_billing'])->name('item_update_billing');
Route::get('/item_delete_billing/{id}', [BillingController::class, 'item_delete_billing'])->name('item_delete_billing');
Route::get('/get-info-payment/{id}', [BillingController::class, 'get_info_payment'])->name('get-info-payment');
Route::get('/get-water-payment/{id}', [BillingController::class, 'get_water_payment'])->name('get-water-payment');
Route::get('/get-electricity-payment/{id}', [BillingController::class, 'get_electricity_payment'])->name('get-electricity-payment');
Route::get('/get-barang-payment/{id}', [BillingController::class, 'get_barang_payment'])->name('get-barang-payment');
Route::get('/item_upload_billing/{id}', [BillingController::class, 'item_upload'])->name('item_upload_billing');
Route::post('store-billing-receipt', [BillingController::class, 'store_receipt'])->name('store-billing-receipt');
Route::post('reject-billing-status', [BillingController::class, 'reject_billing_status'])->name('reject-billing-status');
Route::post('approve-billing-status', [BillingController::class, 'approve_billing_status'])->name('approve-billing-status');
// Route::post('unpaid-billing-status', [BillingController::class, 'unpaid_billing_status'])->name('unpaid-billing-status');

// DETAIL BILLING RENT BUILDING
Route::get('/billing/category/period/{id_period}/detail-billing-rent/{id}', [BillingController::class, 'detail_billing_rent'])->name('detail_billing_rent');
Route::get('/billing/category/period/{id_period}/detail-billing-electricity/{id}', [BillingController::class, 'detail_billing_electricity'])->name('detail_billing_electricity');
Route::get('/billing/category/period/{id_period}/detail-billing-water/{id}', [BillingController::class, 'detail_billing_water'])->name('detail_billing_water');
Route::get('/billing/category/period/{id_period}/detail-billing-barang/{id}', [BillingController::class, 'detail_billing_barang'])->name('detail_billing_barang');
Route::get('/billing/category/period/{id_period}/detail-billing-overtime/{id}', [BillingController::class, 'detail_billing_overtime'])->name('detail_billing_overtime');

//GET BILLING
Route::get('get-data-fee/{id}', [BillingController::class, 'get_data_fee'])->name('get-data-fee');

//USER TENANT
Route::get('/customer-user', [RequestController::class, 'request_bev'])->name('customer-user');
Route::get('/customer-user/history', [RequestController::class, 'history_bev'])->name('customer-user/history');
Route::get('/dashboard-user', [CustomerDashboardController::class, 'dashboard_user'])->name('dashboard-user');
Route::get('item_barang_request/{id}', [RequestController::class, 'item_barang_request'])->name('item_barang_request/{id}');
Route::get('/profile-customer', [CustomerDashboardController::class, 'profile_customer'])->name('profile-customer');
Route::post('profile-customer/update-customer', [CustomerDashboardController::class, 'update_profile_customer'])->name('profile-customer/update-customer');
Route::get('/billing-customer', [CustomerBillingController::class, 'billing_customer'])->name('billing-customer');
Route::get('/billing-customer/history/{id}', [CustomerBillingController::class, 'billing_customer_history'])->name('billing-customer-history');
Route::get('/billing-customer/category/{id}', [CustomerBillingController::class, 'billing_customer_category'])->name('billing-customer-category');
Route::get('/billing-customer/detail-rent-billing/{id}', [CustomerBillingController::class, 'detail_rent_billing'])->name('detail-rent-billing');
Route::get('/billing-customer/detail-service-billing/{id}', [CustomerBillingController::class, 'detail_service_billing'])->name('detail-service-billing');
Route::get('/billing-customer/detail-electricity-billing/{id}', [CustomerBillingController::class, 'detail_electricity_billing'])->name('detail-electricity-billing');
Route::get('/billing-customer/detail-water-billing/{id}', [CustomerBillingController::class, 'detail_water_billing'])->name('detail-water-billing');
Route::get('/billing-customer/detail-barang-billing/{id}', [CustomerBillingController::class, 'detail_barang_billing'])->name('detail-barang-billing');
Route::get('/billing-customer/detail-overtime-billing/{id}', [CustomerBillingController::class, 'detail_overtime_billing'])->name('detail-overtime-billing');

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
Route::get('/harga-barang/{id}', [BarangController::class, 'harga_barang'])->name('harga-barang/{id}');
Route::post('barang/update-barang', [BarangController::class, 'update_barang'])->name('barang/update-barang');
Route::post('barang/delete-barang', [BarangController::class, 'delete_barang'])->name('barang/delete-barang');
Route::get('/item_upload_barang/{id}', [BarangController::class, 'item_upload_barang'])->name('item_upload_barang');
Route::post('store-barang-receipt', [BarangController::class, 'store_receipt_barang'])->name('store-barang-receipt');
Route::get('/barang_image/{id}', [BarangController::class, 'barang_image'])->name('barang_image');
Route::get('/barang-add-request-list', [BarangController::class, 'add_request_list'])->name('barang-add-request-list');

//TENANT
Route::get('/customers', [CustomersController::class, 'show_customers'])->name('customers');
Route::post('customers/add-customer', [CustomersController::class, 'add_customer'])->name('customers/add-customer');
Route::post('customers/add-rent-unit', [CustomersController::class, 'add_customer_rent_unit'])->name('customers/add-rent-unit');
Route::post('customer/update-customer', [CustomersController::class, 'update_customer'])->name('customer/update-customer');
Route::post('customer/delete-customer', [CustomersController::class, 'delete_customer'])->name('customer/delete-customer');
Route::post('customers/extend-rent-unit', [CustomersController::class, 'extent_rent_unit'])->name('customers/extend-rent-unit');
Route::post('cancel-unit-rent', [CustomersController::class, 'cancel_unit_rent'])->name('cancel-unit-rent');
Route::post('update-rent-unit', [CustomersController::class, 'update_unit_rent'])->name('update-rent-unit');
Route::get('customer/detail/unit-rent/{id}', [CustomersController::class, 'detail_unit_rent'])->name('customer/detail/unit-rent/{id}');
Route::get('customer/detail/request/{id}', [CustomersController::class, 'detail_customer_request'])->name('customer/detail/request/{id}');

//GET DATA RENT UNIT
Route::post('get-nominal', [CustomersController::class, 'get_nominal'])->name('get-nominal');
Route::post('get-available-unit', [CustomersController::class, 'get_available_unit'])->name('get-available-unit');
Route::get('get-data-update-customer/{id}', [CustomersController::class, 'get_update_data_customer'])->name('get-data-update-customer/{id}');
Route::get('get-data-customer-unit/{id}', [CustomersController::class, 'get_data_customer_unit'])->name('get-data-customer-unit/{id}');
Route::get('get-data-update-unit/{id}', [CustomersController::class, 'get_update_data_unit'])->name('get-data-update-unit/{id}');
Route::get('get-data-delete-customer/{id}', [CustomersController::class, 'get_data_for_delete'])->name('get-data-delete-customer/{id}');

//BEVERAGE
Route::get('/barang', [BarangController::class, 'barang'])->name('barang');
Route::post('barang/add_barang', [BarangController::class, 'add_barang'])->name('barang/add_barang');
Route::post('barang/update_barang', [BarangController::class, 'update_barang'])->name('barang/update_barang');
Route::post('barang/delete_barang', [BarangController::class, 'delete_barang'])->name('barang/delete_barang');
Route::post('tambah-harga-barang', [BarangController::class, 'tambah_harga_barang'])->name('tambah-harga-barang');
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
Route::get('/pengguna/{id}', [PenggunaController::class, 'pengguna'])->name('pengguna/{id}');
Route::get('/tipe-posisi', [PenggunaController::class, 'tipe_posisi'])->name('tipe-posisi');
Route::post('/ubah-status', [BarangController::class, 'ubah_status'])->name('ubah-status');
Route::post('/hapus-transaksi', [BarangController::class, 'hapus_transaksi'])->name('hapus-transaksi');
Route::post('/hapus-pengguna', [PenggunaController::class, 'hapus_pengguna'])->name('hapus-pengguna');
Route::post('/edit-pengguna', [PenggunaController::class, 'edit_pengguna'])->name('edit-pengguna');
Route::post('/tambah-pengguna', [PenggunaController::class, 'tambah_pengguna'])->name('tambah-pengguna');
Route::get('display-barang', [RequestController::class, 'display_barang'])->name('display-barang');
Route::get('item_beverage_request/{id}', [RequestController::class, 'item_beverage_request'])->name('item_beverage_request/{id}');
Route::post('add_beverage_request', [RequestController::class, 'add_beverage_request'])->name('add_beverage_request');
Route::post('/checkout_beverage', [RequestController::class, 'checkout_beverage'])->name('checkout_beverage');




// AUTH
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/login', [LoginController::class, 'login'])->name('login_v');
Route::get('/login/lv2', [LoginController::class, 'login_v'])->name('login/lv2');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/check-login', [LoginController::class, 'check_login'])->name('check-login');
Route::post('/check-login-v', [LoginController::class, 'check_login_v2'])->name('check-login-v');
Route::get('/register', [LoginController::class, 'register'])->name('register');



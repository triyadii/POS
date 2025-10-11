<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\RoleController;


//MY PROFILE
use App\Http\Controllers\Backend\Profile\AccountController;
use App\Http\Controllers\Backend\Profile\ProfileController;
use App\Http\Controllers\Backend\Profile\SecurityController;
use App\Http\Controllers\Backend\Profile\UserLogController;

//HELP
use App\Http\Controllers\Backend\Help\ChangelogController;
use App\Http\Controllers\Backend\Help\LogActivityController;

//CRUD 
use App\Http\Controllers\Backend\CRUD\GeneratorController;
use App\Http\Controllers\Backend\Apps\PenjualanController;


//MASTER
use App\Http\Controllers\Backend\Master\SupplierController;
use App\Http\Controllers\Backend\Master\BrandController;
use App\Http\Controllers\Backend\Master\KategoriController;
use App\Http\Controllers\Backend\Master\TipeController;
use App\Http\Controllers\Backend\Laporan\LaporanLabaRugiController;
use App\Http\Controllers\Backend\Laporan\LaporanPenjualanController;





use App\Http\Controllers\SettingAppController;




Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();



Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/log-activities', [DashboardController::class, 'getLogActivities'])->name('log-activities.get');


    Route::get('/setting-app', [SettingAppController::class, 'edit'])->name('setting_app.edit');
    Route::post('/setting-app', [SettingAppController::class, 'update'])->name('setting_app.update');

    Route::resource('roles', RoleController::class);
    Route::get('get-datarole', [RoleController::class, 'getDataRoles'])->name('get-datarole');
    Route::post('/roles/mass-delete', [RoleController::class, 'massDelete'])->name('roles.mass-delete');
    Route::get('/select/role', [RoleController::class, 'select'])->name('role.select');

    Route::resource('users', UserController::class);
    Route::get('get-users', [UserController::class, 'getUsers'])->name('get-users');
    Route::post('/users/mass-delete', [UserController::class, 'massDelete'])->name('users.mass-delete');
    Route::get('get-user-show-log/{id}', [UserController::class, 'getUserShowLog'])->name('get-usershowlog');
    Route::get('get-user-show-log-activity/{id}', [UserController::class, 'getUserShowLogActivity'])->name('get-usershowlogactivity');

    Route::resource('account', AccountController::class)->names('account');
    Route::get('account/{id}/avatar', [AccountController::class, 'editAvatar'])->name('avatar-edit');
    Route::post('updateavatar/{id}', [AccountController::class, 'updateAvatar'])->name('avatar-update');
    Route::resource('profile', ProfileController::class);
    Route::resource('security', SecurityController::class);
    Route::post('security', [SecurityController::class, 'store'])->name('change.password');
    Route::resource('users-log', UserLogController::class);
    Route::get('get-datauserslog', [UserLogController::class, 'getDataUserLog'])->name('get-datauserslog');
    Route::get('get-datauserslogactivity', [UserLogController::class, 'getDataUserLogActivity'])->name('get-datauserslogactivity');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //CHANGELOG ROUTE
    Route::resource('changelog', ChangelogController::class);
    Route::get('get-datachangelog', [ChangelogController::class, 'getDataChangelog'])->name('get-datachangelog');
    Route::post('/changelog/mass-delete', [ChangelogController::class, 'massDelete'])->name('changelog.mass-delete');

    //LOG ACTIVITY ROUTE
    Route::resource('log-activity', LogActivityController::class);
    Route::get('get-datalogactivity', [LogActivityController::class, 'getDataLogActivity'])->name('get-datalogactivity');




    Route::resource('crud-generator', GeneratorController::class);



    Route::resource('supplier', SupplierController::class);
    Route::get('get-supplier', [SupplierController::class, 'getData'])->name('get-supplier');
    Route::post('/supplier/mass-delete', [SupplierController::class, 'massDelete'])->name('supplier.mass-delete');
    Route::get('/select/supplier', [SupplierController::class, 'select'])->name('supplier.select');

    Route::resource('brand', BrandController::class);
    Route::get('get-brand', [BrandController::class, 'getData'])->name('get-brand');
    Route::post('/brand/mass-delete', [BrandController::class, 'massDelete'])->name('brand.mass-delete');
    Route::get('/select/brand', [BrandController::class, 'select'])->name('brand.select');

    Route::resource('kategori', KategoriController::class);
    Route::get('get-kategori', [KategoriController::class, 'getData'])->name('get-kategori');
    Route::post('/kategori/mass-delete', [KategoriController::class, 'massDelete'])->name('kategori.mass-delete');
    Route::get('/select/kategori', [KategoriController::class, 'select'])->name('kategori.select');

    Route::resource('penjualan', PenjualanController::class);
    Route::resource('tipe', TipeController::class);
    Route::get('get-tipe', [TipeController::class, 'getData'])->name('get-tipe');
    Route::post('/tipe/mass-delete', [TipeController::class, 'massDelete'])->name('tipe.mass-delete');
    Route::get('/select/tipe', [TipeController::class, 'select'])->name('tipe.select');
    Route::get('laporan-penjualan-data', [LaporanPenjualanController::class, 'getLaporanData'])->name('laporan.penjualan.data');
    Route::get('laporan-penjualan/chart', [LaporanPenjualanController::class, 'getChartData'])->name('laporan.penjualan.chart');
    Route::get('/laporan/penjualan/export', [LaporanPenjualanController::class, 'export'])->name('laporan.penjualan.export');
    Route::resource('laporan-penjualan', LaporanPenjualanController::class);

    Route::get('laporan-laba-rugi/chart', [LaporanLabaRugiController::class, 'getProfitLossData'])->name('laporan.laba-rugi.chart');
    Route::get('/laporan/laba-rugi/export-pdf', [LaporanLabaRugiController::class, 'exportLabaRugiPdf'])->name('laporan.laba-rugi.export-pdf');
    Route::resource('laporan-laba-rugi', LaporanLabaRugiController::class);
});



Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    //$exitCode = Artisan::call('logs:clear');
    $exitCode = Artisan::call('optimize:clear');
    $exitCode = Artisan::call('storage:link');
    return 'KAMU LUAR BIASA RIZKYCHIMO !'; //Return anything
});

Route::get('/chimox', function () {
    $exitCode = Artisan::call('storage:link');
    return 'storage KAMU LUAR BIASA RIZKYCHIMO !'; //Return anything
});






// AUTO GENERATED ROUTES FOR Divisi
Route::middleware(['auth'])->group(function () {
    Route::resource('divisi', DivisiController::class);
    Route::get('get-divisi', [DivisiController::class, 'getData'])->name('get-divisi');
    Route::post('divisi/mass-delete', [DivisiController::class, 'massDelete'])->name('divisi.mass-delete');
});


// AUTO GENERATED ROUTES FOR Picolo
Route::middleware(['auth'])->group(function () {
    Route::resource('picolo', PicoloController::class);
    Route::get('get-picolo', [PicoloController::class, 'getData'])->name('get-picolo');
    Route::post('picolo/mass-delete', [PicoloController::class, 'massDelete'])->name('picolo.mass-delete');
});


// AUTO GENERATED ROUTES FOR Coba1
Route::middleware(['auth'])->group(function () {
    Route::resource('coba1', Coba1Controller::class);
    Route::get('get-coba1', [Coba1Controller::class, 'getData'])->name('get-coba1');
    Route::post('coba1/mass-delete', [Coba1Controller::class, 'massDelete'])->name('coba1.mass-delete');
});


// AUTO GENERATED ROUTES FOR Tito
Route::middleware(['auth'])->group(function () {
    Route::resource('tito', TitoController::class);
    Route::get('get-tito', [TitoController::class, 'getData'])->name('get-tito');
    Route::post('tito/mass-delete', [TitoController::class, 'massDelete'])->name('tito.mass-delete');
});


// AUTO GENERATED ROUTES FOR Kiki
Route::middleware(['auth'])->group(function () {
    Route::resource('kiki', KikiController::class);
    Route::get('get-kiki', [KikiController::class, 'getData'])->name('get-kiki');
    Route::post('kiki/mass-delete', [KikiController::class, 'massDelete'])->name('kiki.mass-delete');
});


// AUTO GENERATED ROUTES FOR Surat
Route::middleware(['auth'])->group(function () {
    Route::resource('surat', SuratController::class);
    Route::get('get-surat', [SuratController::class, 'getData'])->name('get-surat');
    Route::post('surat/mass-delete', [SuratController::class, 'massDelete'])->name('surat.mass-delete');
});

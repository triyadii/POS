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



//BEGIN CHIMOX
//MASTER
use App\Http\Controllers\Backend\Master\SupplierController;
use App\Http\Controllers\Backend\Master\BrandController;
use App\Http\Controllers\Backend\Master\KategoriController;
use App\Http\Controllers\Backend\Master\TipeController;
use App\Http\Controllers\Backend\Master\SatuanController;
use App\Http\Controllers\Backend\Master\JenisPembayaranController;
use App\Http\Controllers\Backend\Master\CustomerController;
//APPS
use App\Http\Controllers\Backend\Apps\BarangController;
use App\Http\Controllers\Backend\Apps\BarangMasukController;
use App\Http\Controllers\Backend\Apps\BarangMasukDetailController;

//END CHIMOX
use App\Http\Controllers\Backend\Laporan\LaporanPenjualanController;
use App\Http\Controllers\Backend\Laporan\LaporanLabaRugiController;
use App\Http\Controllers\Backend\Laporan\LaporanPenjualanBrandController;
use App\Http\Controllers\Backend\Laporan\LaporanPenjualanKategoriController;
use App\Http\Controllers\Backend\Laporan\LaporanPenjualanSupplierController;
use App\Http\Controllers\Backend\Stok\StokController;
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






    // BEGIN CHIMOX
    Route::resource('supplier', SupplierController::class);
    Route::get('get-supplier', [SupplierController::class, 'getDataRoles'])->name('get-supplier');
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

    Route::resource('tipe', TipeController::class);
    Route::get('get-tipe', [TipeController::class, 'getData'])->name('get-tipe');
    Route::post('/tipe/mass-delete', [TipeController::class, 'massDelete'])->name('tipe.mass-delete');
    Route::get('/select/tipe', [TipeController::class, 'select'])->name('tipe.select');

    Route::resource('satuan', SatuanController::class);
    Route::get('get-satuan', [SatuanController::class, 'getData'])->name('get-satuan');
    Route::post('/satuan/mass-delete', [SatuanController::class, 'massDelete'])->name('satuan.mass-delete');
    Route::get('/select/satuan', [SatuanController::class, 'select'])->name('satuan.select');

    Route::resource('jenis-pembayaran', JenisPembayaranController::class);
    Route::get('get-jenis-pembayaran', [JenisPembayaranController::class, 'getData'])->name('get-jenis-pembayaran');
    Route::post('/jenis-pembayaran/mass-delete', [JenisPembayaranController::class, 'massDelete'])->name('jenis-pembayaran.mass-delete');
    Route::get('/select/jenis-pembayaran', [JenisPembayaranController::class, 'select'])->name('jenis-pembayaran.select');

    Route::resource('customer', CustomerController::class);
    Route::get('get-customer', [CustomerController::class, 'getData'])->name('get-customer');
    Route::post('/customer/mass-delete', [CustomerController::class, 'massDelete'])->name('customer.mass-delete');
    Route::get('/select/customer', [CustomerController::class, 'select'])->name('customer.select');

    Route::resource('barang', BarangController::class);
    Route::get('get-barang', [BarangController::class, 'getData'])->name('get-barang');
    Route::post('/barang/mass-delete', [BarangController::class, 'massDelete'])->name('barang.mass-delete');
    Route::get('/select/barang', [BarangController::class, 'select'])->name('barang.select');

    // Route::resource('barang-masuk', BarangMasukController::class);
    // Route::get('get-barang-masuk', [BarangMasukController::class, 'getData'])->name('get-barang-masuk');
    // Route::post('barang-masuk/mass-delete', [BarangMasukController::class, 'massDelete'])->name('barang-masuk.mass-delete');
    // Route::get('select/barang-masuk', [BarangMasukController::class, 'select'])->name('barang-masuk.select');

    // // detail gabung (gunakan prefix penuh)
    // Route::get('barang-masuk/{id}/detail/list', [BarangMasukController::class, 'getDetailList'])->name('barang-masuk.detail.list');
    // Route::post('barang-masuk/{id}/detail/add', [BarangMasukController::class, 'addDetail'])->name('barang-masuk.detail.add');
    // Route::delete('barang-masuk/detail/{detailId}', [BarangMasukController::class, 'deleteDetail'])->name('barang-masuk.detail.delete');


    Route::prefix('barang-masuk')->group(function () {
        Route::get('/', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
        Route::post('/', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
        Route::get('/{id}', [BarangMasukController::class, 'show'])->name('barang-masuk.show');
        Route::get('/{id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
        Route::put('/{id}', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
        Route::delete('/{id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');
    
        
        // detail gabung
        Route::get('/{id}/detail/list', [BarangMasukController::class, 'getDetailList'])->name('barang-masuk.detail.list');
        Route::post('/{id}/detail/add', [BarangMasukController::class, 'addDetail'])->name('barang-masuk.detail.add');
        Route::delete('/detail/{detailId}', [BarangMasukController::class, 'deleteDetail'])->name('barang-masuk.detail.delete');
    });

    Route::get('get-barang-masuk', [BarangMasukController::class, 'getData'])->name('get-barang-masuk');
    Route::post('barang-masuk/mass-delete', [BarangMasukController::class, 'massDelete'])->name('barang-masuk.mass-delete');
    Route::get('select/barang-masuk', [BarangMasukController::class, 'select'])->name('barang-masuk.select');
    Route::post('barang-masuk/{id}/finalize', [BarangMasukController::class, 'finalize'])
    ->name('barang-masuk.finalize');
    Route::get('/barang-masuk/{id}/print', [BarangMasukController::class, 'print'])->name('barang-masuk.print');


    


// Route::prefix('barang-masuk')->group(function () {
//     // resource utama
//     Route::get('/', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
//     Route::get('/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
//     Route::post('/', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
//     Route::get('/{id}', [BarangMasukController::class, 'show'])->name('barang-masuk.show');
//     Route::get('/{id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
//     Route::put('/{id}', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
//     Route::delete('/{id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');

//     // custom tambahan
//     Route::get('/get/data', [BarangMasukController::class, 'getData'])->name('barang-masuk.getData');
//     Route::post('/mass-delete', [BarangMasukController::class, 'massDelete'])->name('barang-masuk.mass-delete');
//     Route::get('/select/data', [BarangMasukController::class, 'select'])->name('barang-masuk.select');

//     // 🧩 detail gabung di sini
//     Route::get('/{id}/detail/list', [BarangMasukController::class, 'getDetailList'])->name('barang-masuk.detail.list');
//     Route::post('/{id}/detail/add', [BarangMasukController::class, 'addDetail'])->name('barang-masuk.detail.add');
//     Route::delete('/detail/{detailId}', [BarangMasukController::class, 'deleteDetail'])->name('barang-masuk.detail.delete');
// });


 

    //END CHIMOX


    Route::resource('penjualan', PenjualanController::class)->except(['show']);
    Route::get('/penjualan/daftar', [PenjualanController::class, 'daftarPenjualan'])->name('penjualan.daftar');
    Route::get('/penjualan/daftar/data', [PenjualanController::class, 'dataPenjualan'])
        ->name('penjualan.daftar.data');
    Route::get('penjualan/history', [PenjualanController::class, 'historyData'])->name('penjualan.history.data');
    Route::get('/penjualan/produk/data', [PenjualanController::class, 'produkData'])->name('penjualan.produk.data');

    Route::get('laporan-penjualan-data', [LaporanPenjualanController::class, 'getLaporanData'])->name('laporan.penjualan.data');
    Route::get('laporan-penjualan/chart', [LaporanPenjualanController::class, 'getChartData'])->name('laporan.penjualan.chart');
    Route::get('/laporan/penjualan/export', [LaporanPenjualanController::class, 'export'])->name('laporan.penjualan.export');
    Route::resource('laporan-penjualan', LaporanPenjualanController::class);

    Route::get('laporan-penjualan-brand-data', [LaporanPenjualanBrandController::class, 'getLaporanData'])->name('laporan.penjualan.brand.data');
    Route::get('laporan-penjualan-brand/chart', [LaporanPenjualanBrandController::class, 'getChartData'])->name('laporan.penjualan.brand.chart');
    Route::get('/laporan/penjualan/brand/export', [LaporanPenjualanBrandController::class, 'export'])->name('laporan.penjualan.brand.export');
    Route::resource('laporan-penjualan-brand', LaporanPenjualanBrandController::class);

    // --- Laporan Penjualan (berdasarkan Supplier Terakhir) ---
    Route::get('laporan-penjualan-supplier-data', [LaporanPenjualanSupplierController::class, 'getLaporanData'])->name('laporan.penjualan.supplier.data');
    Route::get('laporan-penjualan-supplier/chart', [LaporanPenjualanSupplierController::class, 'getChartData'])->name('laporan.penjualan.supplier.chart');
    Route::post('/laporan/penjualan/supplier/export', [LaporanPenjualanSupplierController::class, 'export'])->name('laporan.penjualan.supplier.export');
    Route::resource('laporan-penjualan-supplier', LaporanPenjualanSupplierController::class);

    // --- Laporan Penjualan per Kategori ---
    Route::get('laporan-penjualan-kategori-data', [LaporanPenjualanKategoriController::class, 'getLaporanData'])->name('laporan.penjualan.kategori.data');
    Route::get('laporan-penjualan-kategori/chart', [LaporanPenjualanKategoriController::class, 'getChartData'])->name('laporan.penjualan.kategori.chart');
    Route::get('/laporan/penjualan/kategori/export', [LaporanPenjualanKategoriController::class, 'export'])->name('laporan.penjualan.kategori.export');
    Route::resource('laporan-penjualan-kategori', LaporanPenjualanKategoriController::class);

    Route::get('laporan-laba-rugi/chart', [LaporanLabaRugiController::class, 'getProfitLossData'])->name('laporan.laba-rugi.chart');
    Route::get('/laporan/laba-rugi/export-pdf', [LaporanLabaRugiController::class, 'exportLabaRugiPdf'])->name('laporan.laba-rugi.export-pdf');
    Route::resource('laporan-laba-rugi', LaporanLabaRugiController::class);

    Route::get('stok-data', [StokController::class, 'getStokData'])->name('stok.data');
    Route::get('stok/chart', [StokController::class, 'getChartData'])->name('stok.chart');
    Route::post('/stok/export', [StokController::class, 'export'])->name('stok.export');
    Route::resource('stok', StokController::class);
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

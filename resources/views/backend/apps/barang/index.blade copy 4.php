@extends('layouts.backend.index')
@section('title', 'Barang')
@section('content')


    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Barang
                    List</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Apps</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-900">Barang List</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center pt-4 pb-7 pt-lg-1 pb-lg-2">
                
                <!--begin::Button-->
                @can('barang-create')
                    <button type="button" id="btn_tambah_data" class="btn btn-sm btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>Add</button>
                @endcan
                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->

    <div id="kt_app_content" class="app-content flex-column-fluid">


        <div class="card border-top-accent shadow-sm mb-xl-10 mb-5">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Compact form-->
                <div class="d-flex align-items-center">
                    <!--begin::Input group-->
                    <div class="position-relative w-md-400px me-md-2">
                        <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle ms-6"></i>
                        <input type="text" class="form-control ps-10" name="search" id="search" value="" placeholder="cari kode item & nama item">
                    </div>
                    <!--end::Input group-->
    
                    <!--begin:Action-->
                    <div class="d-flex align-items-center">               
                        {{-- <button type="submit" class="btn btn-primary me-5">Search</button> --}}
                        
                        <a href="#" id="kt_horizontal_search_advanced_link" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#kt_advanced_search_form">Advanced Search</a>
                    </div>
                    <!--end:Action-->
                </div>
                <!--end::Compact form-->
    
                <!--begin::Advance form-->
                <div class="collapse" id="kt_advanced_search_form">
                    <!--begin::Separator-->
                    <div class="separator separator-dashed mt-9 mb-6"></div>
                    <!--end::Separator-->
    
                   <!--begin::Row-->
<div class="row g-8 mb-8">
    <!-- Kategori -->
    <div class="col-xxl-4 col-md-4">
        <label class="fs-6 form-label fw-bold text-gray-900">Kategori Item</label>
        <select id="filter_kategori_id" name="filter_kategori_id"
                class="form-select form-select-sm" data-control="select2"
                data-placeholder="Pilih Kategori">
        </select>
    </div>

    <!-- Brand -->
    <div class="col-xxl-4 col-md-4">
        <label class="fs-6 form-label fw-bold text-gray-900">Brand Item</label>
        <select id="filter_brand_id" name="filter_brand_id"
                class="form-select form-select-sm" data-control="select2"
                data-placeholder="Pilih Brand">
        </select>
    </div>
            
                <!-- Tipe (nested dari Brand) -->
                <div class="col-xxl-4 col-md-4">
                    <label class="fs-6 form-label fw-bold text-gray-900">Tipe Item</label>
                    <select id="filter_tipe_id" name="filter_tipe_id"
                            class="form-select form-select-sm" data-control="select2"
                            data-placeholder="Pilih Tipe">
                        </select>
                    </div> 
                </div>
                <!--end::Row-->

  
    
                    <!--begin::Row-->
                    <div class="row g-8">
                        <div class="col-xxl-3 col-md-3">
                            <label class="form-label fw-bold text-gray-800">Size</label>
                            <input type="text" id="filter_size" class="form-control form-control-sm" placeholder="cth: 30, XL, L">
                        </div>
                    
                        <div class="col-xxl-3 col-md-3">
                            <label class="form-label fw-bold text-gray-800">Stok</label>
                            <select id="filter_stok" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <option value="0">Stok Kosong</option>
                                <option value="1">Tersedia ( > 0 )</option>
                            </select>
                        </div>
                    
                        <div class="col-xxl-3 col-md-3">
                            <label class="form-label fw-bold text-gray-800">Harga Jual</label>
                            <div class="input-group input-group-sm">
                                <input type="number" id="filter_min_jual" class="form-control" placeholder="Min">
                                <span class="input-group-text">-</span>
                                <input type="number" id="filter_max_jual" class="form-control" placeholder="Max">
                            </div>
                        </div>
                    
                        <div class="col-xxl-3 col-md-3">
                            <label class="form-label fw-bold text-gray-800">Harga Beli</label>
                            <div class="input-group input-group-sm">
                                <input type="number" id="filter_min_beli" class="form-control" placeholder="Min">
                                <span class="input-group-text">-</span>
                                <input type="number" id="filter_max_beli" class="form-control" placeholder="Max">
                            </div>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Advance form--> 
            </div>
            <!--end::Card body--> 
        </div>




        <!--begin::Card-->
        <div class="card border-top-accent shadow-sm mb-xl-10 mb-5">
            <!--begin::Card header-->
            <div class="card-header d-flex justify-content-between align-items-center border-gray-400">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    {{-- <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" data-kt-user-table-filter="search" id="search"
                            class="form-control w-250px ps-13" placeholder="Search data" />
                    </div> --}}
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">

                     <!--begin::Group actions-->
                     <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-sm btn-danger me-3" data-kt-user-table-select="delete_selected"> <i
                                class="ki-outline ki-trash  me-2"></i>Delete
                            Selected</button>
                    </div>
                    <!--end::Group actions-->


                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Reload Data-->
                        <button type="button" class="btn btn-sm btn-primary " id="refresh-table-btn">
                            <span class="indicator-label">
                                <i class="ki-outline ki-arrows-loop  me-2"></i> Refresh Table
                            </span>
                            <span class="indicator-progress">
                                Please Wait ... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Reload Data-->
                    </div>
                    <!--end::Toolbar-->
                   


                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">

                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100 chimox" id="chimox">
                    <thead>
                        <tr class="fw-bold text-muted fs-7 text-uppercase gs-0">                            
                            @can('barang-massdelete')
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#chimox .form-check-input" value="1" />
                                    </div>
                                </th>
                            @endcan
                            <th class="min-w-125px">Nama Item</th>
                            <th class="min-w-70px">Kategori</th>
                            <th class="min-w-100px">Brand</th>
                            <th class="min-w-50px">Size</th>
                            <th class="min-w-100px">Stok</th>
                            <th class="text-end min-w-100px">Harga Jual</th>
                            <th class="text-end min-w-100px">Harga Beli</th>
                            @canany(['barang-show', 'barang-edit', 'barang-delete'])
                                <th class="text-end min-w-100px">Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>


            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>



    <!--begin::Modal - Add-->
    <div class="modal fade" id="Modal_Tambah_Data" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-fullscreen">
            <!--begin::Modal content-->
            <div class="modal-content" id="tambah-modal-content">
                <!--begin::Modal header-->
                <div class="modal-header bg-secondary" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Data</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"
                        onclick="resetForm()">
                        <i class="ki-outline ki-cross fs-1 text-dark"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                 <form method="post" id="FormTambahModalID" class="form" enctype="multipart/form-data">
                        @csrf
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form method="post" id="FormTambahModalID" class="form" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                    
                            
                            <div id="repeater-barang">
  <!-- OUTER -->
  <div data-repeater-list="kelompok_barang">
    <div data-repeater-item class="border rounded p-5 mb-5 bg-light">

      <!-- KATEGORI & BRAND -->
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <label class="form-label fw-bold">Kategori Item</label>
          <select data-type="kategori" name="kategori_id"
            class="form-select form-select-sm kategori_id"
            data-kt-repeater="select2" data-placeholder="pilih kategori">
          </select>
<span class="text-danger error-text"></span>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-bold">Brand</label>
          <select data-type="brand" name="brand_id"
            class="form-select form-select-sm brand_id"
            data-kt-repeater="select2" data-placeholder="pilih brand">
          </select>
          <span class="text-danger error-text kelompok_barang_0_brand_id_error_add"></span>
        </div>

        <div class="col-md-3 d-flex align-items-end">
          <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger">
            Hapus Kategori & Brand Ini
          </a>
        </div>
      </div>

      <!-- INNER REPEATER: daftar barang -->
      <div class="inner-repeater">
        <div data-repeater-list="barang">
          <div data-repeater-item class="p-4 mb-5 border rounded bg-light-subtle">

            <div class="row g-3 align-items-start">
              <!-- TIPE -->
              <div class="col-md-2">
                <select data-type="tipe" name="tipe_id"
                  class="form-select form-select-sm tipe_id"
                  data-kt-repeater="select2"
                  data-placeholder="pilih tipe/jenis brand">
                </select>
                <span class="text-danger error-text kelompok_barang_0_barang_0_tipe_id_error_add"></span>
              </div>

              <!-- KODE + SUB REPEATER VARIASI -->
              <div class="col-md-2">
                <input type="text" name="kode"
                  class="form-control form-control-sm mb-2"
                  placeholder="Kode Item">
                <span class="text-danger error-text kelompok_barang_0_barang_0_kode_error_add"></span>

                <!-- SUB REPEATER: variasi kode & size -->
                <div class="sub-repeater ms-2">
                  <div data-repeater-list="variasi">
                    <div data-repeater-item class="row g-2 align-items-center mb-2">
                      <div class="col-7">
                        <input type="text" name="kode_variasi"
                          class="form-control form-control-sm"
                          placeholder="Kode Variasi">
                        <span class="text-danger error-text kelompok_barang_0_barang_0_variasi_0_kode_variasi_error_add"></span>
                      </div>
                      <div class="col-4">
                        <input type="text" name="size"
                          class="form-control form-control-sm"
                          placeholder="Size">
    <span class="text-danger error-text kelompok_barang_0_barang_0_variasi_0_size_error_add"></span>

                      </div>
                      <div class="col-1 text-center">
                        <button type="button" data-repeater-delete
                          class="btn btn-icon btn-light-danger btn-sm">
                          <i class="ki-outline ki-trash fs-2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <button type="button" data-repeater-create
                    class="btn btn-light-primary btn-sm w-100 mt-1">+ Tambah Variasi</button>
                </div>
              </div>

              <!-- NAMA ITEM -->
              <div class="col-md-2">
                <input type="text" name="nama"
                  class="form-control form-control-sm"
                  placeholder="Nama Item">
                <span class="text-danger error-text kelompok_barang_0_barang_0_nama_error_add"></span>
              </div>

              <!-- SIZE UTAMA -->
              <div class="col-md-1">
                <input type="text" name="size_main"
                  class="form-control form-control-sm"
                  placeholder="Size">
                      <span class="text-danger error-text kelompok_barang_0_barang_0_main_size_error_add"></span>

              </div>

              <!-- SATUAN -->
              <div class="col-md-1">
                <select data-type="satuan" name="satuan_id"
                  class="form-select form-select-sm satuan_id"
                  data-kt-repeater="select2"
                  data-placeholder="pilih satuan">
                </select>
                <span class="text-danger error-text kelompok_barang_0_barang_0_satuan_id_error_add"></span>
              </div>

              <!-- HARGA JUAL -->
              <div class="col-md-1">
                <input type="text" name="harga_jual"
                  class="form-control form-control-sm text-end format-rupiah"
                  placeholder="Harga Jual">
                <span class="text-danger error-text kelompok_barang_0_barang_0_harga_jual_error_add"></span>
              </div>

              <!-- HARGA BELI -->
              <div class="col-md-1">
                <input type="text" name="harga_beli"
                  class="form-control form-control-sm text-end format-rupiah"
                  placeholder="Harga Beli">
                <span class="text-danger error-text kelompok_barang_0_barang_0_harga_beli_error_add"></span>
              </div>

              <!-- DELETE -->
              <div class="col-md-1 text-center">
                <button type="button" data-repeater-delete
                  class="btn btn-icon btn-light-danger btn-sm">
                  <i class="ki-outline ki-trash fs-2"></i>
                </button>
              </div>
            </div>

          </div>
        </div>

        <button type="button" data-repeater-create class="btn btn-sm btn-light-primary">
          + Tambah Item
        </button>
      </div>
      <!-- END INNER REPEATER -->

    </div>
  </div>

  <div class="mt-5">
    <button type="button" data-repeater-create class="btn btn-sm btn-light-success">
      + Tambah Kategori & Brand
    </button>
  </div>
</div>



                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-sm btn-secondary me-3" data-bs-dismiss="modal"
                                onclick="resetForm()">Discard</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="btn-add-data">
                                <span class="indicator-label add-data-label">Submit</span>
                                <span class="indicator-progress add-data-progress" style="display: none;">Please Wait ...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->


    <!-- Begin Modal Edit -->
    <div class="modal fade" id="Modal_Edit_Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content" id="edit-modal-content">
                <div class="modal-header bg-secondary" id="kt_modal_edit_user_header">
                    <h2 class="fw-bold">Edit Data</h2>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1 text-dark"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body px-5 my-7">
                    <form id="FormEditModalID" class="form" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7" id="EditRowModalBody"></div>
                            <input type="hidden" name="action" id="action" />
                        </div>
                        <div class="text-center pt-10">
                            <button type="button" class="btn btn-sm btn-secondary me-3"
                                data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="btn-edit-data" value="submit">
                                <span class="indicator-label edit-data-label">Submit</span>
                                <span class="indicator-progress edit-data-progress" style="display: none;">Please Wait ...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Edit -->


    <!--begin modal hapus-->
    <div class="modal fade" id="Modal_Hapus_Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="hapus-modal-content">
                <div class="modal-header bg-secondary">
                    <h2 class="modal-title">Delete Data</h2>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1 text-dark"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">

                    <p>Apakah Anda Yakin ingin menghapusnya ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-sm btn-primary" id="SubmitDeleteRowForm">
                        <span class="indicator-label delete-data-label">Submit</span>
                        <span class="indicator-progress delete-data-progress" style="display: none;">Please Wait ...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end modal hapus-->


    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
        <style>
            /* Accent line merah di atas card */
            .card.border-top-accent {
                border-top: 3px solid #0d6efd; /* warna pink/merah Metronic */
                border-radius: 0.475rem;       /* tetap sesuai Metronic radius */
                box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);

                
            }
            
            /* Opsional: agar header lebih rapat dan bersih */
            .card-header {
                border-bottom: none;
                padding-top: 1rem;
                padding-bottom: 0.5rem;
            }
            
            .sub-repeater {
  background: #f8f9fa;
  border-radius: 0.5rem;
  padding: 0.5rem 0.75rem;
}

.sub-repeater input {
  background-color: #fff;
}
            </style>
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ URL::to('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>

        <script>
            function resetForm() {

                // Clear error messages
                $(".error-text").text("");
            }

        </script>
<script>
    "use strict";
    
    $('#repeater-barang').repeater({
        initEmpty: false,
    
        show: function () {
            $(this).slideDown();
    
            // Re-init select2 di item baru
            $(this).find('[data-kt-repeater="select2"]').each(function () {
                let el = $(this);
                let type = el.data('type');
                initSelect2(el, type);
            });

            initFormatRupiah($(this)); 
        },
    
        hide: function (del) {
            $(this).slideUp(del);
        },
    
        ready: function(){
            // Init select2 untuk item pertama
            $('[data-kt-repeater="select2"]').each(function () {
                let el = $(this);
                let type = el.data('type');
                initSelect2(el, type);
            });

            initFormatRupiah($('#repeater-barang'));
        },
    
        repeaters: [
  {
    selector: '.inner-repeater',
    initEmpty: false,
    show: function () {
      $(this).slideDown();
      $(this).find('[data-kt-repeater="select2"]').each(function () {
        let el = $(this);
        let type = el.data('type');
        initSelect2(el, type);
      });
      initFormatRupiah($(this));
    },
    hide: function (del) { $(this).slideUp(del); },
    repeaters: [
      {
        selector: '.sub-repeater',
        initEmpty: false,
        show: function () {
          $(this).slideDown();
        },
        hide: function (del) { $(this).slideUp(del); }
      }
    ]
  }
]

    });
    
    // === Helper untuk inisialisasi Select2 ===
    function initSelect2(el, type) {
    let config = {
        dropdownParent: $('#Modal_Tambah_Data'),
        ajax: {
            dataType: 'json',
            delay: 250,
            processResults: data => ({
                results: data.map(i => ({ id: i.id, text: i.nama }))
            })
        },
        allowClear: true
    };

    switch (type) {
        case 'kategori':
            el.select2($.extend({}, config, {
                placeholder: 'Pilih kategori',
                ajax: $.extend({}, config.ajax, { url: "{{ route('kategori.select') }}" })
            }));
            break;

        case 'brand':
            el.select2($.extend({}, config, {
                placeholder: 'Pilih brand',
                ajax: $.extend({}, config.ajax, { url: "{{ route('brand.select') }}" })
            }));

            // Saat brand berubah ⇒ reset SEMUA select tipe di outer item ini
            el.off('change.brand-reset').on('change.brand-reset', function () {
                const outerItem = el.closest('[data-repeater-item]'); // brand ada di OUTER item
                outerItem.find('select[data-type="tipe"]').each(function () {
                    $(this).val(null).trigger('change');
                });
            });
            break;

        case 'tipe':
            el.select2($.extend({}, config, {
                placeholder: 'Pilih tipe',
                ajax: $.extend({}, config.ajax, {
                    url: "{{ route('tipe.select') }}",
                    data: function (params) {
                        // Ambil brand_id dari OUTER repeater item terdekat
                        const outerItem = el.closest('[data-repeater-item]').parents('[data-repeater-item]').first();
                        const brandID = outerItem.find('select[data-type="brand"]').val();

                        return {
                            q: params.term || '',
                            brandID: brandID || '' // backend akan filter by brandID
                        };
                    }
                })
            }));

            // Cegah buka dropdown tipe kalau brand belum dipilih
            el.off('select2:opening.guard').on('select2:opening.guard', function (evt) {
                const outerItem = el.closest('[data-repeater-item]').parents('[data-repeater-item]').first();
                const brandID = outerItem.find('select[data-type="brand"]').val();
                if (!brandID) {
                    evt.preventDefault();
                    if (typeof toastr !== 'undefined') {
                        toastr.warning('Pilih brand terlebih dahulu');
                    } else {
                        alert('Pilih brand terlebih dahulu');
                    }
                }
            });
            break;

        case 'satuan':
            el.select2($.extend({}, config, {
                placeholder: 'Pilih satuan',
                ajax: $.extend({}, config.ajax, { url: "{{ route('satuan.select') }}" })
            }));
            break;
    }
}



    // === Format Rupiah Otomatis (tanpa hapus titik saat submit) ===
    function initFormatRupiah(container) {
    container.find('.format-rupiah').each(function () {
        let input = $(this);

        input.off('input').on('input', function (e) {
            let cursorPos = this.selectionStart;
            let raw = this.value.replace(/\D/g, ''); // ambil hanya angka
            if (raw === '') {
                this.value = '';
                input.data('value', '');
                return;
            }

            // Simpan nilai mentah di data-value (biar backend bisa akses kalau mau)
            input.data('value', raw);

            // Format tampilan
            this.value = new Intl.NumberFormat('id-ID').format(parseInt(raw));

            // Kembalikan kursor di akhir
            this.setSelectionRange(this.value.length, this.value.length);
        });
    });
}

    
    // === FIX untuk modal: reinit select2 saat modal tampil ===
    $('#Modal_Tambah_Data').on('shown.bs.modal', function () {
        $('[data-kt-repeater="select2"]').each(function () {
            let el = $(this);
            let type = el.data('type');
            if (!el.hasClass('select2-hidden-accessible')) {
                initSelect2(el, type);
            }
        });

        initFormatRupiah($('#repeater-barang'));
    });
    </script>
    
    


        <script type="text/javascript">
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }
            $(document).ready(function() {
                var canShow = @json(auth()->user()->can('barang-show'));
                var canEdit = @json(auth()->user()->can('barang-edit'));
                var canDelete = @json(auth()->user()->can('barang-delete'));
                var canMassDelete = @json(auth()->user()->can('barang-massdelete'));

                var table = $('.chimox').DataTable({
                    processing: true,
                    language: {
                        processing: "Please Wait ...",
                        loadingRecords: false,
                        zeroRecords: "Tidak ada data yang ditemukan",
                        emptyTable: "Tidak ada data yang tersedia di tabel ini",
                        search: "Cari:",
                    },
                    serverSide: true,
                    order: false,
                    ajax: {
                        url: "{{ route('get-barang') }}",
                        type: 'GET',
                        data: function(d) {
                            d.kategori_id = $('#filter_kategori_id').val();
                            d.brand_id = $('#filter_brand_id').val();
                            d.tipe_id = $('#filter_tipe_id').val();
                            d.size = $('#filter_size').val();
                            d.stok = $('#filter_stok').val();
                            d.min_jual = $('#filter_min_jual').val();
                            d.max_jual = $('#filter_max_jual').val();
                            d.min_beli = $('#filter_min_beli').val();
                            d.max_beli = $('#filter_max_beli').val();
                        }
                    },
                    columns: [
                        // Kondisi untuk Mass Delete Checkbox
                        canMassDelete ? {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                return '<div class="form-check form-check-sm form-check-custom form-check-solid">' +
                                    '<input class="form-check-input" type="checkbox" value="' + full
                                    .id + '" />' +
                                    '</div>';
                            }
                        } : null,

                        {
                            data: 'nama',
                            name: 'nama',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kategori_id',
                            name: 'kategori_id',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'brand_id',
                            name: 'brand_id',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'size',
                            name: 'size',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'stok',
                            name: 'stok',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'harga_jual',
                            name: 'harga_jual',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'harga_beli',
                            name: 'harga_beli',
                            orderable: false,
                            searchable: false
                        },
                     
                        // Kondisi untuk menampilkan kolom Action
                        (canShow || canEdit || canDelete) ? {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        } : null
                    ].filter(column => column !== null) // Filter untuk menghapus kolom null
                });


// Event inline edit
$(document).on('change', '.inline-edit', function() {
    const el = $(this);
    const id = el.data('id');
    const field = el.data('field');
    let value = el.val();

    // Hilangkan format rupiah sebelum kirim
    if (el.hasClass('format-rupiah')) {
        value = value.replace(/\./g, '').replace(/[^0-9]/g, '');
    }

    el.prop('disabled', true); // lock sementara

    $.ajax({
        url: "{{ route('barang.update-inline') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id,
            field,
            value
        },
        success: function(res) {
            el.prop('disabled', false);
            if (res.success) {
                toastr.success('Data berhasil diperbarui');
            } else {
                toastr.error('Gagal memperbarui data');
            }
        },
        error: function(xhr) {
            el.prop('disabled', false);
            toastr.error('Terjadi kesalahan saat menyimpan');
            console.error(xhr.responseText);
        }
    });
});
$(document).on('input', '.format-rupiah', function() {
    let val = $(this).val().replace(/\D/g, '');
    $(this).val(new Intl.NumberFormat('id-ID').format(val));
});


                $(document).ready(function() {
                    var button = document.querySelector("#refresh-table-btn");

                    $('#refresh-table-btn').on('click', function() {
                        // Disable the button to prevent further clicks
                        button.setAttribute("data-kt-indicator", "on");
                        button.disabled = true; // Disable the button

                        // Reload the DataTable
                        table.ajax.reload(function() {
                            // Re-enable the button after table is refreshed
                            button.removeAttribute("data-kt-indicator");
                            button.disabled = false; // Enable the button again
                        });
                    });
                });

                $('#search').on('keyup', debounce(function() {
                    var table = $('.chimox').DataTable();
                    table.search($(this).val()).draw();
                }, 500));

                $('#filter_kategori_id').on('change', function() {
                    table.ajax.reload();
                });

                // Trigger reload saat brand berubah
                $('#filter_brand_id').on('change', function() {
                    table.ajax.reload();
                });

                $('#filter_tipe_id').on('change', function() {
                    table.ajax.reload();
                });

                $('#filter_size').on('keyup', debounce(function() {
                    table.ajax.reload();
                }, 500));

                $('#filter_stok').on('change', function() {
                    table.ajax.reload();
                });

                // === Filter Harga Jual (min–max) ===
                $('#filter_min_jual, #filter_max_jual').on('keyup change', debounce(function() {
                    table.ajax.reload();
                }, 500));

                // === Filter Harga Beli (min–max) ===
                $('#filter_min_beli, #filter_max_beli').on('keyup change', debounce(function() {
                    table.ajax.reload();
                }, 500));





              




                // SHOW MODAL TAMBAH DATA
                // === SHOW MODAL TAMBAH DATA ===
$('#btn_tambah_data').on('click', function () {
    $('#Modal_Tambah_Data').modal('show');
});

// === CEGAH ENTER MENGIRIM FORM / PINDAH FIELD ===
$(document).on('keypress', 'form input', function (e) {
    if (e.which === 13) e.preventDefault();
});

$(document).on('keypress', 'input[name="kode"], input[name="kode_variasi"]', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        // pindahkan fokus ke nama item (kalau ada)
        $(this).closest('.row').find('input[name="nama"]').focus();
    }
});

// === BLOCK UI UNTUK MODAL ===
const target = document.querySelector("#tambah-modal-content");
const blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> <span class="text-white">Please Wait ...</span></div>',
    overlayClass: "bg-dark bg-opacity-50",
});

// === FORM SUBMIT AJAX ===
$('#FormTambahModalID').on('submit', function (event) {
    event.preventDefault();

    // === AUTO HAPUS PESAN ERROR SAAT INPUT DIEDIT ===
$(document).on('input change select2:select select2:clear', 'input, select', function () {
    let name = $(this).attr('name');
    if (!name) return;

    // Ubah format name jadi class validasi
    let fieldName = name
        .replace(/\[/g, '_')
        .replace(/\]/g, '')
        .replace(/\./g, '_');

    $('span.' + fieldName + '_error_add').text('');
});


    blockUI.block();
    const $btn = $('#btn-add-data');
    $btn.prop('disabled', true);
    $btn.find('.add-data-label').hide();
    $btn.find('.add-data-progress').show();

    // CSRF setup
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.ajax({
        url: "{{ route('barang.store') }}",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        cache: false,
        dataType: "json",
        beforeSend: function () {
            $("span.error-text").text("");
        },
        success: function (result) {
            setTimeout(function () {
                // CASE 1: VALIDASI ERROR
                if (result.errors) {
                    $.each(result.errors, function (prefix, val) {
                        // ubah titik (.) jadi underscore (_)
                        const fieldName = prefix.replace(/\./g, "_");
                        $("span." + fieldName + "_error_add").text(val[0]);
                    });

                    Swal.fire({
                        title: "Gagal",
                        text: "Terjadi kesalahan validasi, periksa kembali input Anda.",
                        icon: "error",
                        timer: 1800,
                        confirmButtonText: "Oke",
                    });
                }

                // CASE 2: APLIKASI ERROR
                else if (result.error) {
                    $("#Modal_Tambah_Data").modal("hide");
                    Swal.fire({
                        title: result.judul || "Error",
                        text: result.error,
                        icon: "error",
                        timer: 1800,
                        confirmButtonText: "Oke",
                    });
                }

                // CASE 3: SUKSES
                else {
                    $("#Modal_Tambah_Data").modal("hide");
                    $(".chimox").DataTable().ajax.reload();

                    Swal.fire({
                        title: "Berhasil",
                        text: result.success || "Data berhasil disimpan.",
                        icon: "success",
                        timer: 1500,
                        confirmButtonText: "Oke",
                    });
                }

                // Reset tombol & unblock
                $btn.prop('disabled', false);
                $btn.find('.add-data-label').show();
                $btn.find('.add-data-progress').hide();
                blockUI.release();
            }, 800);
        },
        error: function (xhr) {
            blockUI.release();
            $btn.prop('disabled', false);
            $btn.find('.add-data-label').show();
            $btn.find('.add-data-progress').hide();

            Swal.fire({
                title: "Error",
                text: "Terjadi kesalahan server: " + xhr.statusText,
                icon: "error",
            });
        }
    });
});

// === RESET FORM SAAT MODAL DITUTUP ===
$("#Modal_Tambah_Data").on("hidden.bs.modal", function () {
    resetForm();
});

// === AUTO HAPUS PESAN ERROR SAAT USER MENGUBAH INPUT ===
$(document).on('input change', 'input, select', function () {
    const name = $(this).attr('name');
    if (!name) return;
    const fieldName = name
        .replace(/\[/g, '_')
        .replace(/\]/g, '')
        .replace(/\./g, '_');
    $('span.' + fieldName + '_error_add').text('');
});




                var targetedit = document.querySelector("#edit-modal-content");
                var blockUIEdit = new KTBlockUI(targetedit, {
                    message: '<div class="blockui-message"><span class="spinner-border text-danger"></span> <span class="text-white">Please Wait ...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50"
                });

                // EDIT MODAL

                var id;
                $('body').on('click', '#getEditRowData', function(e) {

                    id = $(this).data('id');
                    $.ajax({
                        url: "barang/" + id + "/edit",
                        dataType: "json",
                        success: function(result) {
                            console.log(result);
                            $('#EditRowModalBody').html(result.html);
                            $('#Modal_Edit_Data').modal('show');
                        }
                    });
                });

                // UPDATE MODAL
                $('#FormEditModalID').on('submit', function(e) {
                    e.preventDefault();
                    blockUIEdit.block();
                    $('#btn-edit-data .edit-data-label').hide();
                    $('#btn-edit-data .edit-data-progress').show();
                    $('#btn-edit-data').prop('disabled', true);
                    var id = $('#hidden_id').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "barang/" + id,
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $(document).find("span.error-text").text("");
                        },
                        success: function(result) {
                            if (result.errors) {
                                setTimeout(function() {
                                    blockUIEdit.release();
                                    $.each(result.errors, function(prefix, val) {
                                        $("span." + prefix + "_error_edit").text(
                                            val[0]);
                                    });

                                    Swal.fire({
                                        title: "Error",
                                        text: "Terjadi kesalahan validasi, periksa kembali input Anda.",
                                        icon: "error",
                                        timer: 1500,
                                        confirmButtonText: "Ok",
                                    });
                                    $('#btn-edit-data .edit-data-label').show();
                                    $('#btn-edit-data .edit-data-progress').hide();
                                    $('#btn-edit-data').prop('disabled', false);
                                }, 1000);
                            } else if (result.error) {

                                setTimeout(function() {
                                    $("#Modal_Edit_Data").modal("hide");
                                    blockUIEdit.release();

                                    Swal.fire({
                                        title: result.judul,
                                        text: result.error,
                                        icon: "error",
                                        timer: 1500,
                                        confirmButtonText: "Oke",
                                    });
                                    $('#btn-edit-data .edit-data-label').show();
                                    $('#btn-edit-data .edit-data-progress').hide();
                                    $('#btn-edit-data').prop('disabled', false);



                                }, 1000);


                            } else {
                                setTimeout(function() {
                                    $("#Modal_Edit_Data").modal("hide");
                                    $(".chimox").DataTable().ajax.reload();
                                    blockUIEdit.release();

                                    Swal.fire({
                                        text: result.success,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        timer: 1500,
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        },
                                    });
                                    $('#btn-edit-data .edit-data-label').show();
                                    $('#btn-edit-data .edit-data-progress').hide();
                                    $('#btn-edit-data').prop('disabled', false);


                                }, 1000);
                            }
                        },
                    });
                });






                var targethapus = document.querySelector("#hapus-modal-content");
                var blockUIHapus = new KTBlockUI(targethapus, {
                    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> <span class="text-white">Please Wait ...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50"
                });

                // Delete article Ajax request.
                var deleteID;
                $('body').on('click', '#getDeleteId', function() {
                    deleteID = $(this).data('id');
                })
                $('#SubmitDeleteRowForm').click(function(e) {
                    e.preventDefault();
                    blockUIHapus.block();

                    $('#SubmitDeleteRowForm .delete-data-label').hide();
                    $('#SubmitDeleteRowForm .delete-data-progress').show();
                    $('#SubmitDeleteRowForm').prop('disabled', true);

                    var id = deleteID;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "barang/" + id,
                        method: 'DELETE',
                        success: function(result) {
                            if (result.error) {

                                setTimeout(function() {
                                    $("#Modal_Hapus_Data").modal("hide");
                                    blockUIHapus.release();

                                    Swal.fire({
                                        title: result.judul,
                                        text: result.error,
                                        icon: "error",
                                        timer: 1500,
                                        confirmButtonText: "Oke",
                                    });
                                    $('#SubmitDeleteRowForm .delete-data-label').show();
                                    $('#SubmitDeleteRowForm .delete-data-progress').hide();
                                    $('#SubmitDeleteRowForm').prop('disabled', false);

                                }, 1000);


                            } else {

                                setTimeout(function() {
                                    $("#Modal_Hapus_Data").modal("hide");
                                    $(".chimox").DataTable().ajax.reload();
                                    blockUIHapus.release();
                                    Swal.fire({
                                        text: result.success,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        timer: 1500,
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        }
                                    });
                                    $('#SubmitDeleteRowForm .delete-data-label').show();
                                    $('#SubmitDeleteRowForm .delete-data-progress').hide();
                                    $('#SubmitDeleteRowForm').prop('disabled', false);

                                }, 1000);
                            }
                        },
                    });

                });

                // Function to handle individual checkbox change event
                $('.chimox').on('change', 'input.form-check-input', function() {
                    updateToolbar();

                    // Check if all checkboxes are selected
                    var allChecked = $('.chimox tbody input.form-check-input').length === $(
                        '.chimox tbody input.form-check-input:checked').length;

                    // Update the "Select All" checkbox
                    $('[data-kt-check]').prop('checked', allChecked);
                });

                // Function to handle the "Select All" checkbox
                $('[data-kt-check]').on('change', function() {
                    var isChecked = $(this).is(':checked');
                    var target = $(this).data('kt-check-target');

                    // Check/uncheck all checkboxes in the target
                    $(target).prop('checked', isChecked);

                    // Update toolbar display
                    updateToolbar();
                });

                // Function to update the toolbar based on the selected checkboxes
                function updateToolbar() {
                    var selectedCount = $('.chimox tbody input.form-check-input:checked').length;

                    // Update the count in the toolbar
                    $('[data-kt-user-table-select="selected_count"]').text(selectedCount);

                    if (selectedCount > 0) {
                        // Show the toolbar if there are selected checkboxes
                        $('[data-kt-user-table-toolbar="selected"]').removeClass('d-none');
                    } else {
                        // Hide the toolbar if no checkbox is selected
                        $('[data-kt-user-table-toolbar="selected"]').addClass('d-none');
                    }
                }




                // Function to handle checkbox change event
                $('.chimox').on('change', 'input.form-check-input', function() {
                    var selectedCount = $('.chimox tbody input.form-check-input:checked').length;

                    // Update selected count
                    $('[data-kt-user-table-select="selected_count"]').text(selectedCount);

                    if (selectedCount > 0) {
                        // Remove the d-none class to show the toolbar if any checkbox is selected
                        $('[data-kt-user-table-toolbar="selected"]').removeClass('d-none');
                    } else {
                        // Add the d-none class to hide the toolbar if no checkbox is selected
                        $('[data-kt-user-table-toolbar="selected"]').addClass('d-none');
                    }
                });



                $('button[data-kt-user-table-select="delete_selected"]').on('click', function() {
                    var selectedIds = [];

                    // Get all selected checkboxes
                    $('.chimox tbody input.form-check-input:checked').each(function() {
                        selectedIds.push($(this).val()); // Collect the user IDs
                    });

                    if (selectedIds.length > 0) {
                        // Confirm before deleting
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You are about to delete ' + selectedIds.length + ' data.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete!',
                            cancelButtonText: 'No, cancel!',

                            customClass: {
                                confirmButton: "btn btn-sm btn-primary",
                                cancelButton: "btn btn-sm btn-secondary",
                            }

                        }).then(function(result) {
                            if (result.isConfirmed) {
                                // Make an AJAX call to mass delete the users
                                $.ajax({
                                    url: "{{ route('barang.mass-delete') }}", // Pastikan route ini ada
                                    type: 'POST',
                                    data: {
                                        ids: selectedIds,
                                        _token: '{{ csrf_token() }}' // CSRF token for security
                                    },
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            Swal.fire({
                                                title: 'Deleted!',
                                                text: response.message,
                                                icon: 'success',
                                                timer: 1500, // Timer harus ditempatkan di dalam objek konfigurasi

                                            });


                                            // Reload the DataTable to reflect changes
                                            table.ajax.reload();

                                            // Reset the toolbar and uncheck the "Select All" checkbox
                                            $('[data-kt-user-table-toolbar="selected"]')
                                                .addClass('d-none');
                                            $('[data-kt-user-table-select="selected_count"]')
                                                .text(0);

                                            // Uncheck "Select All" checkbox
                                            $('[data-kt-check]').prop('checked', false);
                                        } else {
                                            Swal.fire('Error!', response.message, 'error');
                                        }
                                    },
                                    error: function() {
                                        Swal.fire('Error!',
                                            'An error occurred while deleting data.',
                                            'error');
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire('Warning!', 'No data selected for deletion.', 'warning');
                    }
                });







            });
            // Make the DIV element draggable:
            var elements = document.querySelectorAll('#Modal_Tambah_Data, #Modal_Edit_Data, #Modal_Hapus_Data');
            elements.forEach(function(element) {
                dragElement(element);

                function dragElement(elmnt) {
                    var pos1 = 0,
                        pos2 = 0,
                        pos3 = 0,
                        pos4 = 0;
                    if (elmnt.querySelector('.modal-header')) {
                        // if present, the header is where you move the DIV from:
                        elmnt.querySelector('.modal-header').onmousedown = dragMouseDown;
                    } else {
                        // otherwise, move the DIV from anywhere inside the DIV:
                        elmnt.onmousedown = dragMouseDown;
                    }

                    function dragMouseDown(e) {
                        e = e || window.event;
                        // get the mouse cursor position at startup:
                        pos3 = e.clientX;
                        pos4 = e.clientY;
                        document.onmouseup = closeDragElement;
                        // call a function whenever the cursor moves:
                        document.onmousemove = elementDrag;
                    }

                    function elementDrag(e) {
                        e = e || window.event;
                        // calculate the new cursor position:
                        pos1 = pos3 - e.clientX;
                        pos2 = pos4 - e.clientY;
                        pos3 = e.clientX;
                        pos4 = e.clientY;
                        // set the element's new position:
                        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
                    }

                    function closeDragElement() {
                        // stop moving when mouse button is released:
                        document.onmouseup = null;
                        document.onmousemove = null;
                    }
                }
            });
        </script>


<script>
    $(document).ready(function() {


// === 1️⃣ KATEGORI (bebas) ===
$('#filter_kategori_id').select2({
    ajax: {
        url: "{{ route('kategori.select') }}",
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: data.map(function (item) {
                    return { id: item.id, text: item.nama };
                })
            };
        }
    }
});
// === 2️⃣ BRAND (bebas) ===
$('#filter_brand_id').select2({
        ajax: {
            url: "{{ route('brand.select') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return { id: item.id, text: item.nama };
                    })
                };
            }
        }
    });

    // === 3️⃣ TIPE (nested dari brand) ===
    $('#filter_tipe_id').select2({
    ajax: {
        url: "{{ route('tipe.select') }}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            // ⬇️ kirim brandID ke controller
            return {
                q: params.term || '',
                brandID: $('#filter_brand_id').val() || ''
            };
        },
        processResults: function (data) {
            return {
                results: data.map(function (item) {
                    return { id: item.id, text: item.nama };
                })
            };
        }
    }
});


// 🚫 Awalnya disable dropdown tipe
$('#filter_tipe_id').prop('disabled', true);

// 🔄 Aktifkan tipe setelah brand dipilih
$('#filter_brand_id').on('change', function () {
    const brandID = $(this).val();

    // Kosongkan tipe setiap kali brand berubah
    $('#filter_tipe_id').val(null).trigger('change');

    if (brandID) {
        $('#filter_tipe_id').prop('disabled', false);
    } else {
        $('#filter_tipe_id').prop('disabled', true);
    }

});




    });
</script>
    @endpush
@endsection

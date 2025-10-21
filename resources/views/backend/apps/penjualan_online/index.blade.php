@extends('layouts.backend.index')
@section('title', 'Penjualan Online')
@section('content')


    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Penjualan Online
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
                    <li class="breadcrumb-item text-gray-900">Penjualan Online List</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center pt-4 pb-7 pt-lg-1 pb-lg-2">
                <!--begin::Wrapper-->
                <div class="me-3">
                    
                    <!--end::Menu-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Button-->
                @can('penjualan-online-create')
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
        <!--begin::Card-->
        <div class="card border-top-accent shadow-sm mb-xl-10 mb-5">
            <!--begin::Card header-->
            <div class="card-header d-flex justify-content-between align-items-center border-gray-400">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" data-kt-user-table-filter="search" id="search"
                            class="form-control w-450px ps-13" placeholder="Search data" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                         <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-sm btn-danger me-2" data-kt-user-table-select="delete_selected"> <i
                                class="ki-outline ki-trash  me-2"></i>Delete
                            Selected</button>
                    </div>
                    <!--end::Group actions-->
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
                            @can('brand-massdelete')
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#chimox .form-check-input" value="1" />
                                    </div>
                                </th>
                            @endcan
                            <th class="min-w-125px">Tanggal</th>
                            <th class="min-w-100px">Kode Transaksi</th>
                             <th class="min-w-100px">Pembayaran</th>
                            <th class="min-w-100px text-end">Jumlah</th>
                            <th class="min-w-100px text-end">Total Harga</th>
                            <th class="min-w-100px text-end">Potongan</th>
                           <th class="min-w-100px text-end">Grand Total</th>
                            @canany(['penjualan-online-show', 'penjualan-online-edit', 'penjualan-online-delete'])
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

                          
                            


                            <!--begin::Repeater-->
                    <div id="kt_docs_repeater_nested">
                        <div data-repeater-list="penjualan_list">
                            <div data-repeater-item>
                                <div class="form-group row mb-5 border rounded p-4 bg-light-subtle">

                                    <!-- 🔹 Jenis Pembayaran -->
                                    <div class="col-md-3">
    <label class="form-label fw-semibold">Jenis Pembayaran:</label>
    <select name="jenis_pembayaran_id"
        class="form-select form-select-sm jenis-pembayaran-select"
        data-placeholder="Pilih jenis pembayaran...">
    </select>
<span class="text-danger error-text" data-error-for="jenis_pembayaran_id"></span>

</div>


                                    <!-- 🔹 Inner Repeater: Barang -->
                                    <div class="col-md-6">
                                        <div class="inner-repeater">
    <div data-repeater-list="barang_list" class="mb-3">
        <div data-repeater-item class="pb-3 border-bottom-dashed">
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Barang:</label>
                    <select name="barang_id"
                        class="form-select form-select-sm barang-select"
                        data-placeholder="Cari Barang..."
                        data-kt-repeater="select2"></select>
<span class="text-danger error-text" data-error-for="barang_id"></span>

                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Harga:</label>
                    <input type="text" name="harga_jual" class="form-control form-control-sm harga-jual" readonly placeholder="0">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Qty:</label>
                    <input type="number" name="qty" class="form-control form-control-sm qty-input" min="1" value="1">
<span class="text-danger error-text" data-error-for="qty"></span>

                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Subtotal:</label>
                    <input type="text" name="subtotal" class="form-control form-control-sm subtotal-field" readonly placeholder="0">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" data-repeater-delete class="btn btn-icon btn-sm btn-light-danger">
                        <i class="ki-outline ki-trash fs-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" data-repeater-create class="btn btn-sm btn-light-primary mt-2">
        <i class="ki-outline ki-plus fs-2"></i> Tambah Barang
    </button>
</div>

                                    </div>

                                    <!-- 🔹 Total / Potongan / Grand Total -->
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">Total:</label>
                                                <input type="text" name="total_harga" class="form-control form-control-sm rupiah-input total-harga" readonly placeholder="0">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">Potongan:</label>
                                                <input type="text" name="potongan" class="form-control form-control-sm rupiah-input potongan-input" placeholder="0">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">Grand Total:</label>
                                                <input type="text" name="grand_total" class="form-control form-control-sm rupiah-input grand-total" readonly placeholder="0">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hapus transaksi -->
                                    <div class="col-md-12 text-end mt-3">
                                        <button type="button" data-repeater-delete class="btn btn-sm btn-light-danger">
                                            <i class="ki-outline ki-trash fs-2"></i> Hapus Transaksi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="button" data-repeater-create class="btn btn-flex btn-light-primary">
                                <i class="ki-outline ki-plus fs-3"></i> Tambah Penjualan
                            </button>
                        </div>
                    </div>
                    <!--end::Repeater-->
                            


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
        <div class="modal-dialog modal-dialog-centered mw-950px">
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


    <!-- Modal Detail Brand -->
<div class="modal fade" id="Modal_Show_Data" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-3 shadow">
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold">Detail Data</h5>
          <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-dismiss="modal">
            <i class="ki-outline ki-cross fs-2"></i>
          </button>
        </div>
        <div class="modal-body" id="modalShowBody">
          <div class="text-center py-10 text-muted">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3">Memuat data detail...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  

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
            
            
            </style>

            <style>
.select2-results__option[aria-disabled="true"] {
    background-color: #f8d7da !important;
    color: #842029 !important;
    cursor: not-allowed !important;
    font-weight: bold;
}
.select2-results__option[aria-disabled="true"]:hover {
    background-color: #f8d7da !important;
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
$(document).ready(function () {
 function reIndexRepeater() {
    $('#kt_docs_repeater_nested [data-repeater-list="penjualan_list"] > [data-repeater-item]').each(function (i, outer) {
        const $outer = $(outer);

        // ✅ Jenis Pembayaran
        $outer.find('[data-error-for="jenis_pembayaran_id"]')
            .attr('class', `text-danger error-text penjualan_list_${i}_jenis_pembayaran_id_error_add`);

        // ✅ Barang List
        $outer.find('[data-repeater-list="barang_list"] > [data-repeater-item]').each(function (j, inner) {
            const $inner = $(inner);

            $inner.find('[data-error-for="barang_id"]')
                .attr('class', `text-danger error-text penjualan_list_${i}_barang_list_${j}_barang_id_error_add`);

            $inner.find('[data-error-for="qty"]')
                .attr('class', `text-danger error-text penjualan_list_${i}_barang_list_${j}_qty_error_add`);
        });
    });
}
    // Inisialisasi Nested Repeater
    $('#kt_docs_repeater_nested').repeater({
        repeaters: [{
            selector: '.inner-repeater',
            show: function () {
                $(this).slideDown();
                initSelect2();
                initSelectJenisPembayaran();
                reIndexRepeater();

                

            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
                setTimeout(updateAllTotals, 200);
                setTimeout(reIndexRepeater, 200);
            }
        }],
        show: function () {
            $(this).slideDown();
                initSelect2();
                initSelectJenisPembayaran();
                reIndexRepeater();

        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
            setTimeout(updateAllTotals, 200);
            setTimeout(reIndexRepeater, 200);

        }
    });

    // 🔹 Fungsi Select2 Barang
    function initSelect2() {
        $('.barang-select').each(function () {
            if ($(this).data('select2')) $(this).select2('destroy');
            $(this).select2({
                dropdownParent: $('#Modal_Tambah_Data'),
                placeholder: 'Cari barang (kode / nama)...',
                allowClear: true,
                ajax: {
                    url: "{{ route('barang.select') }}",
                    dataType: 'json',
                    delay: 300,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: data.map(item => ({
                            id: item.id,
                            text: `${item.kode_barang} — ${item.nama}`,
                            kode_barang: item.kode_barang,
                            nama: item.nama,
                            harga_jual: item.harga_jual,
                            stok: item.stok,
                            disabled: item.stok <= 0 
                        }))
                    }),
                },
                templateResult: formatBarangResult,
                templateSelection: formatBarangSelection,
                minimumInputLength: 1,
                width: '100%'
            });
        });
    }

    // 🔹 Template hasil Select2
    // function formatBarangResult(data) {
    //     if (data.loading) return data.text;
    //     return $(`
    //         <div class="d-flex flex-column py-1">
    //             <span class="fw-bold text-gray-800">${data.kode_barang ?? ''} — ${data.nama ?? data.text}</span>
    //             <small class="text-muted">Harga: Rp ${parseInt(data.harga_jual ?? 0).toLocaleString('id-ID')}</small>
    //         </div>
    //     `);
    // }
    function formatBarangResult(data) {
    if (data.loading) return data.text;

    const harga = parseInt(data.harga_jual ?? 0).toLocaleString('id-ID');
    const stok = parseInt(data.stok ?? 0);

    // warna stok merah kalau habis
    const stokLabel = stok > 0
        ? `<span class="badge badge-light-success">Stok: ${stok}</span>`
        : `<span class="badge badge-light-danger">Stok Habis</span>`;

    return $(`
        <div class="d-flex flex-column py-1 ${stok <= 0 ? 'opacity-50' : ''}">
            <div class="d-flex justify-content-between">
                <span class="fw-bold text-gray-800">${data.kode_barang ?? ''} — ${data.nama ?? data.text}</span>
                ${stokLabel}
            </div>
            <small class="text-muted">Harga: Rp ${harga}</small>
        </div>
    `);
}

    // function formatBarangSelection(data) { return data.text || ''; }

    function formatBarangSelection(data) {
    if (!data.id) return data.text;
    return `${data.kode_barang ?? ''} — ${data.nama ?? data.text}`;
}


    initSelect2();


    // 🔹 Fungsi inisialisasi Select2 Jenis Pembayaran
function initSelectJenisPembayaran() {
    $('.jenis-pembayaran-select').each(function () {
        if ($(this).data('select2')) {
            $(this).select2('destroy');
        }
        $(this).select2({
            dropdownParent: $('#Modal_Tambah_Data'),
            placeholder: 'Cari jenis pembayaran...',
            allowClear: true,
            ajax: {
                url: "{{ route('jenis-pembayaran.select') }}",
                dataType: 'json',
                delay: 300,
                data: params => ({ q: params.term }),
                processResults: data => ({
                    results: data.map(item => ({
                        id: item.id,
                        text: item.nama
                    }))
                }),
            },
            minimumInputLength: 0,
            width: '100%'
        });
    });
}
initSelectJenisPembayaran();

    // 🔹 Helper format angka
    const clean = s => parseInt(String(s).replace(/\D/g, '')) || 0;
    const format = n => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // 🔹 Saat barang dipilih
    $(document).on('select2:select', '.barang-select', function (e) {
        const data = e.params.data;
        const row = $(this).closest('[data-repeater-item]');
        const harga = parseInt(data.harga_jual ?? 0);

        row.find('.harga-jual').val(format(harga));
        const qty = parseInt(row.find('.qty-input').val()) || 1;
        row.find('.subtotal-field').val(format(qty * harga));

        const outer = row.closest('[data-repeater-list="barang_list"]').closest('[data-repeater-item]');
        hitungTotal(outer);
    });

    // 🔹 Saat qty berubah
    $(document).on('input', '.qty-input', function () {
        const row = $(this).closest('[data-repeater-item]');
        const harga = clean(row.find('.harga-jual').val());
        const qty = parseInt($(this).val()) || 0;
        row.find('.subtotal-field').val(format(harga * qty));

        const outer = row.closest('[data-repeater-list="barang_list"]').closest('[data-repeater-item]');
        hitungTotal(outer);
    });

    // 🔹 Saat potongan diketik → auto format + hitung grand total
    $(document).on('input', '.potongan-input', function () {
        const input = $(this);
        let val = input.val();

        // bersihkan karakter non-angka
        const angka = clean(val);

        // format ke rupiah
        const formatted = angka > 0 ? format(angka) : '';
        input.val(formatted);

        // hitung ulang grand total
        const outer = input.closest('[data-repeater-item]');
        hitungGrandTotal(outer);
    });

    // 🔹 Hitung total per transaksi
    function hitungTotal(outer) {
        let total = 0;
        outer.find('.inner-repeater [data-repeater-item]').each(function () {
            const harga = clean($(this).find('.harga-jual').val());
            const qty = parseInt($(this).find('.qty-input').val()) || 0;
            total += harga * qty;
        });
        outer.find('.total-harga').val(format(total));
        hitungGrandTotal(outer);
    }

    // 🔹 Hitung grand total (total - potongan)
    function hitungGrandTotal(outer) {
        const total = clean(outer.find('.total-harga').val());
        const potongan = clean(outer.find('.potongan-input').val());
        const grand = Math.max(total - potongan, 0);
        outer.find('.grand-total').val(format(grand));
    }

    // 🔹 Update semua total setelah hapus repeater
    function updateAllTotals() {
        $('[data-repeater-list="penjualan_list"] > [data-repeater-item]').each(function () {
            hitungTotal($(this));
        });
    }

});
</script>



<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-show-brand', function(e) {
            e.preventDefault();
    
            let id = $(this).data('id');
            let modal = new bootstrap.Modal(document.getElementById('Modal_Show_Data'));
            let body = $('#modalShowBody');
    
            // tampilkan modal + loading
            body.html(`
                <div class="text-center py-10 text-muted">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3">Memuat data brand...</p>
                </div>
            `);
            modal.show();
    
            // load konten dari route show
            $.ajax({
                url: `/penjualan-online/${id}`,
                type: 'GET',
                success: function(res) {
                    body.html(res);
                },
                error: function(xhr) {
                    body.html(`
                        <div class="alert alert-danger">
                            Gagal memuat data.<br>${xhr.responseJSON?.message || 'Terjadi kesalahan server.'}
                        </div>
                    `);
                }
            });
        });
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
                var canShow = @json(auth()->user()->can('penjualan-online-show'));
                var canEdit = @json(auth()->user()->can('penjualan-online-edit'));
                var canDelete = @json(auth()->user()->can('penjualan-online-delete'));
                var canMassDelete = @json(auth()->user()->can('penjualan-online-massdelete'));

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
                        url: "{{ route('get-penjualan-online') }}",
                        type: 'GET',
                        data: function(d) {}
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
                            data: 'tanggal_penjualan',
                            name: 'tanggal_penjualan',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kode_transaksi',
                            name: 'kode_transaksi',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'jenis_pembayaran_id',
                            name: 'jenis_pembayaran_id',
                            orderable: false,
                            searchable: false
                        },


                          {
                            data: 'total_item',
                            name: 'total_item',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'total_harga',
                            name: 'total_harga',
                            orderable: false,
                            searchable: false
                        },
                         {
                            data: 'potongan',
                            name: 'potongan',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'total',
                            name: 'total',
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

                $('#btnResetSearch').click(function() {
                    $('#filterrole').val(null).trigger('change');
                    table.draw(true);
                });

                $('#btnFiterSubmitSearch').click(function() {
                    table.draw(true);
                });



             function reIndexRepeater() {
    $('#kt_docs_repeater_nested [data-repeater-list="penjualan_list"] > [data-repeater-item]').each(function (i, outer) {
        const $outer = $(outer);

        // ✅ Jenis Pembayaran
        $outer.find('[data-error-for="jenis_pembayaran_id"]')
            .attr('class', `text-danger error-text penjualan_list_${i}_jenis_pembayaran_id_error_add`);

        // ✅ Barang List
        $outer.find('[data-repeater-list="barang_list"] > [data-repeater-item]').each(function (j, inner) {
            const $inner = $(inner);

            $inner.find('[data-error-for="barang_id"]')
                .attr('class', `text-danger error-text penjualan_list_${i}_barang_list_${j}_barang_id_error_add`);

            $inner.find('[data-error-for="qty"]')
                .attr('class', `text-danger error-text penjualan_list_${i}_barang_list_${j}_qty_error_add`);
        });
    });
}




                // SHOW MODAL TAMBAH DATA
                $('#btn_tambah_data').click(function() {
                    $('#Modal_Tambah_Data').modal('show');

                });

                var target = document.querySelector("#tambah-modal-content");
                var blockUI = new KTBlockUI(target, {
                    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> <span class="text-white">Please Wait ...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50",
                });

                $('#FormTambahModalID').on('submit', function(event) {
                    event.preventDefault();
                    blockUI.block();

                    $('#btn-add-data .add-data-label').hide();
                    $('#btn-add-data .add-data-progress').show();
                    $('#btn-add-data').prop('disabled', true);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('penjualan-online.store') }}",
                        method: 'post',
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
                                reIndexRepeater(); // ✅ Pastikan span sudah sesuai index repeater saat ini

                                $.each(result.errors, function (prefix, val) {
                                    const fieldName = prefix.replace(/\./g, "_");
                                    const $target = $("span." + fieldName + "_error_add");

                                    if ($target.length) {
                                        $target.text(val[0]);
                                    } else {
                                        console.warn("⚠️ span error tidak ditemukan:", fieldName);
                                    }
                                });

                                blockUI.release();

                                Swal.fire({
                                    title: "Gagal",
                                    text: "Terjadi kesalahan validasi, periksa kembali input Anda.",
                                    icon: "error",
                                    timer: 1500,
                                    confirmButtonText: "Oke",
                                });

                                $('#btn-add-data .add-data-label').show();
                                $('#btn-add-data .add-data-progress').hide();
                                $('#btn-add-data').prop('disabled', false);
                            }
                            else if (result.error) {
                                setTimeout(function() {
                                    $("#Modal_Tambah_Data").modal("hide");
                                    blockUI.release();

                                    Swal.fire({
                                        title: result.judul,
                                        text: result.error,
                                        icon: "error",
                                        timer: 1500,
                                        confirmButtonText: "Oke",
                                    });

                                    $('#btn-add-data .add-data-label').show();
                                    $('#btn-add-data .add-data-progress').hide();
                                    $('#btn-add-data').prop('disabled', false);


                                }, 1000);
                            } else {

                                setTimeout(function() {
                                    $("#Modal_Tambah_Data").modal("hide");
                                    $(".chimox").DataTable().ajax.reload();
                                    blockUI.release();
                                    Swal.fire({
                                        title: "Berhasil",
                                        text: result.success,
                                        icon: "success",
                                        timer: 1500,
                                        confirmButtonText: "Oke",
                                    });

                                    $('#btn-add-data .add-data-label').show();
                                    $('#btn-add-data .add-data-progress').hide();
                                    $('#btn-add-data').prop('disabled', false);

                                }, 1000);
                            }
                        },

                        error: function(xhr) {
        blockUI.release();
        let msg = "Terjadi kesalahan di server.";

        if (xhr.responseJSON && xhr.responseJSON.error) {
            msg = xhr.responseJSON.error;
        }

        Swal.fire({
            title: "Gagal",
            text: msg,
            icon: "error",
            confirmButtonText: "Oke",
        });

         $('#btn-add-data .add-data-label').show();
                                    $('#btn-add-data .add-data-progress').hide();
                                    $('#btn-add-data').prop('disabled', false);
    }
                    });
                });


                // Tombol "Batal"
                $("#Modal_Tambah_Data").on("hidden.bs.modal", function() {
                    resetForm();
                });



                var targetedit = document.querySelector("#edit-modal-content");
                var blockUIEdit = new KTBlockUI(targetedit, {
                    message: '<div class="blockui-message"><span class="spinner-border text-danger"></span> <span class="text-white">Please Wait ...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50"
                });

                function initEditForm() {
    const clean = s => parseInt(String(s).replace(/\D/g, '')) || 0;
    const format = n => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // 🔹 Inisialisasi Repeater
    $('#kt_repeater_edit_penjualan').repeater({
        show: function () {
        $(this).slideDown();

        // tambahkan hidden input detail_id kosong untuk item baru
        if ($(this).find('input[name="detail_id"]').length === 0) {
            $(this).prepend('<input type="hidden" name="detail_id" value="">');
        }

        
        initSelect2BarangEdit();
        updateAllTotalsEdit();
    },
    hide: function (deleteElement) {
        const item = $(this);
        item.slideUp(300, function () {
            item.remove(); // pastikan benar-benar hilang dari DOM
            updateAllTotalsEdit(); // baru hitung ulang setelah terhapus
        });
    }
    });

    // 🔹 Barang Select2
    function initSelect2BarangEdit() {
        $('.edit-barang-select').each(function () {
            if ($(this).data('select2')) $(this).select2('destroy');
            $(this).select2({
                dropdownParent: $('#Modal_Edit_Data'),
                placeholder: 'Cari barang...',
                ajax: {
                    url: "{{ route('barang.select') }}",
                    dataType: 'json',
                    delay: 300,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: data.map(item => ({
                            id: item.id,
                            text: `${item.kode_barang} — ${item.nama}`,
                            stok: item.stok,
                            harga_jual: item.harga_jual,
                            disabled: item.stok <= 0
                        }))
                    }),
                },
                templateResult: d => {
                    if (d.loading) return d.text;
                    const warna = d.stok <= 0 ? 'text-danger' : 'text-muted';
                    return $(`
                        <div class="d-flex flex-column py-1">
                            <span class="fw-bold ${d.stok <= 0 ? 'opacity-50' : ''}">
                                ${d.text}
                            </span>
                            <small class="${warna}">
                                Stok: ${d.stok} • Harga: Rp ${format(d.harga_jual ?? 0)}
                            </small>
                        </div>
                    `);
                },
                templateSelection: d => d.text,
                width: '100%'
            });
        });
    }

    // 🔹 Jenis Pembayaran Select2
    $('.edit-jenis-pembayaran-select').each(function () {
        if ($(this).data('select2')) $(this).select2('destroy');
        $(this).select2({
            dropdownParent: $('#Modal_Edit_Data'),
            placeholder: 'Pilih jenis pembayaran...',
            ajax: {
                url: "{{ route('jenis-pembayaran.select') }}",
                dataType: 'json',
                delay: 300,
                data: params => ({ q: params.term }),
                processResults: data => ({
                    results: data.map(i => ({ id: i.id, text: i.nama }))
                }),
            },
            width: '100%'
        });
    });

    // 🔹 Qty / Barang / Potongan trigger perhitungan
    $(document)
        .off('select2:select input', '.edit-barang-select, .qty-input') // hindari double binding
        .on('select2:select input', '.edit-barang-select, .qty-input', function () {
            const row = $(this).closest('[data-repeater-item]');
            const harga = clean(row.find('.harga-jual').val());
            const qty = parseInt(row.find('.qty-input').val()) || 0;
            row.find('.subtotal-field').val(format(harga * qty));
            updateAllTotalsEdit();
        });

    $(document)
        .off('select2:select', '.edit-barang-select')
        .on('select2:select', '.edit-barang-select', function (e) {
            const data = e.params.data;
            const row = $(this).closest('[data-repeater-item]');
            row.find('.harga-jual').val(format(data.harga_jual));
            row.find('.qty-input').val(1);
            row.find('.subtotal-field').val(format(data.harga_jual));
            updateAllTotalsEdit();
        });

    $(document)
        .off('input', '.edit-potongan-input')
        .on('input', '.edit-potongan-input', function () {
            const angka = clean($(this).val());
            $(this).val(format(angka));
            updateAllTotalsEdit();
        });

    // 🔹 Hitung total & grand total
    function updateAllTotalsEdit() {
        let total = 0;
        $('.subtotal-field').each(function () {
            total += clean($(this).val());
        });
        $('.edit-total-harga').val(format(total));

        const potongan = clean($('.edit-potongan-input').val());
        const grand = Math.max(total - potongan, 0);
        $('.edit-grand-total').val(format(grand));
    }

    // 🔹 Jalankan langsung saat pertama kali modal terbuka
    updateAllTotalsEdit();
}


                // EDIT MODAL

                var id;
                $('body').on('click', '#getEditRowData', function(e) {

                    id = $(this).data('id');
                    $.ajax({
                        url: "penjualan-online/" + id + "/edit",
                        dataType: "json",
                        success: function(result) {
                            console.log(result);
                            $('#EditRowModalBody').html(result.html);
                            $('#Modal_Edit_Data').modal('show');
                            initEditForm();
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
                        url: "penjualan-online/" + id,
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

                         error: function(xhr) {
        blockUIEdit.release();
        const res = xhr.responseJSON || {};
        Swal.fire({
            title: res.judul || "Gagal",
            text: res.errorMessage || "Terjadi kesalahan di server.",
            icon: "error",
            confirmButtonText: "Oke",
        });
        $('#btn-edit-data .edit-data-label').show();
        $('#btn-edit-data .edit-data-progress').hide();
        $('#btn-edit-data').prop('disabled', false);
    }
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
                        url: "brand/" + id,
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
                                    url: "{{ route('brand.mass-delete') }}", // Pastikan route ini ada
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
    @endpush
@endsection

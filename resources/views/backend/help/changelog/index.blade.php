@extends('layouts.backend.index')
@section('title', 'Changelog List')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Changelog
                    App List</h1>
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
                    <li class="breadcrumb-item text-muted">Help</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Changelog</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-900">Changelog List</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center pt-4 pb-7 pt-lg-1 pb-lg-2">
                <!--begin::Button-->
                <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                    data-bs-target="#format-changelog">
                    <i class="ki-outline ki-information fs-2"></i>Format
                </button>
                @can('changelog-create')
                    <button type="button" class="btn btn-sm btn-primary" name="btn_tambah_data" id="btn_tambah_data">
                        <i class="ki-outline ki-plus fs-2"></i>Add</button>
                @endcan
                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" data-kt-table-filter="search" id="search"
                            class="form-control form-control-solid w-250px ps-13" placeholder="Search " />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Reload Data-->
                        <button type="button" class="btn btn-sm btn-primary me-3" id="refresh-table-btn">
                            <span class="indicator-label">
                                <i class="ki-outline ki-arrows-loop  me-2"></i> Refresh Table
                            </span>
                            <span class="indicator-progress">
                                Please Wait ... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Reload Data-->
                    </div>
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" data-kt-user-table-select="delete_selected"> <i
                                class="ki-outline ki-trash  me-2"></i>Delete
                            Selected</button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 chimox" id="chimox">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            @can('changelog-massdelete')
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#chimox .form-check-input" value="1" />
                                    </div>
                                </th>
                            @endcan
                            <th class="min-w-125px">KODE VERSI</th>
                            <th class="min-w-120px">DESKRIPSI</th>
                            @canany(['changelog-show', 'changelog-edit', 'changelog-delete'])
                                <th class="text-end min-w-100px">Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content-->
    <!--begin::Modal - Add Data-->
    <div class="modal fade" id="Modal_Tambah_Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-850px">
            <!--begin::Modal content-->
            <div class="modal-content" id="tambah-modal-content">
                <!--begin::Modal header-->
                <div class="modal-header bg-secondary" id="kt_modal_add_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Data</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" onclick="resetForm()">
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
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_header"
                            data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Nama Perubahan</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="nama"
                                    class="form-control border border-1 border-dark rounded mb-3 mb-lg-0"
                                    placeholder="Nama Perubahan" />
                                <span class="text-danger error-text nama_error_add"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Deskripsi Perubahan</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="deskripsi" id="deskripsi"
                                    class="form-control border border-1 border-dark rounded mb-3 mb-lg-0"
                                    placeholder="Deskripsi Perubahan" />
                                <span class="text-danger error-text deskripsi_error_add"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <label class="required fs-6 fw-semibold mb-2">Logs</label>
                            <span class="text-danger error-text logs_error_add"></span>
                            <!--begin::Repeater-->
                            <div class="border border-gray-500 rounded border-active active p-4 mb-2">
                                <label class="required fs-6 fw-semibold mb-2">Fitur Baru</label>
                                <div id="add-new-repeater">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="add-new-repeater">
                                            <div data-repeater-item>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="logs[new][nama]"
                                                            class="form-control mb-2 mb-md-0" placeholder="nama fitur" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Deskripsi</label>
                                                        <input type="textarea" name="logs[new][deskripsi]"
                                                            class="form-control mb-2 mb-md-0" rows="2"
                                                            placeholder="deskripsi fitur" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="ki-duotone ki-trash fs-5"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span><span class="path5"></span></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                                            <i class="ki-duotone ki-plus fs-3"></i>
                                            Add
                                        </a>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            <!--end::Repeater-->
                            <!--begin::Repeater-->
                            <div class="border border-gray-500 rounded border-active active p-4 mb-2">
                                <label class="required fs-6 fw-semibold mb-2">Pembaharuan</label>
                                <div id="add-update-repeater">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="add-update-repeater">
                                            <div data-repeater-item>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="logs[update][nama]"
                                                            class="form-control mb-2 mb-md-0"
                                                            placeholder="nama pembaharuan" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Deskripsi</label>
                                                        <input type="textarea" name="logs[update][deskripsi]"
                                                            class="form-control mb-2 mb-md-0"
                                                            placeholder="deskripsi pembaharuan" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="ki-duotone ki-trash fs-5"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span><span class="path5"></span></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                                            <i class="ki-duotone ki-plus fs-3"></i>
                                            Add
                                        </a>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            <!--end::Repeater-->
                            <!--begin::Repeater-->
                            <div class="border border-gray-500 rounded border-active active p-4 mb-2">
                                <label class="required fs-6 fw-semibold mb-2">Perbaikan</label>
                                <div id="add-fix-repeater">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="add-fix-repeater">
                                            <div data-repeater-item>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="logs[fix][nama]"
                                                            class="form-control mb-2 mb-md-0"
                                                            placeholder="nama perbaikan" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Deskripsi</label>
                                                        <input type="textarea" name="logs[fix][deskripsi]"
                                                            class="form-control mb-2 mb-md-0"
                                                            placeholder="deskripsi perbaikan" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="ki-duotone ki-trash fs-5"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span><span class="path5"></span></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                                            <i class="ki-duotone ki-plus fs-3"></i>
                                            Add
                                        </a>
                                    </div>
                                    <!--end::Form group-->
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
    <!--end::Modal - Add Data-->
    <!-- Edit Article Modal -->
    <div class="modal fade" id="Modal_Edit_Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-850px">
            <div class="modal-content" id="edit-modal-content">
                <div class="modal-header bg-secondary" id="kt_modal_edit_header">
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
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_scroll" data-kt-scroll-offset="300px">
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
    <!--begin modal hapus-->
    <div class="modal fade" id="Modal_Hapus_Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="hapus-modal-content">
                <div class="modal-header bg-secondary">
                    <h2 class="fw-bold">Delete Data</h2>
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
    <div class="modal fade" tabindex="-1" id="format-changelog">
        <div class="modal-dialog modal-dialog-centered mw-850px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Format Penulisan Changelog</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">
                    <div class="mb-13">
                        <!--begin::Intro-->
                        <div class="mb-15">
                            <!--begin::Text-->
                            <p class="fw-semibold fs-6 mb-2">
                                Berikut cara untuk membuat nomor changelog aplikasi secara profesional, ikuti
                                langkah-langkah berikut:
                            </p>
                            <!--end::Text-->
                        </div>
                        <!--end::Intro-->
                        <!--begin::Row-->
                        <div class="row mb-12">
                            <!--begin::Col-->
                            <div class="col-md-6 pe-md-10 mb-10 mb-md-0">
                                <!--begin::Title-->
                                <h2 class="fs-5 fw-bold mb-4">Format Penulisan</h2>
                                <!--end::Title-->
                                <div class="d-flex flex-column">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-2"></span>
                                            <span class="fw-bold fs-6">Pemilihan Format</span>
                                        </li>
                                        <li>Gunakan format semantik versi (SemVer) untuk memberikan makna pada nomor versi.
                                            Misalnya, MAJOR.MINOR.PATCH.</li>
                                    </ul>
                                </div>
                                <div class="d-flex flex-column">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-2"></span>
                                            <span class="fw-bold fs-6">Penentuan Arti Perubahan</span>
                                        </li>
                                        <li>Tentukan perbedaan antara pembaruan mayor, minor, dan patch. Contohnya,
                                            pembaruan mayor bisa mencakup fitur baru besar, pembaruan minor untuk penambahan
                                            fitur kecil, dan pembaruan patch untuk perbaikan bug.</li>
                                    </ul>
                                </div>
                                <div class="d-flex flex-column">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-2"></span>
                                            <span class="fw-bold fs-6">Contoh Format Penomoran</span>
                                        </li>
                                        <li>1.0.0: Versi awal.</br>
                                            1.1.0: Penambahan fitur.</br>
                                            1.1.1: Perbaikan bug.
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-flex flex-column">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-2"></span>
                                            <span class="fw-bold fs-6">Gunakan Catatan Perubahan (Changelog)</span>
                                        </li>
                                        <li>Sertakan catatan perubahan yang jelas dan ringkas untuk setiap versi. Tuliskan
                                            perubahan fitur, perbaikan bug, dan perubahan lainnya.</li>
                                    </ul>
                                </div>
                                <div class="d-flex flex-column">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-2"></span>
                                            <span class="fw-bold fs-6">Ketertiban Penulisan</span>
                                        </li>
                                        <li>Susun catatan perubahan dengan urutan yang logis, misalnya, fitur terlebih
                                            dahulu, diikuti oleh perbaikan bug.</li>
                                    </ul>
                                </div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 ps-md-10">
                                <!--begin::Title-->
                                <h2 class="fs-5 fw-bold mb-4">Format Penulisan</h2>
                                <!--end::Title-->
                                <div class="py-5">
                                    <div class="highlight">
                                        <button class="highlight-copy btn" data-bs-toggle="tooltip"
                                            data-bs-original-title="Copy code" data-kt-initialized="1">copy</button>
                                        <span class="text-white fs-6">
                                            ## [1.1.0] - 2024-01-19</br>
                                            ### Added</br>
                                            - Fitur baru A</br>
                                            - Fitur baru B</br>
                                            </br>
                                            ### Changed</br>
                                            - Perubahan minor pada tampilan antarmuka</br>
                                            </br>
                                            ### Fixed</br>
                                            - Perbaikan bug C</br>
                                            - Perbaikan bug D</br>
                                            </br>
                                            ## [1.0.1] - 2024-01-10</br>
                                            ### Fixed</br>
                                            - Perbaikan bug A</br>
                                            - Perbaikan bug B</br>
                                            </br>
                                            ## [1.0.0] - 2024-01-01</br>
                                            ### Added</br>
                                            - Peluncuran awal aplikasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ URL::to('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
        <script>
            $('#add-new-repeater').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            $('#add-update-repeater').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            $('#add-fix-repeater').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        </script>
        <script>
            function resetForm() {
                // Reset nilai-nilai formulir ke nilai awal
                $("#FormTambahModalID")[0].reset();
                // Bersihkan pesan kesalahan
                $(".error-text").text("");
            }
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

                var canShow = @json(auth()->user()->can('changelog-show'));
                var canEdit = @json(auth()->user()->can('changelog-edit'));
                var canDelete = @json(auth()->user()->can('changelog-delete'));
                var canMassDelete = @json(auth()->user()->can('changelog-massdelete'));


                // init datatable.
                var table = $('.chimox').DataTable({
                    processing: true,
                    serverSide: true,
                    order: false,
                    language: {
                        processing: "Please Wait ...",
                        loadingRecords: false,
                        zeroRecords: "Tidak ada data yang ditemukan",
                        emptyTable: "Tidak ada data yang tersedia di tabel ini",
                        search: "Cari:",
                    },
                    ajax: {
                        url: "{{ route('get-datachangelog') }}",
                        type: 'GET',


                    },
                    columns: [canMassDelete ? {
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
                            name: 'nama'
                        },
                        {
                            data: 'deskripsi',
                            name: 'deskripsi',
                            orderable: false
                        },
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






                // SHOW MODAL TAMBAH DATA
                $("#btn_tambah_data").click(function() {
                    $("#Modal_Tambah_Data").modal("show");
                });


                var target = document.querySelector("#tambah-modal-content");
                var blockUI = new KTBlockUI(target, {
                    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> <span class="text-white">Please Wait ...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50",
                });

                // SUBMIT MODAL TAMBAH DATA
                $("#FormTambahModalID").on("submit", function(event) {
                    event.preventDefault();
                    blockUI.block();
                    $('#btn-add-data .add-data-label').hide();
                    $('#btn-add-data .add-data-progress').show();
                    $('#btn-add-data').prop('disabled', true);
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                    $.ajax({
                        url: "{{ route('changelog.store') }}",
                        method: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $(document).find("span.error-text").text("");
                        },
                        success: function(result) {
                            if (result.errors) {
                                setTimeout(function() {
                                    $.each(result.errors, function(prefix, val) {
                                        $("span." + prefix + "_error_add").text(val[
                                            0]);
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
                                }, 1000);
                            } else if (result.error) {
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
                    });
                });

                // Tombol "Batal"
                $("#Modal_Tambah_Data").on("hidden.bs.modal", function() {
                    resetForm();
                });

                var targetedit = document.querySelector("#edit-modal-content");
                var blockUIEdit = new KTBlockUI(targetedit, {
                    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> <span class="text-white">Please Wait ...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50",
                });

                // EDIT MODAL

                var id;
                $("body").on("click", "#getEditRowData", function(e) {
                    id = $(this).data("id");
                    $.ajax({
                        url: "changelog/" + id + "/edit",
                        dataType: "json",
                        success: function(result) {
                            console.log(result);
                            $("#EditRowModalBody").html(result.html);
                            $("#Modal_Edit_Data").modal("show");
                        },
                    });
                });

                // UPDATE MODAL
                $("#FormEditModalID").on("submit", function(e) {
                    e.preventDefault();
                    blockUIEdit.block();
                    $('#btn-edit-data .edit-data-label').hide();
                    $('#btn-edit-data .edit-data-progress').show();
                    $('#btn-edit-data').prop('disabled', true);
                    var id = $("#hidden_id").val();
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                    $.ajax({
                        url: "changelog/" + id,
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
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
                    overlayClass: "bg-dark bg-opacity-50",
                });

                // Delete article Ajax request.
                var deleteID;
                $("body").on("click", "#getDeleteId", function() {
                    deleteID = $(this).data("id");
                });
                $("#SubmitDeleteRowForm").click(function(e) {
                    e.preventDefault();
                    blockUIHapus.block();
                    $('#SubmitDeleteRowForm .delete-data-label').hide();
                    $('#SubmitDeleteRowForm .delete-data-progress').show();
                    $('#SubmitDeleteRowForm').prop('disabled', true);
                    var id = deleteID;
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                    $.ajax({
                        url: "changelog/" + id,
                        method: "DELETE",
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
                                        },
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
                            text: 'You are about to delete ' + selectedIds.length + ' users.',
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
                                    url: "{{ route('changelog.mass-delete') }}", // Pastikan route ini ada
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
                                            'An error occurred while deleting users.',
                                            'error');
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire('Warning!', 'No users selected for deletion.', 'warning');
                    }
                });


            });


            // Make the DIV element draggable:
            document.querySelectorAll('#Modal_Tambah_Data, #Modal_Edit_Data, #Modal_Hapus_Data').forEach(function(element) {
                dragElement(element);

                function dragElement(elmnt) {
                    let pos1 = 0,
                        pos2 = 0,
                        pos3 = 0,
                        pos4 = 0;
                    const header = elmnt.querySelector('.modal-header');

                    if (header) {
                        // Only make the header draggable
                        header.onmousedown = dragMouseDown;
                    }

                    function dragMouseDown(e) {
                        e.preventDefault();
                        pos3 = e.clientX;
                        pos4 = e.clientY;
                        document.onmouseup = closeDragElement;
                        document.onmousemove = elementDrag;
                    }

                    function elementDrag(e) {
                        e.preventDefault();
                        pos1 = pos3 - e.clientX;
                        pos2 = pos4 - e.clientY;
                        pos3 = e.clientX;
                        pos4 = e.clientY;

                        // Move the modal
                        elmnt.style.position = "absolute";
                        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
                    }

                    function closeDragElement() {
                        // Stop moving when mouse button is released
                        document.onmouseup = null;
                        document.onmousemove = null;
                    }
                }
            });
        </script>
    @endpush
@endsection

@extends('layouts.backend.index')
@section('title', 'Account Settings')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8 mb-5">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">My Profile
                </h1>
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
                    <li class="breadcrumb-item text-muted">My Profile</li>
                    <!--end::Item-->

                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        {{-- @if (empty(Auth::user()->avatar))
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <div class="symbol-label  fw-semibold bg-primary display-1 text-inverse-primary">
                                    {{ ucwords(substr(Auth::user()->name, 0, 1)) }}</div>
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                        @else
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ URL::to('uploads/user/avatar/' . Auth::user()->avatar) }}" alt="image" />
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                        @endif --}}

                        @if (empty(Auth::user()->avatar))
                            <!-- Jika avatar kosong, tampilkan inisial nama pengguna -->
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <div class="symbol-label fw-semibold bg-primary display-1 text-inverse-primary">
                                    {{ ucwords(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                        @else
                            <!-- Jika avatar ada, tampilkan berdasarkan provider -->
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                @if (Auth::user()->provider == 'google')
                                    <!-- Jika provider Google, tampilkan avatar dari URL Google -->
                                    <img src="{{ Auth::user()->avatar }}" alt="image" />
                                @else
                                    <!-- Jika provider local (mendaftar melalui aplikasi Laravel), tampilkan avatar lokal -->
                                    <img src="{{ URL::to('uploads/user/avatar/' . Auth::user()->avatar) }}"
                                        alt="image" />
                                @endif
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                        @endif

                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#"
                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ ucwords(strtolower(Auth::user()->name)) }}</a>
                                    <a href="#">
                                        <i class="ki-outline ki-award fs-1 text-primary"></i>
                                    </a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">


                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                        <i class="ki-outline ki-sms fs-4 me-1 text-danger"></i>{{ Auth::user()->email }}</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <a href="#" class="btn btn-sm btn-primary me-3" id="EditAvatar"
                                    data-id="{{ Auth::user()->id }}">Change Avatar</a>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Title-->
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                            <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="4500"
                                                data-kt-countup-prefix="$">0</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Earnings</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
                                            <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="80">0
                                            </div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Projects</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                            <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60"
                                                data-kt-countup-prefix="%">0</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Success Rate</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Progress-->
                            <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                    <span class="fw-semibold fs-6 text-gray-500">Profile Compleation</span>
                                    <span class="fw-bold fs-6">50%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                    <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <!--end::Progress-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->routeIs('profile.index') ? 'active ' : '' }}"
                            href="{{ route('profile.index') }}">My Profile</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    @if (Auth::user()->provider !== 'google')
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->routeIs('security.index') ? 'active' : '' }}"
                                href="{{ route('security.index') }}">
                                Security
                            </a>
                        </li>
                    @endif

                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->routeIs('users-log.index') ? 'active ' : '' }}"
                            href="{{ route('users-log.index') }}">Logs</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::details View-->
        @yield('tes')
        <!--end::details View-->
    </div>
    <!--end::Content-->
    <!-- Edit Modal -->
    <div class="modal fade" id="Modal_Edit_Avatar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-550px">
            <div class="modal-content" id="changeavatar-modal-content">
                <div class="modal-header bg-secondary" id="kt_modal_edit_user_header">
                    <h2 class="fw-bold">Change Avatar</h2>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1 text-dark"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body px-5 my-7">
                    <form id="FormEditModalAvatarID" class="form" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7" id="ModalAvatar"></div>
                            <input type="hidden" name="action" id="action" />
                        </div>

                        <div class="text-center pt-10">
                            <button type="button" class="btn btn-sm btn-secondary me-3"
                                data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-sm btn-primary" value="submit" id="btn-change-avatar">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                var target_changeavatar = document.querySelector("#changeavatar-modal-content");
                var blockUIChangeavatar = new KTBlockUI(target_changeavatar, {
                    message: '<div class="blockui-message"><span class="spinner-border text-danger"></span> <span class="text-white">Mohon Sabar, Data Sedang Proses...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50"
                });



                var id;
                $('body').on('click', '#EditAvatar', function(e) {
                    //e.preventDefault();
                    $('.alert-danger').html('');
                    $('.alert-danger').hide();
                    id = $(this).data('id');

                    $.ajax({
                        url: "account/" + id + "/avatar",
                        dataType: "json",
                        success: function(result) {
                            console.log(result);
                            $('#ModalAvatar').html(result.html);
                            $('#Modal_Edit_Avatar').modal('show');
                        }
                    });
                });

                $('#FormEditModalAvatarID').on('submit', function(e) {
                    e.preventDefault();
                    var submitButton = document.querySelector("#btn-change-avatar");
                    submitButton.setAttribute("data-kt-indicator", "on");
                    submitButton.disabled = true;
                    blockUIChangeavatar.block();

                    var id = $('#hidden_id').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "updateavatar/" + id,
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function(result) {
                            handleResponse(result, submitButton);
                        },
                        error: function(xhr) {
                            submitButton.removeAttribute("data-kt-indicator");
                            submitButton.disabled = false; // Enable button
                            blockUI.release();
                            alert("Error: " + xhr.status + " " + xhr.statusText);
                        }

                    });
                });

                function handleResponse(result, submitButton) {
                    if (result.errors) {
                        blockUIChangeavatar.release();
                        $.each(result.errors, function(fieldName, errorMessage) {
                            var inputField = $('#' + fieldName);
                            if (inputField.length > 0) {
                                inputField.addClass('is-invalid');
                                var feedbacEditkElement = $('.' + fieldName +
                                    '-edit-invalid-feedback-changeavatar');
                                feedbacEditkElement.html(errorMessage);
                                feedbacEditkElement.addClass(
                                    'd-none'
                                );
                            }
                        });

                        var editShowValidationElement = $(
                            '.edit-show-validation-changeavatar');
                        editShowValidationElement.removeClass('d-none');

                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan validasi, periksa kembali input Anda.',
                            icon: 'error',
                            timer: 1500,
                            confirmButtonText: 'Ok'
                        });
                    } else if (result.error) {

                        setTimeout(function() {
                            $('#Modal_Edit_Avatar').modal('hide');
                            blockUIChangeavatar.release();

                        }, 1000);


                        Swal.fire({
                            title: result.judul,
                            text: result.error,
                            icon: 'error',
                            timer: 1500,
                            confirmButtonText: 'Oke'
                        });

                    } else {

                        blockUIChangeavatar.release();

                        Swal.fire({
                            text: result.success,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            timer: 1500,
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        $('#Modal_Edit_Avatar').modal('hide');
                        setInterval(function() {
                            location.reload();
                        }, 1000);
                    }
                    submitButton.removeAttribute("data-kt-indicator"); // Hide "Please wait..."
                    submitButton.disabled = false; // Enable button

                }

            });

            // Make the DIV element draggable:
            document.querySelectorAll('#Modal_Edit_Avatar').forEach(function(element) {
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

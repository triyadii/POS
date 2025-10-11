@extends('backend.profile.index')
@section('title', 'Security')
@section('tes')

    <!--begin::details View-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <!--begin::Card header-->
        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Sign In Method</h3>
            </div>
            <!--end::Card title-->
            <!--begin::Action-->
            <a href="#" class="btn btn-sm btn-primary align-self-center" id="getEditRowData"
                data-id="{{ Auth::user()->id }}">Change Password</a>
            <!--end::Action-->
        </div>
        <!--begin::Card header-->
        <!--begin::Card body-->
        <div class="card-body border-top p-9">

            <!--begin::Password-->
            <div>
                <!--begin::Label-->

                <div class="fw-bold text-gray-600">


                    <div class="row mb-1">
                        <div class="col-lg-4">
                            <!--begin::Label-->
                            <div id="kt_signin_email">
                                <div class="fs-6 fw-bolder text-dark mb-1">Email Address</div>
                                <div class="fw-bold text-gray-600">{{ $akun->email }}</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <div class="col-lg-4">
                            <!--begin::Label-->
                            <div id="kt_signin_email">
                                <div class="fs-6 fw-bolder text-dark mb-1">Last Login</div>
                                <div class="fw-bold text-gray-600">{{ $akun->last_login_at }}</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <div class="col-lg-4">
                            <!--begin::Label-->
                            <div id="kt_signin_email">
                                <div class="fs-6 fw-bolder text-dark mb-1">Last IP Address</div>
                                <div class="fw-bold text-gray-600">{{ $akun->last_login_ip }}</div>
                            </div>
                            <!--end::Label-->
                        </div>
                    </div>



                </div>



            </div>
            <!--end::Password-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::details View-->

    <!-- Edit Article Modal -->
    <div class="modal fade" id="Modal_Edit_Data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content" id="edit-modal-content">
                <div class="modal-header bg-secondary" id="kt_modal_edit_user_header">
                    <h2 class="fw-bold">Edit User</h2>
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



                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7" id="EditRowModalBody"></div>
                        </div>

                        <div class="text-center pt-10">
                            <button type="button" class="btn btn-sm btn-secondary me-3"
                                data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-sm btn-primary" value="submit" id="btn-change-password">
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
                var targetedit = document.querySelector("#edit-modal-content");
                var blockUIEdit = new KTBlockUI(targetedit, {
                    message: '<div class="blockui-message"><span class="spinner-border text-danger"></span> <span class="text-white">Mohon Sabar, Data Sedang Proses...</span></div>',
                    overlayClass: "bg-dark bg-opacity-50",
                });

                var submitButton = document.querySelector("#btn-change-password");

                // Fungsi untuk reset submit button
                function resetSubmitButton() {
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;
                }

                // Fungsi menampilkan modal edit
                function showEditModal(result) {
                    $('#EditRowModalBody').html(result.html);
                    $('#Modal_Edit_Data').modal('show');
                }

                // Fungsi menampilkan pesan error menggunakan Swal
                function showErrorMessage(title, text) {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: "error",
                        timer: 1500,
                        confirmButtonText: "Ok",
                    });
                }

                // Tutup modal saat tombol close diklik
                $('.modelClose').on('click', function() {
                    $('#Modal_Edit_Data').hide();
                });

                // Event untuk memuat data saat tombol edit diklik
                $('body').on('click', '#getEditRowData', function(e) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: "security/" + id + "/edit",
                        dataType: "json",
                        success: function(result) {
                            showEditModal(result);
                        }
                    });
                });

                // Event saat form submit
                $('#FormEditModalID').on('submit', function(e) {
                    e.preventDefault();
                    submitButton.setAttribute("data-kt-indicator", "on"); // Tampilkan indikator
                    submitButton.disabled = true; // Nonaktifkan tombol submit

                    var id = $('#hidden_id').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "security/" + id,
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $(document).find("span.error-text").text(""); // Bersihkan error text
                        },
                        success: function(result) {
                            if (result.errors) {
                                setTimeout(function() {
                                    blockUIEdit.release();
                                    $.each(result.errors, function(prefix, val) {
                                        $("span." + prefix + "_error_edit").text(
                                            val[0]);
                                    });
                                    showErrorMessage("Error",
                                        "Terjadi kesalahan validasi, periksa kembali input Anda."
                                    );
                                    resetSubmitButton();
                                }, 1000);
                            } else if (result.error) {
                                setTimeout(function() {
                                    $("#Modal_Edit_Data").modal("hide");
                                    blockUIEdit.release();
                                    showErrorMessage(result.judul, result.error);
                                    resetSubmitButton();
                                }, 1000);
                            } else {
                                setTimeout(function() {
                                    $("#Modal_Edit_Data").modal("hide");
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

                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                    resetSubmitButton();
                                }, 1000);
                            }
                        }
                    });
                });
            });

            // Make the DIV element draggable:
            document.querySelectorAll('#Modal_Edit_Data').forEach(function(element) {
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

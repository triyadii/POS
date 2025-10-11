@extends('layouts.auth.index')
@section('title', 'Register')
@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <!--begin::Form-->
        <form id="registrationForm" class="form w-100">
            @csrf
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>
                <!--end::Title-->
                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                <!--end::Subtitle=-->
            </div>
            <!--begin::Heading-->
            <!--begin::Login options-->
            <div class="row g-3 mb-9">
                <!--begin::Col-->
                <div class="col-md-6">
                    <!--begin::Google link=-->
                    <a href="#"
                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                        <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/google-icon.svg') }}"
                            class="h-15px me-3" />Sign in with Google</a>
                    <!--end::Google link=-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6">
                    <!--begin::Google link=-->
                    <a href="#"
                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                        <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/apple-black.svg') }}"
                            class="theme-light-show h-15px me-3" />
                        <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/apple-black-dark.svg') }}"
                            class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
                    <!--end::Google link=-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Login options-->
            <!--begin::Separator-->
            <div class="separator separator-content my-14">
                <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
            </div>
            <!--end::Separator-->


            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Name" name="name" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--begin::Input group-->
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email" name="email" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--begin::Input group-->
            <div class="fv-row mb-8" data-kt-password-meter="true">
                <!--begin::Wrapper-->
                <div class="mb-1">
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password"
                            autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                            data-kt-password-meter-control="visibility">
                            <i class="ki-outline ki-eye-slash fs-2"></i>
                            <i class="ki-outline ki-eye fs-2 d-none"></i>
                        </span>
                    </div>
                    <!--end::Input wrapper-->
                    <!--begin::Meter-->
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                    <!--end::Meter-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Hint-->
                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                <!--end::Hint-->
            </div>
            <!--end::Input group=-->
            <!--end::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Repeat Password-->
                <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off"
                    class="form-control bg-transparent" />

                <!--end::Repeat Password-->
            </div>
            <!--end::Input group=-->
            <!--begin::Accept-->
            <div class="fv-row mb-8">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
                        <a href="#" class="ms-1 link-primary">Terms</a>
                    </span>
                </label>
            </div>

            <!--end::Accept-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Sign up</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress" style="display: none;">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                <a href="{{ route('login') }}" class="link-primary fw-semibold">Sign in</a>
            </div>
            <!--end::Sign up-->
        </form>
        <!--end::Form-->
    </div>
    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#registrationForm').on('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission
                    var formData = $(this).serialize(); // Serialize the form data

                    // Check if the Terms and Conditions checkbox is checked
                    if (!$('input[name="toc"]').is(':checked')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You must accept the Terms and Conditions to register.',
                            confirmButtonText: 'Got it!',
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        return; // Stop the form submission
                    }

                    $('#kt_sign_up_submit .indicator-label').hide();
                    $('#kt_sign_up_submit .indicator-progress').show();
                    $('#kt_sign_up_submit').prop('disabled', true);

                    $.ajax({
                        url: '{{ route('register') }}', // Your registration route
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                // Handle successful response
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    },
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            '{{ url('/login') }}'; // Redirect to login
                                    }
                                });
                            } else {
                                Swal.fire({
                                    text: "You have successfully registered!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Redirecting...",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    },
                                    timer: 3000, // Set timer to 3 seconds
                                    timerProgressBar: true, // Show a progress bar during the countdown
                                    willClose: () => {
                                        window.location.href =
                                            '{{ url('/login') }}'; // Automatically redirect to login
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            // Handle validation errors
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: errorMessage,
                                timer: 3000,
                                confirmButtonText: "Ok, got it!"
                            });
                        },
                        complete: function() {
                            $('#kt_sign_up_submit .indicator-label').show();
                            $('#kt_sign_up_submit .indicator-progress').hide();
                            $('#kt_sign_up_submit').prop('disabled', false);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

@extends('layouts.auth.index')
@section('title', 'Login')
@section('content')

<div class="d-flex flex-center flex-column flex-column-fluid mb-2">

    @if (!empty($appSetting->logo_black))
    <img alt="Logo" class="theme-light-show h-40px h-lg-45px"
        src="{{ asset('./storage/' . $appSetting->logo_black) }}" />
    @else
    <img alt="Logo" class="theme-light-show h-40px h-lg-45px" src="{{ asset('assets/media/logos/keenthemes.svg') }}" />
    @endif

</div>
<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
    <!--begin::Form-->

    <!--begin::Heading-->
    <div class="text-center mb-4">
        <!--begin::Title-->
        <h1 class="text-gray-900 fw-bolder mb-3">{{ __('Sign In') }}</h1>
        <!--end::Title-->
        {{-- <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">Your Social Account</div>
            <!--end::Subtitle=--> --}}
    </div>
    <!--begin::Heading-->
    {{-- <!--begin::Login options-->
        <div class="row g-3 mb-2">
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Google link=-->
                <a href="{{ route('google') }}"
    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap
    w-100">
    <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/google-icon.svg') }}" class="h-15px me-3" />Sign in with
    Google</a>
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
<div class="separator separator-content my-8 form w-100">
    <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
</div>
<!--end::Separator--> --}}

<form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
    @csrf
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!--begin::Input group=-->
    <div class="fv-row mb-4">
        <!--begin::Email-->
        <input type="text" placeholder="Email" id="email" name="email" autocomplete="off"
            class="form-control bg-transparent" />
        <!--end::Email-->
    </div>
    <!--end::Input group=-->
    <div class="fv-row mb-3">
        <!--begin::Password-->
        <input type="password" placeholder="Password" id="password" type="password" name="password" autocomplete="off"
            class="form-control bg-transparent mb-2" />
        <div class="form-check form-switch form-check-custom form-check-solid me-10">
            <input class="form-check-input h-20px w-30px" type="checkbox" value="" id="flexSwitch20x30" />
            <label class="form-check-label" for="flexSwitch20x30">
                Show Password
            </label>
        </div>
        <!--end::Password-->
    </div>
    <!--end::Input group=-->
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
        <div></div>
        <!--begin::Link-->
        <a href="{{ route('password.request') }}" class="link-primary">Forgot Password?</a>

        <!--end::Link-->
    </div>
    <!--end::Wrapper-->
    <!--begin::Submit button-->
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
            <!--begin::Indicator label-->
            <span class="indicator-label">Sign In</span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::Submit button-->
    <!--begin::Sign up-->
    <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
        <a href="{{ route('register') }}" class="link-primary">Sign
            up</a>
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
    const togglePassword = document.querySelector("#flexSwitch20x30");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function() {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
    });
</script>
<script>
    var homeUrl = "{{ route('dashboard') }}";

    "use strict";
    var KTSigninGeneral = function() {
        var t, e, r;
        return {
            init: function() {
                t = document.querySelector("#kt_sign_in_form"),
                    e = document.querySelector("#kt_sign_in_submit"),
                    r = FormValidation.formValidation(t, {
                        fields: {
                            email: {
                                validators: {
                                    regexp: {
                                        regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                        message: "The value is not a valid email address"
                                    },
                                    notEmpty: {
                                        message: "Email address is required"
                                    }
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: "The password is required"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    }),

                    e.addEventListener("click", function(i) {
                        i.preventDefault();
                        r.validate().then(function(validationResult) {
                            if (validationResult === "Valid") {
                                e.setAttribute("data-kt-indicator", "on");
                                e.disabled = true;

                                // Create a new FormData object
                                var formData = new FormData(t);

                                // Create XMLHttpRequest
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", e.closest("form").getAttribute("action"), true);

                                xhr.onload = function() {
                                    if (xhr.status >= 200 && xhr.status < 300) {
                                        try {
                                            const response = JSON.parse(xhr.responseText);
                                            if (response.success) {
                                                // Handle successful response
                                                t.reset();
                                                Swal.fire({
                                                    text: "You have successfully logged in!",
                                                    icon: "success",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "Redirecting...",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    },
                                                    timer: 3000, // Set timer to 3 seconds
                                                    timerProgressBar: true, // Show a progress bar during the countdown
                                                    willClose: () => {
                                                        location.href =
                                                            homeUrl; // Automatically redirect to dashboard after timer ends
                                                    }
                                                });

                                            } else {
                                                // Handle error response
                                                Swal.fire({
                                                    text: response.message ||
                                                        "Sorry, the email or password is incorrect, please try again.",
                                                    icon: "error",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "Ok, got it!",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    }
                                                });
                                            }
                                        } catch (e) {
                                            console.error("Error parsing JSON:", e);
                                            console.error("Response text:", xhr
                                                .responseText); // Debugging line
                                            Swal.fire({
                                                text: "An error occurred while processing your request.",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            });
                                        }
                                    } else {
                                        // Handle server error response
                                        Swal.fire({
                                            text: "Sorry, looks like there are some errors detected, please try again.",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                };



                                xhr.onerror = function() {
                                    // Handle network error
                                    Swal.fire({
                                        text: "Sorry, looks like there are some errors detected, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                };

                                // Send the request with form data
                                xhr.send(formData);

                                setTimeout(function() {
                                    e.removeAttribute("data-kt-indicator");
                                    e.disabled = false;
                                }, 2000);
                            } else {
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    });
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTSigninGeneral.init();
    });
</script>
@endpush

@endsection
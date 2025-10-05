@extends('layouts.custom.auth')
@section('auth-content')
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                <img src="{{ asset('assets/images/auth-logo.png') }}" width="300px" class="mb-10">

                <form class="form w-100" novalidate="novalidate" action="{{ route('register') }}" method="post" id="kt_sign_up_form">
                    @csrf
                    <!-- Step 1 -->
                    <div id="step-1" class="step active">
                        <div class="text-center mb-11">
                            <h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>
                            <div class="text-gray-500 fw-semibold fs-6">Your Personal Information</div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Account Type -->
                        <div class="fv-row mb-8">
                            <select name="account_type" id="account_type" class="form-control bg-transparent">
                                <option value="">Select Account Type</option>
                                <option value="client" {{ old('account_type') == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="freelancer" {{ old('account_type') == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                            </select>
                            <p id="accountTypeError" style="color:red"></p>
                        </div>

                        <div class="fv-row mb-8">
                            <input type="text" placeholder="First Name" name="fname" id="fname" autocomplete="off" class="form-control bg-transparent" required />
                            <p id="fnameError" style="color:red"></p>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Last Name" name="lname" id="lname" autocomplete="off" class="form-control bg-transparent" required />
                            <p id="lnameError" style="color:red"></p>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Email" name="email" id="email" value="{{ old('email') }}" autocomplete="off" class="form-control bg-transparent" required/>
                            <p id="emailError" style="color:red"></p>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" style="color:red;list-style: none;padding-left: 0px;" />
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Phone Number" name="phone" id="phone" autocomplete="off" class="form-control bg-transparent" required/>
                            <p id="phoneError" style="color:red"></p>
                        </div>
                        <div class="fv-row mb-8" data-kt-password-meter="true">
                            <div class="mb-1">
                                <div class="position-relative mb-3">
                                    <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" id="password" autocomplete="off" />
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                        <i class="ki-outline ki-eye-slash fs-2"></i>
                                        <i class="ki-outline ki-eye fs-2 d-none"></i>
                                    </span>
                                    <p id="passwordError" style="color:red"></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                        </div>
                        <div class="fv-row mb-8">
                            <input placeholder="Repeat Password" name="password_confirmation" type="password" id="password_confirmation" autocomplete="off" class="form-control bg-transparent" />
                            <p id="passwordConfirmError" style="color:red"></p>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" id="next-step">Next</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div id="step-2" class="step d-none">
                        <div class="text-center mb-11">
                            <h1 class="text-gray-900 fw-bolder mb-3">Company Information</h1>
                            <div class="text-gray-500 fw-semibold fs-6">Tell us about your company</div>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Company Name" name="company" autocomplete="off" class="form-control bg-transparent" />
                            <span class="text-danger error-message" data-error-for="company"></span>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Country" name="country" autocomplete="off" class="form-control bg-transparent" />
                            <span class="text-danger error-message" data-error-for="country"></span>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="State" name="state" autocomplete="off" class="form-control bg-transparent" />
                            <span class="text-danger error-message" data-error-for="state"></span>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="City" name="city" autocomplete="off" class="form-control bg-transparent" />
                            <span class="text-danger error-message" data-error-for="city"></span>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Zip Code" name="zip" autocomplete="off" class="form-control bg-transparent" />
                            <span class="text-danger error-message" data-error-for="zip"></span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" id="previous-step">Previous</button>
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('auth-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function () {
        const step1 = $("#step-1");
        const step2 = $("#step-2");
        const nextStep = $("#next-step");
        const previousStep = $("#previous-step");
        const form = $("#kt_sign_up_form");
        const accountType = $("#account_type"); // select added in Step 1

        // Update CTA text based on selected account type
        function updateCta() {
            if (accountType.val() === "freelancer") {
                nextStep.text("Sign Up");
            } else {
                nextStep.text("Next");
            }
        }
        accountType.on("change", updateCta);
        updateCta(); // on load

        nextStep.on("click", function () {
            let isValid = true;

            // Clear previous Step 1 errors
            $("#accountTypeError,#fnameError,#lnameError,#emailError,#phoneError,#passwordError,#passwordConfirmError").text('');

            // Validate account type
            if (!accountType.val()) {
                $("#accountTypeError").text("Please select an account type.");
                isValid = false;
            }

            // Validate First Name
            const fname = $("#fname").val().trim();
            if (!fname) {
                $("#fnameError").text("First name is required.");
                isValid = false;
            }

            // Validate Last Name
            const lname = $("#lname").val().trim();
            if (!lname) {
                $("#lnameError").text("Last name is required.");
                isValid = false;
            }

            // Validate Email
            const email = $("#email").val().trim();
            if (!email) {
                $("#emailError").text("Email is required.");
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                $("#emailError").text("Please enter a valid email address.");
                isValid = false;
            }

            // Validate Phone
            const phone = $("#phone").val().trim();
            if (!phone) {
                $("#phoneError").text("Phone number is required.");
                isValid = false;
            }

            // Validate Password
            const password = $("#password").val();
            if (!password) {
                $("#passwordError").text("Password is required.");
                isValid = false;
            } else if (password.length < 6) {
                $("#passwordError").text("Password must be at least 6 characters long.");
                isValid = false;
            }

            // Validate Password Confirmation
            const passwordConfirmation = $("#password_confirmation").val();
            if (!passwordConfirmation) {
                $("#passwordConfirmError").text("Confirming your password is required.");
                isValid = false;
            } else if (password !== passwordConfirmation) {
                $("#passwordConfirmError").text("Passwords do not match.");
                isValid = false;
            }

            if (!isValid) return;

            // Role-based flow
            if (accountType.val() === "client") {
                // Show company step for clients
                step1.addClass("d-none");
                step2.removeClass("d-none");
                nextStep.blur();
            } else {
                // Freelancers: submit immediately
                form.trigger("submit");
            }
        });

        // 🔙 Handle Previous button (you asked for this)
        previousStep.on("click", function () {
            step2.addClass("d-none");
            step1.removeClass("d-none");
            updateCta(); // restore CTA text appropriate for current role
        });

        // Validate Step 2 only for clients when submitting
        form.on("submit", function (e) {
            if (accountType.val() !== "client") {
                // Freelancer: no company validation
                return;
            }

            // Client: validate company fields
            let isValid = true;
            $(".error-message").text("");

            const fields = [
                { name: "company", message: "Company name is required." },
                { name: "country", message: "Country is required." },
                { name: "state", message: "State is required." },
                { name: "city", message: "City is required." },
                { name: "zip", message: "Zip Code is required." }
            ];

            fields.forEach(field => {
                const value = $(`input[name='${field.name}']`).val()?.trim();
                if (!value) {
                    $(`span[data-error-for='${field.name}']`).text(field.message);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection

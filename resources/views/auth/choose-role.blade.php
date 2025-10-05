@extends('layouts.custom.auth')
@section('auth-content')
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                <img src="{{ asset('assets/images/auth-logo.png') }}" width="300px" class="mb-10">

                <form class="form w-100" novalidate="novalidate" action="{{ route('set.role') }}" method="post" id="kt_sign_up_form">
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

                        <!-- Account Type Radios -->
                        <div class="fv-row mb-8">
                            <label class="fw-bold mb-2 d-block">Select Account Type</label>
                            <div class="d-flex gap-4">
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="account_type" value="client" 
                                           {{ old('account_type') == 'client' ? 'checked' : '' }}>
                                    <span class="form-check-label">Client</span>
                                </label>
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="account_type" value="freelancer" 
                                           {{ old('account_type') == 'freelancer' ? 'checked' : '' }}>
                                    <span class="form-check-label">Freelancer</span>
                                </label>
                            </div>
                            <p id="accountTypeError" style="color:red"></p>
                        </div>

                        <div class="fv-row mb-8">
                            <input type="text" placeholder="First Name" name="fname" id="fname" value="{{ old('fname', $googleUser['fname']) }}"  autocomplete="off" class="form-control bg-transparent" required />
                            <p id="fnameError" style="color:red"></p>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Last Name" name="lname" id="lname" value="{{ old('lname', $googleUser['lname']) }}" autocomplete="off" class="form-control bg-transparent" required />
                            <p id="lnameError" style="color:red"></p>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Email" id="email" value="{{ old('email', $googleUser['email']) }}" autocomplete="off" class="form-control bg-transparent" readonly />
                            <p id="emailError" style="color:red"></p>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" style="color:red;list-style: none;padding-left: 0px;" />
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Phone Number" name="phone" id="phone" autocomplete="off" class="form-control bg-transparent" required/>
                            <p id="phoneError" style="color:red"></p>
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

        function getSelectedType() {
            return $("input[name='account_type']:checked").val();
        }

        // Update button text
        function updateCta() {
            if (getSelectedType() === "freelancer") {
                nextStep.text("Sign Up");
            } else {
                nextStep.text("Next");
            }
        }
        $("input[name='account_type']").on("change", updateCta);
        updateCta();

        nextStep.on("click", function () {
            let isValid = true;
            $("#accountTypeError,#fnameError,#lnameError,#emailError,#phoneError").text('');

            if (!getSelectedType()) {
                $("#accountTypeError").text("Please select an account type.");
                isValid = false;
            }

            const fname = $("#fname").val().trim();
            if (!fname) { $("#fnameError").text("First name is required."); isValid = false; }

            const lname = $("#lname").val().trim();
            if (!lname) { $("#lnameError").text("Last name is required."); isValid = false; }

            const email = $("#email").val().trim();
            if (!email) {
                $("#emailError").text("Email is required.");
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                $("#emailError").text("Please enter a valid email address.");
                isValid = false;
            }

            const phone = $("#phone").val().trim();
            if (!phone) { $("#phoneError").text("Phone number is required."); isValid = false; }

           
            if (!isValid) return;

            if (getSelectedType() === "client") {
                step1.addClass("d-none");
                step2.removeClass("d-none");
            } else {
                form.trigger("submit");
            }
        });

        previousStep.on("click", function () {
            step2.addClass("d-none");
            step1.removeClass("d-none");
            updateCta();
        });

        form.on("submit", function (e) {
            if (getSelectedType() !== "client") return;

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

            if (!isValid) e.preventDefault();
        });
    });
</script>
@endsection

@extends('covid.index')
@section('title', 'Contact Us | '.config('app.name'))



@section('content')

<!-- Start header Section -->
<div class="header bg-light d-flex flex-column align-items-center justify-content-center min-vh-60">
    <div class="container">
        <!-- Full-width Title -->
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-primary mb-3">
                    COVID Vaccine Registration
                </h1>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Buttons -->
            <div class="col-md-4 d-flex flex-column ">
                <div class="intro-excerpt text-md-start text-center  mb-md-0">
                    <p class="lead mb-4 text-dark">
                        Welcome to the COVID Vaccine Registration portal. Please provide the necessary information to schedule your vaccination appointment. We prioritize your health and safety.
                    </p>
                    <div class="d-flex justify-content-center justify-content-md-start">
                   
                        <a href="{{ route('search.page') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                            Find with NID
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Registration Form -->
            <div class="col-md-8">
                <div class="container-co-section">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-8">
                            <form action="{{ route('vaccine-registration.store') }}" method="POST" id="vaccine-registration-form" onsubmit="return validateRegistrationForm()">
                                @csrf <!-- Include CSRF token for security -->
                                
                                <div class="form-group mb-4">
                                    <label class="text-dark fw-bold" for="vaccine_center_id">Vaccine Center</label>
                                    <select class="form-control custom-select rounded-pill bg-light border-1 border-primary text-dark" id="vaccine_center_id" name="vaccine_center_id">
                                        <option value="">Select Vaccine Center</option>
                                        @foreach($vaccineCenters as $center)
                                            <option value="{{ $center->id }}">{{ $center->center_name }}, {{ $center->location }}</option>
                                        @endforeach
                                    </select>
                                    @error('vaccine_center_id')
                                    <span class="text-danger mt-2 d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                    <small class="text-danger" id="vaccine_center_validation"></small>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-dark fw-bold" for="full_name">Full Name</label>
                                            <input type="text" class="form-control rounded-pill bg-light border-1 border-primary text-dark" id="full_name" name="full_name" placeholder="Enter your full name">
                                            @error('full_name')
                                            <span class="text-danger mt-2 d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                            @enderror
                                            <small class="text-danger" id="full_name_validation"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-dark fw-bold" for="user_nid">NID</label>
                                            <input type="number" class="form-control rounded-pill bg-light border-1 border-primary text-dark" id="user_nid" name="user_nid" placeholder="Enter your NID">
                                            @error('user_nid')
                                            <span class="text-danger mt-2 d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                            @enderror
                                            <small class="text-danger" id="nid_validation"></small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="text-dark fw-bold" for="email">Email Address</label>
                                    <input type="email" class="form-control rounded-pill bg-light border-1 border-primary text-dark" id="email" name="email" placeholder="Enter your email">
                                    @error('email')
                                    <span class="text-danger mt-2 d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                    <small class="text-danger" id="email_validation"></small>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="text-dark fw-bold" for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control rounded-pill bg-light border-1 border-primary text-dark" id="phone_number" name="phone_number" placeholder="Enter your phone number">
                                    @error('phone_number')
                                    <span class="text-danger mt-2 d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                    <small class="text-danger" id="phone_validation"></small>
                                </div>
                                
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary btn-lg rounded-pill px-5" onclick="validateRegistrationForm()">Register for Vaccine</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End header Section -->

@endsection




@section('scripts')
    <script>


function validateRegistrationForm() {
    let validationStatus = validateAllInputs(); // Call the validation function

    if (validationStatus) {
        // Submit the form if all validations pass
        document.getElementById("vaccine-registration-form").submit();
    } else {
        return false; // Prevent form submission if validations fail
    }
}


function validateAllInputs() {
    let isValid = true;

    // Select elements
    let vaccineCenter = document.getElementById("vaccine_center_id");
    let fullName = document.getElementById("full_name");
    let userNid = document.getElementById("user_nid");
    let email = document.getElementById("email");
    let phoneNumber = document.getElementById("phone_number");

    // Clear previous validation messages
    document.getElementById("vaccine_center_validation").textContent = '';
    document.getElementById("full_name_validation").textContent = '';
    document.getElementById("nid_validation").textContent = '';
    document.getElementById("email_validation").textContent = '';
    document.getElementById("phone_validation").textContent = '';

    // Validate vaccine center
    if (!vaccineCenter.value) {
        document.getElementById("vaccine_center_validation").textContent = "Please select a vaccine center";
        isValid = false;
    }

    // Validate full name
    if (!fullName.value) {
        document.getElementById("full_name_validation").textContent = "Full name is required";
        isValid = false;
    } else if (fullName.value.length < 3) {
        document.getElementById("full_name_validation").textContent = 'This should be at least 3 characters long!';
        isValid = false;
    }

    // Validate NID
    if (!userNid.value) {
        document.getElementById("nid_validation").textContent = "NID is required";
        isValid = false;
    } else if (userNid.value.length < 10) {
        document.getElementById("nid_validation").textContent = "NID must be at least 10 characters long!";
        isValid = false;
    } else if (userNid.value.length > 20) {
        document.getElementById("nid_validation").textContent = "NID must be less than 20 characters long!";
        isValid = false;
    } else if (!/^\d+$/.test(userNid.value)) { // Check if NID contains only numbers
        document.getElementById("nid_validation").textContent = "NID must contain numbers only!";
        isValid = false;
    }

    // Validate email
    if (!email.value) {
        document.getElementById("email_validation").textContent = "Email address is required";
        isValid = false;
    } else if (email.value.length < 8) {
        document.getElementById("email_validation").textContent = "Email address must be at least 8 characters long!";
        isValid = false;
    } else if (!validateEmail(email.value)) {
        document.getElementById("email_validation").textContent = "Please enter a valid email address!";
        isValid = false;
    }

    // Validate phone number
    if (!phoneNumber.value) {
        document.getElementById("phone_validation").textContent = "Phone number is required";
        isValid = false;
    } else if (!/^(?:\+88\s?\(?01[3-9]\d{8}\)?|01[3-9]\d{8})$/.test(phoneNumber.value)) {
        document.getElementById("phone_validation").textContent = "Phone number must be in the format +88 (01XXXXXXXXX) or 01XXXXXXXXX!";
        isValid = false;
    }
    return isValid;
}


function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

    </script>
@endsection

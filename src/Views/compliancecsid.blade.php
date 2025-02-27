@extends('stackcue-zat2::layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-12">
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Compliance CSID Registration</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
            </head>
            <body>
                <div class="container mt-5">
                    <h2 class="text-center">Compliance CSID Registration</h2>
                    <form id="registrationForm">
                    @csrf
                        <div class="row">
                           
                            <div class="col-md-4 mb-3">
                                <label for="commonName" class="form-label">Common Name</label>
                                <input type="text" class="form-control" id="commonName" name="commonName" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                        </div>

                        <div class="row">
                        
                            

                        
                            <div class="col-md-4 mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="companyName" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="isRequiredSimplifiedDoc" class="form-label">Requires Simplified Doc</label>
                                <select class="form-select" id="isRequiredSimplifiedDoc" name="isRequiredSimplifiedDoc" required>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                            <div class="col-md-4  mb-3">
                                <label for="isRequiredStandardDoc" class="form-label">Requires Standard Doc</label>
                                <select class="form-select" id="isRequiredStandardDoc" name="isRequiredStandardDoc" required>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>

                       

                        <div class="row">
                        <div class="col-md-4 mb-3">
                                <label for="deviceSerialNumber1" class="form-label">Device Serial Number 1</label>
                                <input type="text" class="form-control" id="deviceSerialNumber1" name="deviceSerialNumber1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="deviceSerialNumber2" class="form-label">Device Serial Number 2</label>
                                <input type="text" class="form-control" id="deviceSerialNumber2" name="deviceSerialNumber2" required>
                            </div>

                        
                            <div class="col-md-4 mb-3">
                                <label for="deviceSerialNumber3" class="form-label">Device Serial Number 3</label>
                                <input type="text" class="form-control" id="deviceSerialNumber3" name="deviceSerialNumber3" required>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-4 mb-3">
                                <label for="vatNumber" class="form-label">VAT Number</label>
                                <input type="text" class="form-control" id="vatNumber" name="vatNumber" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="regAddress" class="form-label">Registration Address</label>
                                <input type="text" class="form-control" id="regAddress" name="regAddress" required>
                            </div>

                        
                            <div class="col-md-4 mb-3">
                                <label for="businessCategory" class="form-label">Business Category</label>
                                <input type="text" class="form-control" id="businessCategory" name="businessCategory" required>
                            </div>
                        </div>

                        <div class="row">
                         
                            <div class="col-md-4 mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                        </div>

                    
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                    <div id="successMessage" class="alert alert-success" style="display:none;"></div>

<!-- Error Message Section -->
<div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->

<script>
$(document).ready(function() {
    $('#registrationForm').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way

        // Clear previous messages
        $('#successMessage').hide();
        $('#errorMessage').hide();

        // Get form data
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('submit.registration') }}", // Make sure this route exists
            method: "POST",
            data: formData,
            success: function(response) {
                // Check if success is true
                if (response.success) {
                    // Show SweetAlert success pop-up
                    Swal.fire({
                        title: 'Success!',
                        text: response.message, // Message from the response
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-success' 
                        },
                        showClass: {
                            popup: 'swal2-noanimation',
                            backdrop: 'swal2-noanimation'
                        },
                        buttonsStyling: false
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the accounting page (adjust the URL as needed)
                            window.location.href = accountingIndexUrl;
                        } else {
                            toastr.info("Action was canceled.");
                        }
                    });
                }
            },
            error: function(xhr) {
                // Display error message
                $('#errorMessage').text('Something went wrong. Please try again.').show();
            }
        });
    });
});
</script>

@endsection
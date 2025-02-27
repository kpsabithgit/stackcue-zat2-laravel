@extends('stackcue-zat2::layouts.app')

@section('content')
    <div class="container">

        <h1 class="mb-4" style="margin-left: 298px">Compliance Sample</h1>
        <div class="mb-3">
            <a href="{{ route('compliancecsid') }}" class="btn btn-primary">Register New Data</a>
        </div>
        <div style="overflow-x: auto;">

            <table class="table table-bordered" style="min-width: 1200px; border-collapse: collapse;width:100%">
                <thead>
                    <tr style="background-color: #dce2e8; border-collapse: collapse;">
                        <th style="width: 3%; border-right: 1px solid #ccc;">#</th>
                        <th style="width: 18%; border-right: 1px solid #ccc;">Company Name</th>
                        <th style="width: 18%; border-right: 1px solid #ccc;">Email</th>
                        <th style="width: 12%; border-right: 1px solid #ccc;">Location</th>
                        <th style="width: 10%; border-right: 1px solid #ccc;">VAT Number</th>
                        <th style="width: 7%; border-right: 1px solid #ccc;">B2C</th>
                        <th style="width: 7%; border-right: 1px solid #ccc;">B2B</th>
                        <th style="width: 7%; border-right: 1px solid #ccc;">Serial Number</th>
                        <th style="width:12%; border-right: 1px solid #ccc;">Issue Date</th>

                        <th style="width:12%; border-right: 1px solid #ccc;">Expiry Date</th>

                        <th style="width:3%; border-right: 1px solid #ccc;">Action</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                    @forelse ($complianceData as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->company_name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->location }}</td>
                            <td>{{ $data->vat_number }}</td>
                            <td>{{ $data->is_required_simplified_doc ? 'Yes' : 'No' }}</td>
                            <td>{{ $data->is_required_standard_doc ? 'Yes' : 'No' }}</td>
                            <td>
                                {{ $data->device_serial_number1 }}<br>
                                {{ $data->device_serial_number2 }}<br>
                                {{ $data->device_serial_number3 }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($data->certificate_issue_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->certificate_expiry_date)->format('Y-m-d') }}</td>


                            <td>

                                <form action="{{ route('compliance.destroy', $data->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this item?');">
                                        Delete
                                    </button>
                                </form>


                                <form id="registrationForm-{{ $data->id }}" method="GET"
                                    action="{{ route('samplecompliaincecheck.index', $data->id) }}"
                                    style="display:inline-block;">
                                    <button type="submit" class="btn btn-success btn-sm mr-2">
                                        <span class="icon"></span> Register
                                    </button>

                                </form>



                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">No compliance data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->

    <head>
        <!-- Add Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>

    <script>
        $(document).ready(function() {
            $('form[id^="registrationForm-"]').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Get the form and its action
                var form = $(this);
                var actionUrl = form.attr('action');
                var rowId = form.data('id'); // Get the row ID to update

                $.ajax({
                    url: actionUrl,
                    method: "GET",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Update the registration status icon dynamically
                                    var statusTd = $(
                                        'td.registration-status[data-id="' + rowId +
                                        '"]');
                                    statusTd.html(
                                        '<i class="fa fa-check-circle" style="color: green;"></i>'
                                        );

                                    // Update the button to show registered status
                                    var registerButton = form.find('button');
                                    registerButton.prop('disabled', true)
                                        .html(
                                            '<i class="fa fa-check-circle" style="color: green;"></i> Registered'
                                            );
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'An error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            });
        });
    </script>
@endsection

@extends('layouts.app') {{-- Extend your main layout --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Compliance CSID Data</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>VAT Number</th>
                <th>Simplified Doc Required</th>
                <th>Standard Doc Required</th>
                <th>Device Serial 1</th>
                <th>Device Serial 2</th>
                <th>Device Serial 3</th>
                <th>Reg Address</th>
                <th>Business Category</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($complianceData as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->company_name }}</td>
                    <td>{{ $data->vat_number }}</td>
                    <td>{{ $data->is_required_simplified_doc ? 'Yes' : 'No' }}</td>
                    <td>{{ $data->is_required_standard_doc ? 'Yes' : 'No' }}</td>
                    <td>{{ $data->device_serial_number1 }}</td>
                    <td>{{ $data->device_serial_number2 }}</td>
                    <td>{{ $data->device_serial_number3 }}</td>
                    <td>{{ $data->reg_address }}</td>
                    <td>{{ $data->business_category }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No compliance data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

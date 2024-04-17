@extends('layouts/layoutMaster')

@section('title', 'Employee')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-ecommerce-product-list.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"></span> Employee Details
    </h4>
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter</h5>
                    <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                        <div class="col-md-4 product_status"></div>
                        <div class="col-md-4 product_category"></div>
                        <div class="col-md-4 product_stock"></div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-products table">
                        <thead class="border-top">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($employes as $employee)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="employee-id" hidden>{{ $employee->id }}</td>
                                    <td class="employee-name"><a href="{{ route('app-employee-show', $employee->id) }}"
                                            class="dropdown-item">{{ $employee->name }}</a>
                                    </td>
                                    <td>{{ $employee->balance }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                            <div class="dropdown-menu">
                                                <!-- Use a class instead of an ID -->
                                                <a class="dropdown-item edit" href="javascript:void(0);">
                                                    <i class="ti ti-pencil me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="ti ti-trash me-1"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add new Employee</h5>
                </div>
                <div class="card-body">
                    <form id="newCustomerform" class="form-repeater">
                        <div data-repeater-list="group-a">
                            <div data-repeater-item="">
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="name">Employee Name</label>
                                        <input type="text" id="name" class="form-control"
                                            placeholder="Enter Employee name ....">
                                    </div>
                                    <div class="col-8 offset-4">
                                        <button class="btn btn-primary waves-effect waves-light" data-repeater-create="">
                                            Save
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Product List Table -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var editemployeeID = null;
            $('.dropdown-menu').on('click', '.edit', function() {
                // Retrieve the product name from the table row
                var employeeName = $(this).closest('tr').find('.employee-name').text().trim();
                editemployeeID = $(this).closest('tr').find('.employee-id').text().trim();
                console.log('working');
                console.log(editemployeeID);
                // Set the retrieved employee name as the value of the input field
                $('#name').val(employeeName);
            });

            $('#newCustomerform').submit(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Collect form data
                var formData = {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'name': $('#name').val(),
                    'id': editemployeeID
                };

                console.log(formData);
                // Send AJAX request to the server
                $.ajax({
                    type: 'POST',
                    url: '/app/employee/store',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        // Handle success response
                        console.log('Data inserted successfully:', data);
                        // Optionally, reset the form after successful submission
                        $('#newCustomerform')[0].reset();
                        window.location.href = "{{ route('app-employee-employee') }}";
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.log(xhr);
                        console.error('Error:', xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>

@endsection

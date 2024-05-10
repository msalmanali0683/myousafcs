@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-logistics-dashboard.css') }}" />

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-logistics-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Cash Book </span>
    </h4>

    <!-- Card Border Shadow -->
    <div class="row">
        @foreach ($banks as $bank)
            <div class="col-sm-6 col-lg-3 mb-4" href= "#">
                <div class="card card-border-shadow-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <a href="#">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-cash ti-md"></i></span>
                                </a>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $bank->balance }}</h4>
                        </div>
                        <p class="mb-1">{{ $bank->name }}</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">{{ $bank->account }}</span>
                            {{-- <small class="text-muted">than last week</small> --}}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <!--/ Card Border Shadow -->
    <div class="row">
        <!-- Orders by Countries -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form id="newCustomerform" class="row g-3" method="POST">
                        @csrf
                        <!-- Account Details -->

                        <div class="row">
                            <div class="mb-3 col-lg-4 col-xl-4 col-12 mb-0">
                                <label class="form-label" for="tyoe">Type</label>
                                <select id="type" class="form-select">

                                    <option value="debit">Cash Out (Debit)</option>
                                    <option selected value="credit">Cash in(Credit)</option>

                                </select>
                            </div>
                            <div class="mb-3 col-lg-4 col-xl-4 col-12 mb-0">
                                <label class="form-label" for="account">Accounts</label>
                                <select id="account" class="form-select">

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}, {{ $bank->account }},
                                            Balance: {{ $bank->balance }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3 col-lg-4 col-xl-4 col-12 mb-0">
                                <label class="form-label" for="category">Category</label>
                                <select id="category" class="form-select" onchange="populateOptions()">
                                    <option id="selectHereOption">Select</option>
                                    <option value="customer">Customer</option>
                                    <option value="employee">Employee</option>
                                    <option value="expense">Expense</option>
                                    <option value="logistics">Logistics</option>
                                    <option value="labour">Labour</option>
                                </select>
                            </div>
                            <div class="mb-3 col-lg-9 col-xl-9 col-12 mb-0">
                                <label class="form-label" for="category_id">Select Name</label>
                                <select id="category_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                                    <!-- Options will be dynamically populated here -->
                                </select>

                            </div>

                            <div class="mb-3 col-lg-3 col-xl-3 col-12 mb-0">
                                <label class="form-label" for="amount">Amount</label>
                                <input type="number" id="amount" class="form-control" placeholder="0" required />
                            </div>
                            <div class="mb-3 col-lg-10 col-xl-10 col-12 mb-0">
                                <label class="form-label" for="details">Details</label>
                                <textarea type="text" id="details" class="form-control" placeholder="Details" required></textarea>
                            </div>

                            <div class="mb-3 col-lg-2 col-xl-2 col-12 d-flex align-items-center mb-0">
                                <button class="btn btn-label-success mt-4" type="submit">
                                    {{-- <i class="ti ti-x ti-xs me-1"></i> --}}
                                    <span class="align-middle">Submit</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr />
        <div class="col-12 order-5">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Daily Balance Sheet</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="routeVehicles" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="routeVehicles">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="dt-route-vehicles table">
                        <thead class="border-top">
                            <tr>
                                <th>#</th>
                                <th>Transaction Type</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Date</th>

                                <th class="w-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerBalances as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td class="transaction_type">{{ $transaction->type }}</td>
                                    <td class="transaction_category">{{ $transaction->category }}</td>
                                    <td class="transaction_category_id">
                                        @if ($transaction->category === 'customer')
                                            <a href="{{ route('app-ecommerce-customer-show', $transaction->customer_id) }}"
                                                class="dropdown-item"> {{ $transaction->customer_name }}</a>
                                        @elseif ($transaction->category === 'employee')
                                            <a href="{{ route('app-employee-show', $transaction->employee_id) }}"
                                                class="dropdown-item">{{ $transaction->employee_name }}</a>
                                        @elseif ($transaction->category === 'expense')
                                            <a href="{{ route('app-expense-show', $transaction->expense_id) }}"
                                                class="dropdown-item">
                                                {{ $transaction->expense_name }}</a>
                                        @elseif ($transaction->category === 'logistics')
                                            <a href="{{ route('app-logistics-show', $transaction->logistics_id) }}"
                                                class="dropdown-item">{{ $transaction->logistics_name }}</a>
                                        @elseif ($transaction->category === 'labour')
                                            <a href="{{ route('app-employee-labour-show', $transaction->labour_id) }}"
                                                class="dropdown-item">{{ $transaction->labour_name }}</a>
                                        @endif
                                    </td>
                                    <td class="transaction_bank"><a
                                            href="{{ route('app-bank-show', $transaction->bank_id) }}">{{ $transaction->bank_name }}</a>
                                    </td>
                                    <td class="transaction_amount">{{ $transaction->amount }}</td>
                                    <td class="transaction_date">{{ date('d-M-Y', strtotime($transaction->created_at)) }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                            <div class="dropdown-menu">
                                                {{-- <a class="dropdown-item"
                                                    href="{{ route('customer.edit', $transaction->id) }}"><i
                                                        class="ti ti-pencil me-1"></i>Edit</a> --}}
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-trash me-1"></i>Delete</a>
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

        <!--/ On route vehicles Table -->
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var selectedAccountBalance = 0;
        var enteredAmount = 0;
        var transaction_type = $('#type').val();
        $('#newCustomerform').submit(function(event) {
            // Prevent default form submission

            event.preventDefault();
            // Collect form data
            var formData = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'type': $('#type').val(),
                'category': $('#category').val(),
                'category_id': $('#category_id').val(),
                'details': $('#details').val(),
                'account': $('#account').val(),
                'amount': $('#amount').val()
            };

            console.log(formData);
            if (validateSelectedFields(formData)) {
                if (enteredAmount > selectedAccountBalance && transaction_type == 'debit') {
                    console.log(selectedAccountBalance);
                    console.log(enteredAmount);
                    Swal.fire({
                        title: 'Error!',
                        text: ' Entered amount exceeds account balance',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });

                } else {

                    // If all selected fields are filled, submit the form
                    $.ajax({
                        type: 'POST', // Ensure that the method is POST
                        url: '/app/transaction/save',
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            // Handle success response
                            console.log('Data inserted successfully:', data);
                            // Optionally, reset the form after successful submission
                            $('#newCustomerform')[0].reset();
                            window.location.href = "{{ route('pages-home') }}";
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.log('Error:', xhr.responseText);
                        }
                    });
                }
            } else {
                // If any selected field is null or empty, show error message
                Swal.fire({
                    title: 'Error!',
                    text: ' Please fill in all selected fields',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });

            }
            // Send AJAX request to the server

        });



        // Event listener for the account select element
        document.getElementById('account').addEventListener('change', function() {
            // Get the selected account balance
            var selectedIndex = this.selectedIndex;
            selectedAccountBalance = parseFloat(this.options[selectedIndex].innerText.split(
                'Balance: ')[1]);
        });



        document.getElementById('type').addEventListener('input', function() {
            transaction_type = this.value;

        });

        document.getElementById('amount').addEventListener('input', function() {
            enteredAmount = parseFloat(this.value);

            if (enteredAmount > selectedAccountBalance && transaction_type == 'debit') {
                Swal.fire({
                    title: 'Error!',
                    text: ' Entered amount exceeds account balance',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });

            }
        });
    });



    function validateSelectedFields(formData) {
        var fieldsToCheck = ['type', 'category', 'category_id', 'account', 'amount'];

        for (var i = 0; i < fieldsToCheck.length; i++) {
            var field = fieldsToCheck[i];
            if (!formData[field] || formData[field].trim() === '') {
                return false; // Return false if any field is null or empty
            }
        }
        return true; // Return true if all selected fields are filled
    }

    function populateOptions() {
        var category = document.getElementById('category').value;
        var selectElement = document.getElementById('category_id');
        selectElement.innerHTML = ''; // Clear existing options
        var selectHereOption = document.getElementById('selectHereOption');
        selectHereOption.style.display = 'none';

        // Add options based on the selected category
        if (category === 'customer') {
            @foreach ($customers as $customer)
                selectElement.innerHTML += '<option value="{{ $customer->id }}">{{ $customer->name }}</option>';
            @endforeach
        }
        if (category === 'labour') {
            @foreach ($labours as $labour)
                selectElement.innerHTML += '<option value="{{ $labour->id }}">{{ $labour->name }}</option>';
            @endforeach
        }
        if (category === 'logistics') {
            @foreach ($logistics as $logistic)
                selectElement.innerHTML += '<option value="{{ $logistic->id }}">{{ $logistic->name }}</option>';
            @endforeach
        }
        if (category === 'expense') {
            @foreach ($expenses as $expense)
                selectElement.innerHTML += '<option value="{{ $expense->id }}">{{ $expense->name }}</option>';
            @endforeach
        }
        if (category === 'employee') {
            @foreach ($employees as $employee)
                selectElement.innerHTML += '<option value="{{ $employee->id }}">{{ $employee->name }}</option>';
            @endforeach
        }

        // Add more conditions for other categories if needed
    }
</script>

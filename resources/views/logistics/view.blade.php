@extends('layouts/layoutMaster')

@section('title', 'Logistic View')

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
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>

@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">logistic View </span>
        <span><strong>{{ $logistic->name }}</strong></span>

    </h4>


    <!--/ Card Border Shadow -->
    <div class="row">
        <!-- Orders by Countries -->
        <div class="col-12 order-5">
            <div class="card ">
                <hr />
                <div class="row p-4">
                    <div class="col-lg-3">
                        <h5 class="m-0 me-2 mt-4">Logistic Balance Sheet</h5>
                    </div>
                    <div class="col-lg-2">
                        <label for="startDate">Start Date:</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="col-lg-2">
                        <label for="endDate">End Date:</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                    <div class="col-lg-2 mt-3">
                        <button class="btn btn-primary mt-2" onclick="filterData()">Filter</button>

                    </div>
                    <div class="col-lg-3 mt-4">
                        <p>Available Balance : {{ $logistic->balance }}</p>
                    </div>
                </div>
                <hr />
                <div class="card-datatable table-responsive">
                    <table class="dt-route-vehicles table">
                        <thead class="border-top">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="balanceTableBody">
                            @php
                                $balance = $logistic->balance;
                            @endphp
                            @foreach ($logistics as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    @if ($item->invoice_type == 'purchase' || $item->invoice_type == 'sale')
                                        <td><a href="{{ route('app-invoice-show', $item->invoice_id) }}"
                                                data-bs-toggle="tooltip" class="text-body" data-bs-placement="top"
                                                aria-label="Preview Invoice"
                                                data-bs-original-title="Preview Invoice">{{ $item->details }}</a></td>
                                    @else
                                        <td>{{ $item->details }}</td>
                                    @endif
                                    @if ($item->type == 'debit')
                                        <td>{{ $item->amount }}</td>
                                        <td>0</td>
                                        <td>{{ $balance }}</td>

                                        @php
                                            $balance += $item->amount;
                                        @endphp
                                    @else
                                        <td>0</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $balance }}</td>
                                        @if ($item->amount <= 0)
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown"><i
                                                            class="ti ti-dots-vertical"></i></button>
                                                    <div class="dropdown-menu">
                                                        <!-- Use a class instead of an ID -->
                                                        <button class="btn btn-primary add-amount"
                                                            data-id="{{ $item->id }}">
                                                            Add Amount
                                                        </button>
                                                        {{-- <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="ti ti-trash me-1"></i>Delete
                                                    </a> --}}
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        @php
                                            $balance -= $item->amount;
                                        @endphp
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-center",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Add click event listener to Add Amount buttons
        $('.add-amount').click(function() {
            // Get the transaction details ID
            var transactionId = $(this).data('id');
            // Prompt user for input using SweetAlert
            Swal.fire({
                title: 'Enter amount',
                input: 'number',
                showCancelButton: true,
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-danger'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var value = result.value;
                    // If user confirms, update logistic_amount via AJAX
                    if (value !== null && value !== '') {
                        $.ajax({
                            url: '/app/logistics/update_balance',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                transactionId: transactionId,
                                amount: value
                            },
                            success: function(response) {
                                // If update is successful, update the table cell
                                if (response.success) {
                                    $('td[data-id="' + transactionId + '"]').text(
                                        value);
                                    Toast.fire({
                                        icon: "success",
                                        title: "Amount updated successfully"
                                    });
                                    location.reload();

                                } else {
                                    Toast.fire({
                                        icon: "Error",
                                        title: response.message
                                    });

                                }
                            },
                            error: function(xhr, status, error) {
                                swal('Error',
                                    'An error occurred while processing your request',
                                    'error');
                            }
                        });
                    }
                }
            });
        });
    });


    function filterData() {
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        var tableBody = document.getElementById("balanceTableBody");

        // Loop through each row in the table body
        for (var i = 0; i < tableBody.rows.length; i++) {
            var row = tableBody.rows[i];
            var date = row.cells[1].innerText; // Assuming the date is in the second column

            // Show/hide rows based on the date range
            if (date >= startDate && date <= endDate) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
</script>

@extends('layouts/layoutMaster')

@section('title', 'Customer View')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
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
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Customer View </span>
        <hr />
        <span><strong>{{ $customer->name }}</strong></span>
        <span>{{ $customer->contact }}</span>
        <span><small>{{ $customer->address }}</small></span>
    </h4>


    <!--/ Card Border Shadow -->
    <div class="row">
        <!-- Orders by Countries -->
        <div class="col-12 order-5">
            <div class="card ">
                <hr />
                <div class="row p-4">
                    <div class="col-lg-3">
                        <h5 class="m-0 me-2 mt-4">Customer Balance Sheet</h5>
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
                        <p>Available Balance : {{ $customer->balance }}</p>
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
                            </tr>
                        </thead>
                        <tbody id="balanceTableBody">
                            @php
                                $balance = $customer->balance;
                            @endphp
                            @foreach ($customerBalance as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    @if ($item->category == 'purchase_product' || $item->category == 'sale_product')
                                        <td><a href="{{ route('app-invoice-show', $item->account) }}"
                                                data-bs-toggle="tooltip" class="text-body" data-bs-placement="top"
                                                aria-label="Preview Invoice" data-bs-original-title="Preview Invoice">
                                                @if (isset($item->product_details) && is_object($item->product_details))
                                                    @foreach ($item->product_details->product_transactions ?? [] as $product_details)
                                                        <p>
                                                            <strong><small>
                                                                    {{ $product_details->product->name ?? 'N/A' }},
                                                                    Bags:{{ $product_details->bags ?? 'N/A' }},
                                                                    {{ $product_details->weight ?? 'N/A' }}Kg's,
                                                                    Rate: {{ $product_details->rate ?? 'N/A' }}/mn
                                                                </small></strong>
                                                        </p>
                                                    @endforeach
                                                @else
                                                    <p>No product details available.</p>
                                                @endif

                                                {{-- {{ $item->product_details }} --}}
                                            </a></td>
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
        flatpickr("#endDate", {
            dateFormat: "d-m-Y", // Set the date format to "d-m-Y" (day-month-year)
        });
        flatpickr("#startDate", {
            dateFormat: "d-m-Y", // Set the date format to "d-m-Y" (day-month-year)
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
            console.log(date + ', ' + startDate + ', ' + endDate);

            // Show/hide rows based on the date range
            if (date >= startDate && date <= endDate) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
</script>

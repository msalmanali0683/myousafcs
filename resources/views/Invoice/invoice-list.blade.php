@extends('layouts/layoutMaster')

@section('title', 'Invoice List - Pages')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-invoice-list.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Invoice /</span> List
    </h4>

    <!-- Invoice List Widget -->

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                            <div>
                                <h3 class="mb-1">24</h3>
                                <p class="mb-0">Clients</p>
                            </div>
                            <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-user ti-md"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-4">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                                <h3 class="mb-1">165</h3>
                                <p class="mb-0">Invoices</p>
                            </div>
                            <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-file-invoice ti-md"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                                <h3 class="mb-1">$2.46k</h3>
                                <p class="mb-0">Paid</p>
                            </div>
                            <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-checks ti-md"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="mb-1">$876</h3>
                                <p class="mb-0">Unpaid</p>
                            </div>
                            <span class="avatar">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-circle-off ti-md"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="invoice-list-table table border-top">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th class="text-truncate">Date</th>
                        <th>Balance</th>
                        <th>Invoice Type</th>
                        <th class="cell-fit">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $product_name = '';
                    @endphp
                    @foreach ($invoices as $invoice)
                        @foreach ($invoice['product_transactions'] as $transaction)
                            @php
                                $product_name = $transaction['product']['name'];
                            @endphp
                            {{-- Break out of the loop after setting product name --}}
                        @break
                    @endforeach
                    <tr>
                        <td> #{{ $i++ }}</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2"><span
                                            class="avatar-initial rounded-circle bg-label-info">{{ substr($invoice->customer->name, 0, 2) }}</span>
                                    </div>
                                </div>

                                <div class="d-flex flex-column"><a
                                        href="{{ route('app-ecommerce-customer-show', $invoice->customer->id) }}"
                                        class="text-body text-truncate"><span
                                            class="fw-medium">{{ $invoice->customer->name }}</span></a><small
                                        class="text-truncate text-muted">{{ $invoice->customer->contact }}</small>
                                </div>
                            </div>
                        </td>
                        <td> {{ $product_name }}</td>
                        <td> {{ $invoice->date }}</td>
                        <td> {{ $invoice->total_amount }}</td>
                        <td> {{ $invoice->invoice_type }}</td>
                        {{-- <td class="sorting_1"><a
                                    href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo-1/app/invoice/preview">#5089</a>
                            </td> --}}


                        <td>
                            <div class="d-flex align-items-center"><a
                                    href="{{ route('app-invoice-show', $invoice->id) }}" data-bs-toggle="tooltip"
                                    class="text-body" data-bs-placement="top" aria-label="Preview Invoice"
                                    data-bs-original-title="Print Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                                <div class="dropdown"><a href="javascript:;"
                                        class="btn dropdown-toggle hide-arrow text-body p-0"
                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end"><a
                                            href="{{ route('download.pdf', $invoice->id) }}"
                                            class="dropdown-item">Download</a><a
                                            href="{{ route('download.pdf', $invoice->id) }}"
                                            class="dropdown-item">Edit</a><a href="javascript:;"
                                            class="dropdown-item">Duplicate</a>
                                        <div class="dropdown-divider"></div><a href="javascript:;"
                                            class="dropdown-item delete-record text-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</div>

@endsection

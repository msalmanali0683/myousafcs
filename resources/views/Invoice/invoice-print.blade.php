@extends('layouts/layoutMaster')

@section('title', 'Invoice (Print version) - Pages')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-invoice-print.js') }}"></script>
@endsection

@section('content')
    <div class="invoice-print p-1">

        <div class="d-flex justify-content-between flex-row">
            <div class="mb-4">
                <div class="d-flex svg-illustration">
                    {{-- @include('_partials.macros', ['height' => 20, 'withbg' => '']) --}}
                    <span class="app-brand-text fw-bold" style="font-size: 3em">
                        Muhammad Yousaf
                    </span>

                </div>
                <div class="d-flex svg-illustration mb-3 gap-2">
                    {{-- @include('_partials.macros', ['height' => 20, 'withbg' => '']) --}}
                    <span class="app-brand-text fw-bold" style="font-size: 3em">
                        Commission Shop
                    </span>

                </div>
                <p class="pl-5">3KM, Pakpattan Road, Khairpur Depalpur, OKara</p>
            </div>
            <div class="mt-3">
                <p>Muhammad Akram-0300-6979029</p>
                <p> Muhammad Yousaf-0332-6979029</p>
                <p> Muhammad Ajmal-0307-6779029</p>

            </div>
        </div>

        <hr />

        <div class="row d-flex justify-content-between mb-4">
            <div class="col-sm-6 w-50">
                <h6>Invoice Details:</h6>
                <p class="mb-1">{{ $invoice->customer->name }}</p>
                <p class="mb-1">{{ $invoice->customer->contact }}</p>
                <p class="mb-1">{{ $invoice->customer->address }}</p>
            </div>
            <div class="col-sm-6 w-50">
                <table>

                    <tbody>
                        <tr>
                            <td class="pe-3">Invoice #</td>
                            <td class="fw-medium">{{ $invoice->id }}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">Date:</td>
                            <td>{{ $invoice->date }}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">Invoice Type:</td>
                            <td>{{ $invoice->invoice_type }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table m-0">
                @php
                    $i = 1;

                @endphp
                <thead class="table-light">
                    <tr>
                        {{-- <th>{{ $invoice }}</th> --}}
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Bags</th>
                        <th>Total Weight kg</th>
                        <th>Weight MN-kg</th>
                        <th>Rate</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice['product_transactions'] as $transaction)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $transaction['product']['name'] }}</td>
                            <td>{{ $transaction['bags'] }}</td>
                            <td>{{ $transaction['weight'] }}</td>
                            <td>{{ intval(floatval($transaction['weight']) / 40) }}
                                - {{ floatval($transaction['weight']) % 40 }}
                            </td>
                            <td>{{ $transaction['rate'] }}</td>
                            <td>{{ intval(floatval($transaction['weight']) / 40) * floatval($transaction['rate']) + (floatval($transaction['weight']) % 40) * (floatval($transaction['rate']) / 40) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr />

        @if (!empty($invoice['adjustment']) && count($invoice['adjustment']) > 0)
            <div class="table-responsive">
                <table class="table m-0">
                    @php
                        $i = 1;
                    @endphp
                    <thead class="table-light">
                        <tr>
                            {{-- <th>{{ $invoice }}</th> --}}
                            <th>#</th>
                            <th>Details</th>
                            <th>Adjustment Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice['adjustment'] as $adjustment)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $adjustment['details'] }}</td>
                                <td>{{ $adjustment['type'] }}</td>
                                <td>{{ $adjustment['amount'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif


        <div class="row">
            <div class="col-9">

            </div>
            <div class="col-3">
                <hr />
                <span class="fw-medium">Total Amount:</span>
                <span>{{ $invoice->total_amount }}</span>
                <hr />
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{-- <span class="fw-medium">Note:</span>
                <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future
                    freelance projects. Thank You!</span> --}}
            </div>
        </div>
    </div>
@endsection

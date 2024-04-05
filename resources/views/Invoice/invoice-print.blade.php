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
                <p class="mb-1">Thomas shelby</p>
                <p class="mb-1">Shelby Company Limited</p>
                <p class="mb-1">Small Heath, B10 0HF, UK</p>
            </div>
            <div class="col-sm-6 w-50">
                <table>

                    <tbody>
                        <tr>
                            <td class="pe-3">Invoice #</td>
                            <td class="fw-medium">$12,110.55</td>
                        </tr>
                        <tr>
                            <td class="pe-3">Date:</td>
                            <td>American Bank</td>
                        </tr>
                        <tr>
                            <td class="pe-3">Invoice Type:</td>
                            <td>United States</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table m-0">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Cost</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Vuexy Admin Template</td>
                        <td>HTML Admin Template</td>
                        <td>$32</td>
                        <td>1</td>
                        <td>$32.00</td>
                    </tr>
                    <tr>
                        <td>Frest Admin Template</td>
                        <td>Angular Admin Template</td>
                        <td>$22</td>
                        <td>1</td>
                        <td>$22.00</td>
                    </tr>
                    <tr>
                        <td>Apex Admin Template</td>
                        <td>HTML Admin Template</td>
                        <td>$17</td>
                        <td>2</td>
                        <td>$34.00</td>
                    </tr>
                    <tr>
                        <td>Robust Admin Template</td>
                        <td>React Admin Template</td>
                        <td>$66</td>
                        <td>1</td>
                        <td>$66.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="align-top px-4 py-3">
                            <p class="mb-2">
                                <span class="me-1 fw-medium">Salesperson:</span>
                                <span>Alfie Solomons</span>
                            </p>
                            <span>Thanks for your business</span>
                        </td>
                        <td class="text-end px-4 py-3">
                            <p class="mb-2">Subtotal:</p>
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2">Tax:</p>
                            <p class="mb-0">Total:</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="fw-medium mb-2">$154.25</p>
                            <p class="fw-medium mb-2">$00.00</p>
                            <p class="fw-medium mb-2">$50.00</p>
                            <p class="fw-medium mb-0">$204.25</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12">
                <span class="fw-medium">Note:</span>
                <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future
                    freelance projects. Thank You!</span>
            </div>
        </div>
    </div>
@endsection
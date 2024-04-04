@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Purchase')

@section('vendor-style')

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('vendor-script')
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
    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>


    {{-- <script src="{{ asset('assets/js/invoice/purchase.js') }}"></script> --}}

@endsection
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }
</style>

@section('content')
    <div class="row invoice-add">
        <!-- Invoice Add-->
        <div class="modal-onboarding modal fade animate__animated" id="onboardHorizontalImageModal" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content text-center">
                    <div class="modal-body onboarding-horizontal p-0">
                        {{-- <div class="onboarding-media">
            <img src="{{asset('assets/img/illustrations/boy-verify-email-'.$configData['style'].'.png')}}" alt="boy-verify-email-light" width="273" class="img-fluid" data-app-light-img="illustrations/boy-verify-email-light.png" data-app-dark-img="illustrations/boy-verify-email-dark.png">
          </div> --}}
                        <div class="onboarding-content mb-0">
                            <h4 class="onboarding-title text-body">New Custoomer details</h4>
                            <form id="newCustomerform" class="row g-3">
                                @csrf
                                <!-- Account Details -->

                                <div class="col-12">
                                    <h6>New Customers</h6>
                                    <hr class="mt-0" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="formValidationName">Full Name</label>
                                    <input type="text" id="formValidationName" class="form-control"
                                        placeholder="Enter full name........." name="formValidationName" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="contact_number">Contact Number</label>
                                    <input type="text" id="contact_number" class="form-control"
                                        placeholder="Enter Mobile number ..............." name="contact_number" required />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" id="address" class="form-control"
                                        placeholder="Enter complete address" name="address" required />
                                </div>

                                <div class="col-4 offset-4">

                                </div>
                                <div class="modal-footer border-1">
                                    <button type="button" class="btn btn-label-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submitButton" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="save">
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#onboardHorizontalImageModal">
                            Add New Custome
                        </button>
                        <hr class="my-3 mx-n4" />

                        <div class="row p-sm-4 p-0">
                            <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-4">
                                <h6 class="mb-4">Invoice To:</h6>
                                <select id="customer_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }},
                                            {{ $customer->address }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-5">
                                <dl class="row mb-2">
                                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                                        <span class="h4 text-capitalize mb-0 text-nowrap">Invoice</span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                                        <div class="input-group input-group-merge disabled w-px-150">
                                            <span class="input-group-text">#</span>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $invoice->id ? $invoice->id + 1 : 1 }}" id="invoiceId" />

                                        </div>
                                    </dd>
                                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                                        <span class="fw-normal">Date:</span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                                        <input type="text" id="date" class="form-control w-px-150 date-picker"
                                            placeholder="YYYY-MM-DD" />
                                    </dd>
                                </dl>
                            </div>
                        </div>


                        <hr class="my-3 mx-n4" />

                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Product Details</h5>
                                <div class="card-body">
                                    <form id="form-repeater" class="form">
                                        <div id="repeater-container">
                                            <div class="product_details_form">
                                                <div class="row">
                                                    <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                        <label class="form-label" for="product">Product</label>
                                                        <select id="product" class="form-select">
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">
                                                                    {{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="bags">Bags</label>
                                                        <input type="number" id="bags" class="form-control"
                                                            placeholder="0" required />
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="weight">Total Weight in
                                                            KG</label>
                                                        <input type="number" id="weight" class="form-control"
                                                            placeholder="0" required />
                                                    </div>
                                                    <div class="mb-3 col-lg-4 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="weight_mn">Weight in MN</label>
                                                        <input type="number" id="weight_mn" class="form-control"
                                                            placeholder="0" required disabled />
                                                    </div>
                                                    <div class="mb-3 col-lg-4 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="weight_mn">Weight in Kg</label>
                                                        <input type="number" id="weight_kg" class="form-control"
                                                            placeholder="0" required disabled />
                                                    </div>
                                                    <div class="mb-3 col-lg-4 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="rate">Rate</label>
                                                        <input type="number" id="rate" class="form-control"
                                                            placeholder="0" required />
                                                    </div>
                                                    <div class="mb-3 col-lg-4 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="total_amount">Total
                                                            Amount</label>
                                                        <input type="number" id="total_amount" class="form-control"
                                                            placeholder="0" />
                                                    </div>

                                                    <div
                                                        class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                        <button class="btn btn-label-danger mt-4 delete-button">
                                                            <i class="ti ti-x ti-xs me-1"></i>
                                                            <span class="align-middle">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <button class="btn btn-primary" id="add-button">
                                                <i class="ti ti-plus me-1"></i>
                                                <span class="align-middle">Add</span>
                                            </button>
                                        </div>
                                        <hr />
                                        <hr />
                                        <h5 class="card-header">Adjustment Details</h5>
                                        <hr />
                                        <hr />
                                        <div id="repeater-container">
                                            <div class="adjustment_details_form">
                                                <div class="row">
                                                    <div class="mb-3 col-lg-4 col-xl-4 col-12 mb-0">
                                                        <label class="form-label"
                                                            for="adjustment_description">Details</label>
                                                        <input type="text" id="adjustment_description"
                                                            class="form-control" placeholder="write here" required />
                                                    </div>
                                                    <div class="mb-3 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="adjustment_amount">Amount</label>
                                                        <input type="number" id="adjustment_amount" class="form-control"
                                                            placeholder="0" required />
                                                    </div>
                                                    <div class="mb-3 col-lg-3 col-xl-3 col-12 mb-0">
                                                        <label class="form-label" for="adjustment_type">Adjustment
                                                            Type</label>
                                                        <select id="adjustment_type" class="form-select">
                                                            <option selected value="add">Add</option>
                                                            <option value="deduct">Deduct</option>
                                                        </select>
                                                    </div>
                                                    <div
                                                        class="mb-3 col-lg-2 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                        <button class="btn btn-label-danger mt-4 delete-button">
                                                            <i class="ti ti-x ti-xs me-1"></i>
                                                            <span class="align-middle">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <button class="btn btn-primary" id="add-adjustment">
                                                <i class="ti ti-plus me-1"></i>
                                                <span class="align-middle">Add</span>
                                            </button>
                                        </div>
                                        <hr class="my-3 mx-n4" />
                                        <hr class="my-3 mx-n4" />

                                        <div class="row p-0 p-sm-4">
                                            <div class="col-md-10 mb-md-0 mb-3">
                                                <div class="row p-0 p-sm-4">
                                                    <div class="mb-3 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="labour_type">Labour Type
                                                            Type</label>
                                                        <select id="labour_type" class="form-select">
                                                            <option value="own">Own</option>
                                                            <option value="client">Client</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mb-5">
                                                        <label for="selectpickerLabourAccount" class="form-label">Labour
                                                            Account</label>
                                                        <select id="labour_account"
                                                            class="select2 form-select form-select-lg"
                                                            data-allow-clear="true">
                                                            @foreach ($labours as $labour)
                                                                <option value="{{ $labour->id }}">{{ $labour->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-5 mb-5">
                                                        <label for="labour_amount" class="form-label">Labour
                                                            Amount</label>
                                                        <input class="form-control"
                                                            placeholder="Enter  Amount Give to  labour..." type="text"
                                                            value="" tabindex="0" id="labour_amount">

                                                    </div>
                                                    <div class="mb-3 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="logistic_type">Logistic
                                                            Type</label>
                                                        <select id="logistic_type" class="form-select">
                                                            <option value="own">Own</option>
                                                            <option value="client">Client</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-4">
                                                        <label for="logistic_account" class="form-label">Vehicle
                                                            Number</label>
                                                        <select id="logistic_account"
                                                            class="select2 form-select form-select-lg"
                                                            data-allow-clear="true">
                                                            @foreach ($logistics as $logistic)
                                                                <option value="{{ $logistic->id }}">{{ $logistic->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 mb-4">
                                                        <label for="logistic_driver" class="form-label">Driver
                                                            Name</label>
                                                        <input class="form-control" placeholder="Enter  Driver name..."
                                                            type="text" value="" tabindex="0"
                                                            id="logistic_driver">

                                                    </div>
                                                    <div class="col-sm-3 mb-4">
                                                        <label for="logistic_amount" class="form-label">Amount</label>
                                                        <input class="form-control" placeholder="Enter  Amount..."
                                                            type="number" value="" tabindex="0"
                                                            id="logistic_amount">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-end">
                                                <div class="invoice-calculations">
                                                    {{-- <div class="d-flex justify-content-between mb-2">
                                                        <span class="w-px-100">Subtotal:</span>
                                                        <span class="fw-medium">$00.00</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="w-px-100">Discount:</span>
                                                        <span class="fw-medium">$00.00</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="w-px-100">Tax:</span>
                                                        <span class="fw-medium">$00.00</span>
                                                    </div> --}}
                                                    <hr />
                                                    <div class="d-flex justify-content-between">
                                                        <span class="w-px-100">Total:</span>
                                                        <span id="grand_amount" class="fw-medium">0.00</span>
                                                    </div>
                                                    <hr />
                                                    <button class="btn btn-success" id="save">
                                                        <i class="ti ti-plus me-1"></i>
                                                        <span class="align-middle">Save</span>
                                                    </button>
                                                    <hr />
                                                    <hr />

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <hr class="my-3 mx-n4" />
                    </div>
                </div>
            </div>
        </form>
        <!-- /Invoice Add-->

    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Offcanvas -->
@include('_partials/_offcanvas/offcanvas-send-invoice')
<!-- /Offcanvas -->
<script>
    $(document).ready(function() {
        // Attach change event handler to the Labour Category select box
        var today = new Date().toISOString().split('T')[0];

        // Set the value of the input field to today's date
        document.getElementById('date').value = today;
        $('#labourcategory').change(function() {
            // Get the selected value
            var labourAccountSelect = document.getElementById('labourAccountSelectBox');
            var selectedValue = $(this).val();
            if (selectedValue === 'Self') {
                console.log(selectedValue);
                $("#labourAccountSelectBox").css("display", "block");
                $("#labour_block").css("display", "block");

            } else {
                $("#labourAccountSelectBox").css("display", "none");
                $("#labour_block").css("display", "none");


            }

        });

        // Trigger the change event on page load to handle initial state
        $('#selectpickerBasic').change();

        $('#newCustomerform').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Collect form data
            var formData = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'name': $('#formValidationName').val(),
                'contact_number': $('#contact_number').val(),
                'address': $('#address').val()
            };

            console.log(formData);
            // Send AJAX request to the server
            $.ajax({
                type: 'POST',
                url: '/app/ecommerce/customer/create/store',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    // Handle success response
                    console.log('Data inserted successfully:', data);
                    window.location.reload();
                    // Optionally, reset the form after successful submission
                    $('#newCustomerform')[0].reset();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                }
            });
        });

        $('#save').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Combine data from the other three forms
            var formData = {};
            var productDetailsFormData = [];

            $('#repeater-container .product_details_form').each(function() {
                var product = $(this).find('#product').val();
                var bags = $(this).find('#bags').val();
                var weight = $(this).find('#weight').val();
                var rate = $(this).find('#rate').val();
                var totalAmount = $(this).find('#total_amount').val();

                // Create an object with the collected data
                var productDetail = {
                    'product': product,
                    'bags': bags,
                    'weight': weight,
                    'rate': rate,
                    'totalAmount': totalAmount
                };

                // Push the object into the array
                productDetailsFormData.push(productDetail);
            });
            console.log(productDetailsFormData);
            var adjustmentDetailsFormData = [];

            $('#repeater-container .adjustment_details_form').each(function() {
                var description = $(this).find('#adjustment_description').val();
                var amount = $(this).find('#adjustment_amount').val();
                var type = $(this).find('#adjustment_type')
                    .val();

                // Create an object with the collected data
                var adjustmentDetail = {
                    'description': description,
                    'amount': amount,
                    'type': type
                };

                // Push the object into the array
                adjustmentDetailsFormData.push(adjustmentDetail);
            });
            console.log(adjustmentDetailsFormData);

            var labour = {
                'labour_type': $('#labour_type').val(),
                'labour_account': $('#labour_account').val(),
                'labour_amount': $('#labour_amount').val(),
            };

            var logistic = {
                'logistic_type': $('#logistic_type').val(),
                'logistic_account': $('#logistic_account').val(),
                'logistic_driver': $('#logistic_driver').val(),
                'logistic_amount': $('#logistic_amount').val(),
            };

            formData.logistic = logistic;
            formData.labour = labour;
            formData.adjustmentDetailsFormData = adjustmentDetailsFormData;
            formData.productDetailsFormData = productDetailsFormData;
            formData.user = {
                'customer_id': $('#customer_id').val(),
                'date': $('#date').val(),
                'grand_amount': $('#grand_amount').text().trim(),

            };
            formData._token = $('meta[name="csrf-token"]').attr('content');
            formData.invoice_type = 'sale';

            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '/app/ecommerce/invoice/store',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    // Handle success response
                    console.log('Data inserted successfully:', data);
                    // window.location.reload();
                    // // Optionally, reset the form after successful submission
                    // $('#newCustomerform')[0].reset();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                }
            });


        });
        $('#add-button').click(function(event) {
            event.preventDefault();
            var $lastItem = $('.product_details_form:last');
            var $clonedItem = $lastItem.clone(true);
            $clonedItem.find('input, select').val('');
            $clonedItem.insertAfter($lastItem);
        });

        // Delete button click event handler
        $(document).on('click', '.delete-button', function() {
            $(this).closest('.product_details_form').remove();
        });

        $('#add-adjustment').click(function(event) {
            event.preventDefault();
            var $lastItem = $('.adjustment_details_form:last');
            var $clonedItem = $lastItem.clone(true);
            $clonedItem.find('input, select').val('');
            $clonedItem.insertAfter($lastItem);
        });

        // Delete button click event handler
        $(document).on('click', '.delete-button', function() {
            $(this).closest('.adjustment_details_form').remove();
        });

        function calculateGrandTotal() {
            var grandTotal = 0;

            // Calculate total of product details form
            $('#repeater-container .product_details_form').each(function() {
                var totalAmount = parseFloat($(this).find('#total_amount').val()) || 0;
                grandTotal += totalAmount;
            });

            // Calculate total of adjustment details form
            $('#repeater-container .adjustment_details_form').each(function() {

                var adjustment_type = $(this).find('#adjustment_type').val();
                var amount = parseFloat($(this).find('#adjustment_amount').val()) || 0;

                if (adjustment_type == 'add') {
                    grandTotal += amount;

                } else {
                    grandTotal -= amount;

                }
            });

            // Display grand total
            $('#grand_amount').text(grandTotal.toFixed(2));
        }

        // Attach input event handlers to relevant input fields
        // Attach input event handlers to relevant input fields
        $(document).on('input', '#repeater-container input[type="number"], #labour_amount, #logistic_amount',
            function() {
                calculateGrandTotal();
            });
        $('#bags, #weight, #weight_mn, #rate').on('input', function() {
            // Get the values of bags, weight, weight_mn, and rate
            var $form = $(this).closest('.product_details_form');

            // Find the input fields within the specific form
            var bags = parseInt($form.find('#bags').val()) || 0;
            var weight = parseFloat($form.find('#weight').val()) || 0;
            var weight_mn = parseFloat($form.find('#weight_mn').val()) || 0;
            var rate = parseFloat($form.find('#rate').val()) || 0;

            // Update the calculated values within the specific form
            $form.find('#weight_mn').val((weight / 40).toFixed(0));
            $form.find('#weight_kg').val((weight % 40).toFixed(0));

            var totalAmount = weight_mn * rate;
            $form.find('#total_amount').val(totalAmount.toFixed(2));

            // Calculate and update the grand total
            calculateGrandTotal();
        });


        // Trigger initial calculation
        calculateGrandTotal();

        $('#labour_type').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'own') {
                // If Labour Type is "Own", make Labour Account and Labour Amount fields required
                $('#labour_account, #labour_amount').prop('disabled', false).prop('required', true);
            } else if (selectedValue === 'client') {
                // If Labour Type is "Client", disable Labour Account and Labour Amount fields
                $('#labour_account, #labour_amount').prop('disabled', true).prop('required', false);
            }
        });

        // Function to enable/disable fields based on the selected value of the Logistic Type dropdown
        $('#logistic_type').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'own') {
                // If Logistic Type is "Own", make Vehicle Number, Driver Name, and Amount fields required
                $('#logistic_account, #logistic_driver, #logistic_amount').prop('disabled', false).prop(
                    'required', true);
            } else if (selectedValue === 'client') {
                // If Logistic Type is "Client", disable Vehicle Number, Driver Name, and Amount fields
                $('#logistic_account, #logistic_driver, #logistic_amount').prop('disabled', true).prop(
                    'required', false);
            }
        });
        document.querySelector("input[type='number']").addEventListener("wheel", function(e) {
            e.preventDefault();
        });

        document.querySelector("input[type='number']").addEventListener("keydown", function(e) {
            // Prevent default behavior for arrow up and arrow down keys
            if (e.key === "ArrowUp" || e.key === "ArrowDown") {
                e.preventDefault();
            }
        });


    });
</script>

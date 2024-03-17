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


    <script src="{{ asset('assets/js/invoice/purchase.js') }}"></script>

@endsection

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
                            <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}, {{ $customer->address }}
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
                                        <input type="text" class="form-control" disabled placeholder="3905"
                                            value="3905" id="invoiceId" />
                                    </div>
                                </dd>
                                <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                                    <span class="fw-normal">Date:</span>
                                </dt>
                                <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                                    <input type="text" class="form-control w-px-150 date-picker"
                                        placeholder="YYYY-MM-DD" />
                                </dd>
                            </dl>
                        </div>
                    </div>


                    <hr class="my-3 mx-n4" />

                    <form class="source-item pt-4 px-0 px-sm-4">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Product Details</h5>
                                <div class="card-body">
                                    <form class="form-repeater">
                                        <div data-repeater-list="group-a">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-4">Product</label>
                                                        <select id="form-repeater-1-4" class="form-select">
                                                            <option value="Designer">Designer</option>
                                                            <option value="Developer">Developer</option>
                                                            <option value="Tester">Tester</option>
                                                            <option value="Manager">Manager</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-1">Bags</label>
                                                        <input type="number" id="form-repeater-1-1" class="form-control"
                                                            placeholder="0" />
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-1">Weight</label>
                                                        <input type="number" id="form-repeater-1-1" class="form-control"
                                                            placeholder="0" />
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-1">Rate</label>
                                                        <input type="number" id="form-repeater-1-1" class="form-control"
                                                            placeholder="0" />
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-1">Total
                                                            Amount</label>
                                                        <input type="number" id="form-repeater-1-1" class="form-control"
                                                            placeholder="0" />
                                                    </div>
                                                    <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-4">Bags
                                                            Owner</label>
                                                        <select id="form-repeater-1-4" class="form-select">
                                                            <option value="Designer">Self</option>
                                                            <option value="Developer">Client</option>
                                                        </select>
                                                    </div>
                                                    <div
                                                        class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                        <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                            <i class="ti ti-x ti-xs me-1"></i>
                                                            <span class="align-middle">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <button class="btn btn-primary" data-repeater-create>
                                                <i class="ti ti-plus me-1"></i>
                                                <span class="align-middle">Add</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr class="my-3 mx-n4" />

                    <form class="source-item pt-4 px-0 px-sm-4">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Other Details</h5>
                                <div class="card-body">
                                    <form class="form-repeater">
                                        <div data-repeater-list="group-a">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="mb-3 col-lg-3 col-xl-3 col-12 mb-0">
                                                        <label class="form-label"
                                                            for="form-repeater-1-1">Description</label>
                                                        <input type="text" id="form-repeater-1-1" class="form-control"
                                                            placeholder="write here...." />
                                                    </div>
                                                    <div class="mb-3 col-lg-3 col-xl-3 col-12 mb-0">
                                                        <label class="form-label" for="form-repeater-1-1">Amount</label>
                                                        <input type="number" id="form-repeater-1-1" class="form-control"
                                                            placeholder="0" />
                                                    </div>
                                                    <div class="mb-3 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <div class="text-light small fw-medium mb-3">Type</div>
                                                        <div class="switches-stacked">
                                                            <label class="switch switch-square">
                                                                <input type="radio" class="switch-input"
                                                                    name="switches-square-stacked-radio" checked />
                                                                <span class="switch-toggle-slider">
                                                                    <span class="switch-on"></span>
                                                                    <span class="switch-off"></span>
                                                                </span>
                                                                <span class="switch-label">Deduct</span>
                                                            </label>
                                                            <label class="switch switch-square">
                                                                <input type="radio" class="switch-input"
                                                                    name="switches-square-stacked-radio" />
                                                                <span class="switch-toggle-slider">
                                                                    <span class="switch-on"></span>
                                                                    <span class="switch-off"></span>
                                                                </span>
                                                                <span class="switch-label">Add</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                        <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                            <i class="ti ti-x ti-xs me-1"></i>
                                                            <span class="align-middle">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <button class="btn btn-primary" data-repeater-create>
                                                <i class="ti ti-plus me-1"></i>
                                                <span class="align-middle">Add</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr class="my-3 mx-n4" />

                    <div class="row p-0 p-sm-4">
                        <div class="col-md-10 mb-md-0 mb-3">
                            <div class="row p-0 p-sm-4">
                                <div class="col-md-4 mb-4">
                                    <label for="labourcategory" class="form-label">Labour Category</label>
                                    <select id="labourcategory" class="selectpicker w-100" data-style="btn-default">
                                        <option>Self</option>
                                        <option>Client</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-4" id="client_labour_block" style="display: none">
                                    <label for="client_labour_amount" class="form-label">Client Labour Amount</label>
                                    <input class="form-control" placeholder="Enter  Amount Give to Client labour..."
                                        type="text" value="" tabindex="0" id="client_labour_amount">
                                </div>
                                <div class="col-md-4 mb-4" id="labourAccountSelectBox" style="display: block">
                                    <label for="selectpickerLabourAccount" class="form-label">Labour Account</label>
                                    <select id="selectpickerLabourAccount" class="selectpicker w-100"
                                        data-style="btn-default">
                                        <option>Mansha</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-4" id="labour_block" style="display: block">
                                    <label for="labour_amount" class="form-label">Labour Amount</label>
                                    <input class="form-control" placeholder="Enter  Amount Give to  labour..."
                                        type="text" value="" tabindex="0" id="labour_amount">

                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="logistics" class="form-label">Logistics</label>
                                    <select id="logistics" class="selectpicker w-100" data-style="btn-default">
                                        <option>Own</option>
                                        <option>Rent</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-4" id="client_labour_block" style="display: none">
                                    <label for="client_logistics" class="form-label">Client Logistics Rent</label>
                                    <input class="form-control" placeholder="Enter Amount Logistics Rent" type="text"
                                        value="" tabindex="0" id="client_logistics">
                                </div>
                                <div class="col-md-4 mb-4" id="labourAccountSelectBox" style="display: block">
                                    <label for="selectpickerLabourAccount" class="form-label">Vehicle Number</label>
                                    <select id="selectpickerLabourAccount" class="selectpicker w-100"
                                        data-style="btn-default">
                                        <option>Mansha</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-4" id="labour_block" style="display: block">
                                    <label for="labour_amount" class="form-label">Driver Name</label>
                                    <input class="form-control" placeholder="Enter  Driver name..." type="text"
                                        value="" tabindex="0" id="labour_amount">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-end">
                            <div class="invoice-calculations">
                                <div class="d-flex justify-content-between mb-2">
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
                                </div>
                                <hr />
                                <div class="d-flex justify-content-between">
                                    <span class="w-px-100">Total:</span>
                                    <span class="fw-medium">$00.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 mx-n4" />
                </div>
            </div>
        </div>
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

        $('#labourcategory').change(function() {
            // Get the selected value
            var labourAccountSelect = document.getElementById('labourAccountSelectBox');
            var selectedValue = $(this).val();
            if (selectedValue === 'Self') {
                console.log(selectedValue);
                $("#labourAccountSelectBox").css("display", "block");
                $("#labour_block").css("display", "block");
                $("#client_labour_block").css("display", "none");

            } else {
                $("#labourAccountSelectBox").css("display", "none");
                $("#labour_block").css("display", "none");
                $("#client_labour_block").css("display", "block");

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

    });
</script>

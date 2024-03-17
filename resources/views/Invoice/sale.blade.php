@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Sale')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/offcanvas-send-invoice.js')}}"></script>
<script src="{{asset('assets/js/app-invoice-add.js')}}"></script>
<script src="{{asset('assets/js/forms-selects.js')}}"></script>
<script src="{{asset('assets/js/forms-tagify.js')}}"></script>
<script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
@endsection

@section('content')
<div class="row invoice-add">
  <!-- Invoice Add-->
  <div class="modal-onboarding modal fade animate__animated" id="onboardHorizontalImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content text-center">
        <div class="modal-body onboarding-horizontal p-0">
          {{-- <div class="onboarding-media">
            <img src="{{asset('assets/img/illustrations/boy-verify-email-'.$configData['style'].'.png')}}" alt="boy-verify-email-light" width="273" class="img-fluid" data-app-light-img="illustrations/boy-verify-email-light.png" data-app-dark-img="illustrations/boy-verify-email-dark.png">
          </div> --}}
          <div class="onboarding-content mb-0">
            <h4 class="onboarding-title text-body">New Custoomer details</h4>
            <form>
              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label for="nameEx7" class="form-label">Name</label>
                    <input class="form-control" placeholder="Enter  full name..." type="text" value="" tabindex="0" id="nameEx7">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label for="nameEx7" class="form-label">Contact</label>
                    <input class="form-control" placeholder="Enter contact number..." type="text" value="" tabindex="0" id="nameEx7">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="mb-3">
                    <label for="nameEx7" class="form-label">Address</label>
                    <input class="form-control" placeholder="Enter  full address..." type="text" value="" tabindex="0" id="nameEx7">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer border-1">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-12 mb-lg-0 mb-4">
    <div class="card invoice-preview-card">
      <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#onboardHorizontalImageModal">
          Add New Custome
        </button>
        <hr class="my-3 mx-n4" />

        <div class="row p-sm-4 p-0">
          <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-4">
            <h6 class="mb-4">Invoice To:</h6>
              <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
                <option value="AK">Alaska</option>
                <option value="HI">Hawaii</option>
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
                  <input type="text" class="form-control" disabled placeholder="3905" value="3905" id="invoiceId" />
                </div>
              </dd>
              <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                <span class="fw-normal">Date:</span>
              </dt>
              <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                <input type="text" class="form-control w-px-150 date-picker" placeholder="YYYY-MM-DD" />
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
                          <input type="number" id="form-repeater-1-1" class="form-control" placeholder="0" />
                        </div>
                        <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                          <label class="form-label" for="form-repeater-1-1">Weight</label>
                          <input type="number" id="form-repeater-1-1" class="form-control" placeholder="0" />
                        </div>
                        <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                          <label class="form-label" for="form-repeater-1-1">Rate</label>
                          <input type="number" id="form-repeater-1-1" class="form-control" placeholder="0" />
                        </div>
                        <div class="mb-3 col-lg-6 col-xl-2 col-12 mb-0">
                          <label class="form-label" for="form-repeater-1-1">Total Amount</label>
                          <input type="number" id="form-repeater-1-1" class="form-control" placeholder="0" />
                        </div>
                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                          <label class="form-label" for="form-repeater-1-4">Bags Owner</label>
                          <select id="form-repeater-1-4" class="form-select">
                            <option value="Designer">Self</option>
                            <option value="Developer">Client</option>
                          </select>
                        </div>
                        <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
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
          <div class="col-md-6 mb-md-0 mb-3">
            <div class="row p-0 p-sm-4">
            <div class="col-md-6 mb-4">
              <label for="selectpickerBasic" class="form-label">Labour Category</label>
              <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                <option>Self</option>
                <option>Client</option>
              </select>
            </div>
            <div class="col-md-6 mb-4">
              <label for="selectpickerBasic" class="form-label">Labour Account</label>
              <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                <option>Mansha</option>
                <option>Other</option>
              </select>
              
            </div>
            <div class="col-md-6 mb-4">
              <label for="selectpickerBasic" class="form-label">Logistics</label>
              <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                <option>Self</option>
                <option>Client</option>
              </select>
            </div>
            <div class="col-md-6 mb-4">
              <label for="selectpickerBasic" class="form-label">Vehicles Details</label>
              <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                <option>Le 1253</option>
                <option>Ok 1258</option>
              </select>
            </div>
            </div>

          </div>
          <div class="col-md-6 d-flex justify-content-end">
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

  <!-- Invoice Actions -->
  {{-- <div class="col-lg-2 col-12 invoice-actions">
    <div class="card mb-4">
      <div class="card-body">
        <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Send Invoice</span>
        </button>
        <a href="{{url('app/invoice/preview')}}" class="btn btn-label-secondary d-grid w-100 mb-2">Preview</a>
        <button type="button" class="btn btn-label-secondary d-grid w-100">Save</button>
      </div>
    </div>
    <div>
      <p class="mb-2">Accept payments via</p>
      <select class="form-select mb-4">
        <option value="Bank Account">Bank Account</option>
        <option value="Paypal">Paypal</option>
        <option value="Card">Credit/Debit Card</option>
        <option value="UPI Transfer">UPI Transfer</option>
      </select>
      <div class="d-flex justify-content-between mb-2">
        <label for="payment-terms" class="mb-0">Payment Terms</label>
        <label class="switch switch-primary me-0">
          <input type="checkbox" class="switch-input" id="payment-terms" checked />
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"></span>
        </label>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <label for="client-notes" class="mb-0">Client Notes</label>
        <label class="switch switch-primary me-0">
          <input type="checkbox" class="switch-input" id="client-notes" />
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"></span>
        </label>
      </div>
      <div class="d-flex justify-content-between">
        <label for="payment-stub" class="mb-0">Payment Stub</label>
        <label class="switch switch-primary me-0">
          <input type="checkbox" class="switch-input" id="payment-stub" />
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"></span>
        </label>
      </div>
    </div>
  </div> --}}
  <!-- /Invoice Actions -->
</div>

<!-- Offcanvas -->
@include('_partials/_offcanvas/offcanvas-send-invoice')
<!-- /Offcanvas -->
@endsection

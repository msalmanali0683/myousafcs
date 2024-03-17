@extends('layouts/layoutMaster')
@section('title', 'New Customer')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/app-ecommerce-customer-all.js')}}"></script>
@endsection

@section('content')

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <!-- FormValidation -->
  <div class="col-12">
    <div class="card">
     <div class="card-body">

        <form id="newCustomerform" class="row g-3">
          @csrf
          <!-- Account Details -->

          <div class="col-12">
            <h6>New Customers</h6>
            <hr class="mt-0" />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="formValidationName">Full Name</label>
            <input type="text" id="formValidationName" class="form-control" placeholder="Enter full name........." name="formValidationName" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" class="form-control" placeholder="Enter Mobile number ..............." name="contact_number" />
          </div>
          <div class="col-md-12">
            <label class="form-label" for="address">Address</label>
            <input type="text" id="address" class="form-control" placeholder="Enter complete address" name="address" />
          </div>
         
          <div class="col-4 offset-4">
            <button type="submit" name="submitButton" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
  
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
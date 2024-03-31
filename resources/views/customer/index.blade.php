@extends('layouts/layoutMaster')
@section('title', 'All Customers')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-ecommerce-customer-all.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('#DataTables_Table_0_filter input');
            const tableRows = document.querySelectorAll('.datatables-customers tbody tr');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim().toLowerCase();

                tableRows.forEach(function(row) {
                    const name = row.querySelector('td:nth-child(2)').textContent.trim()
                        .toLowerCase();
                    const contact = row.querySelector('td:nth-child(3)').textContent.trim()
                        .toLowerCase();
                    const address = row.querySelector('td:nth-child(4)').textContent.trim()
                        .toLowerCase();

                    if (name.includes(searchTerm) || contact.includes(searchTerm) || address
                        .includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light"> </span> All Customers
    </h4>

    <!-- customers List Table -->
    <div class="card">

        <div class="card-datatable table-responsive">
            <div class="card-header d-flex border-top rounded-0 flex-wrap">
                {{-- <div class="me-5 ms-n2 pe-5"> --}}
                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input type="search"
                            class="form-control" placeholder="Search Customer" aria-controls="DataTables_Table_0"></label>
                </div>
                {{-- </div> --}}
            </div>
            <table class="datatables-customers table border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td class="text-nowrap">{{ $customer->name }}</td>
                            <td>{{ $customer->contact }}</td>
                            <td>{{ $customer->address }}</td>
                            <td class="text-nowrap">1235467820 Cr</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('customer.edit', $customer->id) }}"><i
                                                class="ti ti-pencil me-1"></i>Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-trash me-1"></i>Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination justify-content-center">
                {{-- {{ $customers->links() }} --}}
            </div>
        </div>
    </div>
@endsection

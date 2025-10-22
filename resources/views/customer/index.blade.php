@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Search Card -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('customer.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search by Name</label>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Enter customer name...">
                    </div>
                    <div class="col-md-4">
                        <label for="search_email" class="form-label">Search by Email</label>
                        <input type="email" class="form-control form-sm" id="search_email" name="search_email"
                            value="{{ request('search_email') }}" placeholder="Enter customer email...">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <!-- Hidden inputs to maintain other parameters -->
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>

                            @if (request('search') || request('search_email'))
                                <a href="{{ route('customer.index') }}?per_page={{ request('per_page', 10) }}"
                                    class="btn btn-outline-secondary">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer List Card -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Customers</h6>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="perPageSelect" style="width: auto;">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 per page</option>
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    </select>
                    <button class="btn btn-sm btn-primary" id="addCustomerBtn">+ Add</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="customerTableBody">
                        @forelse ($customers as $i => $c)
                            <tr data-id="{{ $c->id }}">
                                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td class="name">{{ $c->name }}</td>
                                <td class="email">{{ $c->email }}</td>
                                <td class="phone">{{ $c->phone }}</td>
                                <td class="address">{{ $c->address }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning editCustomer">Edit</button>
                                    <button class="btn btn-sm btn-danger deleteCustomer">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    @if (request('search') || request('search_email'))
                                        <i class="fas fa-search fa-2x mb-2"></i>
                                        <br>No customers found matching your search criteria
                                        <br>
                                        <small>Try different keywords or <a
                                                href="{{ route('customer.index') }}?per_page={{ request('per_page', 10) }}">clear
                                                filters</a></small>
                                    @else
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <br>No customers found
                                        <br>
                                        <small>Start by adding your first customer</small>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Info and Links -->
                @if ($customers->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of
                            {{ $customers->total() }} results
                        </div>
                        <div>
                            {{ $customers->links('pagination.custom') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @include('components.modal_customer')
        @include('components.modal_delete')
        @include('components.toast_message')

    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Pure jQuery Modal - No Bootstrap Modal API to avoid conflicts

            // Enable modal close on ESC key and backdrop click
            $(document).on('keyup', function(e) {
                if (e.key === 'Escape') {
                    $('.modal.show').modal('hide');
                }
            });

            // Close modal when clicking backdrop
            $('.modal').on('click', function(e) {
                if (e.target === this) {
                    $(this).modal('hide');
                }
            });

            $('#addCustomerBtn').click(function() {
                $('#customerForm').trigger('reset');
                $('#customer_id').val('');
                $('#customerModal').modal('show');
            });

            $('#customerForm').submit(function(e) {
                e.preventDefault();

                var $form = $(this);
                var id = $('#customer_id').val();
                var formData = $form.serialize();

                if (id) {
                    // Update existing customer
                    $.ajax({
                            url: '/customer/' + id,
                            type: 'PUT',
                            data: formData
                        })
                        .done(function() {
                            $('#customerModal').modal('hide');
                            location.reload();
                        })
                        .fail(function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        });
                } else {
                    // Create new customer
                    $.post('/customer', formData)
                        .done(function() {
                            $('#customerModal').modal('hide');
                            location.reload();
                        })
                        .fail(function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        });
                }
            });

            // Edit Customer - Event delegation with jQuery modal
            $(document).on('click', '.editCustomer', function() {
                var customerId = $(this).closest('tr').data('id');
                var $btn = $(this);

                // Disable button and show loading
                $btn.prop('disabled', true).text('Loading...');

                // Load customer data using jQuery
                $.get('/customer/' + customerId)
                    .done(function(response) {
                        var customer = response.customer;
                        $('#customer_id').val(customer.id);
                        $('#name').val(customer.name);
                        $('#email').val(customer.email);
                        $('#phone').val(customer.phone || '');
                        $('#address').val(customer.address || '');
                        $('#customerModal').modal('show'); // jQuery modal
                    })
                    .fail(function() {
                        alert('Failed to load customer data');
                    })
                    .always(function() {
                        $btn.prop('disabled', false).text('Edit');
                    });
            });

            // Delete Customer - Event delegation 
            var deleteId = null;
            $(document).on('click', '.deleteCustomer', function() {
                deleteId = $(this).closest('tr').data('id');
                $('#confirmDeleteModal').modal('show');
            });

            $('#btnConfirmDelete').click(function() {
                if (!deleteId) return;

                $.ajax({
                        url: '/customer/' + deleteId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        }
                    })
                    .done(function() {
                        $('#confirmDeleteModal').modal('hide');
                        location.reload();
                    })
                    .fail(function() {
                        $('#confirmDeleteModal').modal('hide');
                        alert('Failed to delete customer');
                    });
            });

            // Handle per page change
            $('#perPageSelect').change(function() {
                const perPage = $(this).val();
                const $select = $(this);

                // Show loading state
                $select.prop('disabled', true);

                const url = new URL(window.location);
                url.searchParams.set('per_page', perPage);
                url.searchParams.delete('page'); // Reset to first page
                window.location.href = url.toString();
            });
        });
    </script>
@endsection

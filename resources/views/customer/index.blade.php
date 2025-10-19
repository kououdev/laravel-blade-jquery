@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Customer List</h5>
            <button class="btn btn-sm btn-primary" id="addCustomerBtn">+ Add Customer</button>
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
                    @foreach ($customers as $i => $c)
                        <tr data-id="{{ $c->id }}">
                            <td>{{ $i + 1 }}</td>
                            <td class="name">{{ $c->name }}</td>
                            <td class="email">{{ $c->email }}</td>
                            <td class="phone">{{ $c->phone }}</td>
                            <td class="address">{{ $c->address }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning editCustomer">Edit</button>
                                <button class="btn btn-sm btn-danger deleteCustomer">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('components.modal_customer')
    @include('components.modal_delete')
    @include('components.toast_message')
@endsection

@section('scripts')
    <script>
        $(function() {
            const modal = new bootstrap.Modal('#customerModal');

            $('#addCustomerBtn').click(function() {
                $('#customerForm')[0].reset();
                $('#customer_id').val('');
                modal.show();
            });

            $('#customerForm').submit(function(e) {
                e.preventDefault();

                const id = $('#customer_id').val();
                const url = id ? `/customer/${id}` : '/customer';
                const method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        address: $('#address').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            $('.editCustomer').click(function() {
                const id = $(this).closest('tr').data('id');
                const $btn = $(this);

                // disable button Edit dan kasih teks Loading di button
                // agar mencegah multiple klik
                $btn.prop('disabled', true).text('Loading...');

                // ambil data customer dari API / DB
                $.ajax({
                    url: `/customer/${id}`,
                    method: 'GET',
                    success: function(response) {
                        const customer = response.customer;
                        $('#customer_id').val(customer.id);
                        $('#name').val(customer.name);
                        $('#email').val(customer.email);
                        $('#phone').val(customer.phone || '');
                        $('#address').val(customer.address || '');
                        modal.show();
                    },
                    error: function() {
                        showToast('Failed to load customer data.', 'danger');
                    },
                    complete: function() {
                        // enable button Edit dan berikan text sebelumnya
                        $btn.prop('disabled', false).text('Edit');
                    }
                });
            });

            let deleteId = null;
            $('.deleteCustomer').click(function() {
                deleteId = $(this).closest('tr').data('id');
                $('#confirmDeleteModal').modal('show');
            });

            $('#btnConfirmDelete').click(function() {
                if (!deleteId) return;

                $.ajax({
                    url: `/customer/${deleteId}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $('#confirmDeleteModal').modal('hide');
                        location.reload();
                        showToast('Data berhasil dihapus.', 'success');
                    },
                    error: function() {
                        $('#confirmDeleteModal').modal('hide');
                        showToast('Gagal menghapus data.', 'danger');
                    }
                });
            });
        });
    </script>
@endsection

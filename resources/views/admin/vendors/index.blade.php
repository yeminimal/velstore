@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center">
            <h6>{{ __('cms.vendors.title_list') }}</h6>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table id="vendors-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('cms.vendors.id') }}</th>
                        <th>{{ __('cms.vendors.name') }}</th>
                        <th>{{ __('cms.vendors.email') }}</th>
                        <th>{{ __('cms.vendors.phone') }}</th>
                        <th>{{ __('cms.vendors.status') }}</th>
                        <th>{{ __('cms.vendors.actions') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Vendor Modal -->
<div class="modal fade" id="deleteVendorModal" tabindex="-1" aria-labelledby="deleteVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('cms.vendors.modal_confirm_delete_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{{ __('cms.vendors.modal_confirm_delete_body') }}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.vendors.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteVendor">{{ __('cms.vendors.delete') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@php
    $datatableLang = __('cms.datatables'); 
@endphp

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.vendors.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    var vendorsTable = $('#vendors-table').DataTable({
        processing: true,
        serverSide: true,
        language: @json($datatableLang),
        ajax: {
            url: "{{ route('admin.vendors.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { 
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data === 'active' 
                        ? '<span class="badge bg-success">{{ __('cms.vendors.active') }}</span>' 
                        : '<span class="badge bg-danger">{{ __('cms.vendors.Inactive') }}Inactive</span>';
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    var vendorToDeleteId = null;

    window.deleteVendor = function(id) {
        vendorToDeleteId = id;
        $('#deleteVendorModal').modal('show');
    };

    $('#confirmDeleteVendor').on('click', function() {
        var $btn = $(this);
        $btn.prop('disabled', true);

        $.ajax({
            url: '{{ route('admin.vendors.destroy', ':id') }}'.replace(':id', vendorToDeleteId),
            method: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                $('#vendors-table').DataTable().ajax.reload();
                toastr.error(response.message, "{{ __('cms.vendors.success') }}", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                $('#deleteVendorModal').modal('hide');
                vendorToDeleteId = null;
            },
            error: function() {
                toastr.error("{{ __('cms.vendors.error_delete') }}", "{{ __('cms.vendors.error') }}", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                $('#deleteVendorModal').modal('hide');
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection


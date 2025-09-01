@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">  
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">Payment Gateway Configs</h6>
    </div>

    <div class="card-body">
        <table id="configs-table" class="table table-bordered mt-4 dt-style">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gateway</th>
                    <th>Key Name</th>
                    <th>Key Value</th>
                    <th>Environment</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteConfigModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Are you sure you want to delete this config?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteConfig">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#configs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payment_gateway_configs.getData') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'gateway_name', name: 'gateway.name' },
            { data: 'key_name', name: 'key_name' },
            { data: 'key_value', name: 'key_value', orderable: false, searchable: false },
            { data: 'environment', name: 'environment' },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editBtn = '<span class="border border-edit dt-trash rounded-3 d-inline-block">' +
                                    '<a href="/admin/payment_gateway_configs/' + row.id + '/edit">' +
                                        '<i class="bi bi-pencil-fill pencil-edit-color"></i>' +
                                    '</a>' +
                                '</span>';

                    var deleteBtn = '<span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteConfig(' + row.id + ')">' +
                                        '<i class="bi bi-trash-fill text-danger"></i>' +
                                    '</span>';

                    return editBtn + ' ' + deleteBtn;
                }
            }
        ],
        pageLength: 10
    });
});

let configToDeleteId = null;

function deleteConfig(id) {
    configToDeleteId = id;        
    $('#deleteConfigModal').modal('show');

    $('#confirmDeleteConfig').off('click').on('click', function() {
        if (configToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.payment_gateway_configs.destroy', ':id') }}'.replace(':id', configToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#configs-table').DataTable().ajax.reload();

                        toastr.error(response.message, "Deleted", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteConfigModal').modal('hide');
                    }
                },
                error: function() {
                    alert('Error deleting config!');
                    $('#deleteConfigModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection

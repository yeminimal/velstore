@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">  
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">Payment Gateways</h6>
    </div>

    <div class="card-body">
        <table id="gateways-table" class="table table-bordered mt-4 dt-style">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteGatewayModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Are you sure you want to delete this payment gateway?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteGateway">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#gateways-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payment-gateways.getData') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'status', name: 'is_active', orderable: false, searchable: false },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editBtn = '<span class="border border-edit dt-trash rounded-3 d-inline-block">' +
                                    '<a href="/admin/payment-gateways/' + row.id + '/edit">' +
                                        '<i class="bi bi-pencil-fill pencil-edit-color"></i>' +
                                    '</a>' +
                                '</span>';

                    var deleteBtn = '<span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteGateway(' + row.id + ')">' +
                                        '<i class="bi bi-trash-fill text-danger"></i>' +
                                    '</span>';

                    return editBtn + ' ' + deleteBtn;
                }
            }
        ],
        pageLength: 10
    });
});

let gatewayToDeleteId = null;

function deleteGateway(id) {
    gatewayToDeleteId = id;        
    $('#deleteGatewayModal').modal('show');

    $('#confirmDeleteGateway').off('click').on('click', function() {
        if (gatewayToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.payment-gateways.destroy', ':id') }}'.replace(':id', gatewayToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#gateways-table').DataTable().ajax.reload();

                        toastr.error(response.message, "Deleted", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteGatewayModal').modal('hide');
                    }
                },
                error: function() {
                    alert('Error deleting payment gateway!');
                    $('#deleteGatewayModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection

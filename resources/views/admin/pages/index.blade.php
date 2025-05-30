@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white">
            <h6 class="mb-0">Pages</h6>
        </div>
        <div class="card-body">
            <table id="pagesTable" class="table table-bordered mt-4 dt-style">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Delete Page Modal -->
    <div class="modal fade" id="deletePageModal" tabindex="-1" aria-labelledby="deletePageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to delete this page?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePage">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}", "Success", {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 5000
            });
        </script>
    @endif

    <script>
        let pageToDeleteId = null;

        $(document).ready(function() {
            $('#pagesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pages.data') }}",
                    type: 'POST',
                    data: { _token: "{{ csrf_token() }}" }
                },
                columns: [
                    { data: 'translated_title', name: 'translated_title' },
                    { data: 'slug', name: 'slug' },
                    { data: 'status', name: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                pageLength: 10
            });
        });

        function deletePage(id) {
            pageToDeleteId = id;
            $('#deletePageModal').modal('show');

            $('#confirmDeletePage').off('click').on('click', function() {
                $.ajax({
                    url: '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageToDeleteId),
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $('#pagesTable').DataTable().ajax.reload();
                        $('#deletePageModal').modal('hide');
                        toastr.success(response.message || 'Deleted successfully');
                    },
                    error: function() {
                        toastr.error('Error deleting page');
                        $('#deletePageModal').modal('hide');
                    }
                });
            });
        }
    </script>
@endsection

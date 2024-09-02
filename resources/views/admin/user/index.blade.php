@extends('layouts.app')
@section('content')
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ $title }}</h4>
          </div>

          <div class="px-4 py-3 border-bottom">
              <div class="row">
                  {{-- @can(['create_nasabah']) --}}
                  <div class="col text-end d-flex justify-content-end">
                      <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center">
                        Tambah {{ $title }}
                      </a>
                  </div>
                  {{-- @endcan --}}
              </div>
          </div>

          <div class="card-body">
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="table_yajra">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th><input class="form-control" type="text" id="name-filter" placeholder="Search by Name ..."></th>
                    <th><input class="form-control" type="text" id="email-filter" placeholder="Search by Email ..."></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Zero Configuration  Ends-->
    </div>
  </div>
  <!-- Container-fluid Ends-->

<div style="height: 10px"></div>
@endsection

@push ('after-scripts')
    <script>
        var table = $('#table_yajra').DataTable({
            "scrollX": true,
            processing: true,
            serverSide: true,
            autoWidth: true,
            orderCellsTop: true,
            fixedHeader: true,
            sDom: 'lrtip',
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            pageLength: 5,
            ajax: {
                "url": "{{ route('users.datatable') }}",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"},
            },
            columns: [
            {
                data: 'DT_RowIndex',
                orderable: false
            },
            {
                data: 'name'
            },
            {
                data: 'email'
            },
            {
                data: 'role'
            },
            {
                data: 'action'
            }
            ],
            order: [
                [1, 'desc']
            ],
            'columnDefs': [
              {
                  "targets": 0,
                  "bSortable": false
              },
              {
                  "targets": 3,
                  "bSortable": false
              },
              {
                  "targets": 4,
                  "width": 90,
                  "bSortable": false
              },
            ]
        });

        var typingTimer;
        $('#name-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(1).search($('#name-filter').val()).draw();
            }, 500);
        });
        $('#email-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(2).search($('#email-filter').val()).draw();
            }, 500);
        });

        function destroy(uuid) {
            var url = "{{ route('users.destroy', ':uuid') }}".replace(':uuid', uuid);
            callDataWithAjax(url, 'POST', {
                _method: "DELETE"
            }).then((data) => {
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            }).catch((xhr) => {
                alert('Error: ' + xhr.responseText);
            })
        }
    </script>
@endpush

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
                      <a href="{{ route('lapdu.create') }}" class="btn btn-primary d-flex align-items-center">
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
                    <th>NO</th>
                    <th>SATUAN KERJA</th>
                    <th>NAMA PENGIRIM LAPDU</th>
                    <th>KASUS POSISI</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th style="padding-top: 30px;">
                        <select class="form-control select2" id="satuan-filter">
                            <option value="">Pilih Satuan Kerja</option>
                            @foreach ($satuans as $satuan_kerja)
                            <option value="{{ $satuan_kerja->id }}">{{ $satuan_kerja->name }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th><input class="form-control" type="text" id="name-filter" placeholder="Search by Name ..."></th>
                    <th><input class="form-control" type="text" id="kasus-filter" placeholder="Search by Kasus ..."></th>
                    <th><input class="form-control" type="text" id="status-filter" placeholder="Search by Status ..."></th>
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
                "url": "{{ route('lapdu.datatable') }}",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"},
            },
            columns: [
            {
                data: 'DT_RowIndex',
                orderable: false
            },
            {
                data: 'satuan'
            },
            {
                data: 'sender_name'
            },
            {
                data: 'kasus_posisi'
            },
            {
                data: 'status'
            },
            {
                data: 'action'
            }
            ],
            order: [
                [2, 'desc']
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
        $('#kasus-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(2).search($('#kasus-filter').val()).draw();
            }, 500);
        });
        $('#status-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(3).search($('#status-filter').val()).draw();
            }, 500);
        });
        $('#satuan-filter').on('change', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(1).search($('#satuan-filter').val()).draw();
            }, 500);
        });

        function destroy(uuid) {
            var url = "{{ route('lapdu.destroy', ':uuid') }}".replace(':uuid', uuid);
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

        function approveData(uuid) {
            Swal.fire({
                title: 'Approve Data?',
                text: 'Data Memenuhi Syarat PP No. 43 Tahun 2018!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(uuid, "approve");
                }
            });
        }

        function rejectData(uuid) {
            Swal.fire({
                title: 'Reject Data?',
                text: 'Data Tidak Memenuhi Syarat PP No. 43 Tahun 2018!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(uuid, "reject");
                }
            });
        }

        function updateStatus(uuid, status) {
            var url = "{{ route('lapdu.update-status', ':uuid') }}".replace(':uuid', uuid);
            callDataWithAjax(url, 'POST', {
                status: status
            }).then((data) => {
                Swal.fire(
                    'Berhasil!',
                    'Your data has been updated.',
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

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
                      <a href="{{ route('penyelidikan.create') }}" class="btn btn-primary d-flex align-items-center">
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
                    <th>NAMA</th>
                    <th>NO SP-LID</th>
                    <th>TANGGAL SP-LID</th>
                    <th>File P-2</th>
                    <th>JENIS PERKARA</th>
                    <th>TAHAPAN PENANGANAN </th>
                    <th>STATUS</th>
                    <th>CREATED AT</th>
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
                    <th><input class="form-control" type="text" id="name-filter" placeholder="Search by Kasus ..."></th>
                    <th><input class="form-control" type="text" id="no-sp-filter" placeholder="Search by Status ..."></th>
                    <th><input class="form-control" id="range-date" type="date"></th>
                    <th></th>
                    <th><input class="form-control" type="text" id="jenis-perkara-filter" placeholder="Search by Status ..."></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-body">
              <div class="card-title">
                  <h5>Petunjuk:</h5>
              </div>
              <div class="row">
                  <div class="col-12">
                    <a class="edit"><i class="fa fa-pencil-square-o"></i></a>
                    Edit
                  </div>
                  <div class="col-12">
                    <a class="edit"><i class="fa fa-eye"></i></a>
                    Detail
                  </div>
                  <div class="col-12">
                    <a class="edit"><i class="fa fa-trash"></i></a>
                    Delete
                  </div>
                  <div class="col-12">
                    <a class="edit"><i class="fa fa-step-forward"></i></a>
                    Pengajuan Penyidikan
                  </div>
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
            // "scrollX": true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            orderCellsTop: true,
            fixedHeader: true,
            sDom: 'lrtip',
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            pageLength: 5,
            ajax: {
                "url": "{{ route('penyelidikan.datatable') }}",
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
                    data: 'name'
                },
                {
                    data: 'no_sp'
                },
                {
                    data: 'date_sp'
                },
                {
                    data: 'p2'
                },
                {
                    data: 'jenis_perkara'
                },
                {
                    data: 'tahapan'
                },
                {
                    data: 'status'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'action'
                }
            ],
            order: [
                [9, 'desc']
            ],
        });

        var typingTimer;
        // by typing
        $('#name-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(2).search($('#name-filter').val()).draw();
            }, 500);
        });
        $('#no-sp-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(3).search($('#no-sp-filter').val()).draw();
            }, 500);
        });
        $('#kasus-posisi-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(7).search($('#kasus-posisi-filter').val()).draw();
            }, 500);
        });
        $('#keterangan-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(9).search($('#keterangan-filter').val()).draw();
            }, 500);
        });
        $('#satuan-filter').on('change', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(1).search($('#satuan-filter').val()).draw();
            }, 500);
        });
        $('#range-date').on('change', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(4).search($('#range-date').val()).draw();
            }, 500);
        });

        function destroy(uuid) {
            var url = "{{ route('penyelidikan.destroy', ':uuid') }}".replace(':uuid', uuid);
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

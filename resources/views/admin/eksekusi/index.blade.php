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

          <div class="card-body">
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="table_yajra">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>SATUAN KERJA</th>
                    <th>NAMA TERSANGKA/TERDAKWA</th>
                    <th>ASAL PERKARA</th>
                    <th>P-2</th>
                    <th>PIDSUS 7</th>
                    <th>PIDSUS 8</th>
                    <th>TAP TERSANGKA</th>
                    <th>P-16</th>
                    <th>P-21</th>
                    <th>SURAT DARI AUDITOR</th>
                    <th>PUTUSAN</th>
                    <th>D-4</th>
                    <th>P-48</th>
                    <th>P-48A</th>
                    <th>PIDANA BADAN</th>
                    <th>DENDA</th>
                    <th>UANG PENGGANTI</th>
                    <th>BARANG BUKTI</th>
                    <th>TAHAPAN PENANGANAN </th>
                    <th>KETERANGAN </th>
                    <th>STATUS </th>
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
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
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
            // autoWidth: false,
            orderCellsTop: true,
            // fixedHeader: true,
            sDom: 'lrtip',
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            pageLength: 5,
            ajax: {
                "url": "{{ route('eksekusi.datatable') }}",
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
                    data: 'asal_perkara'
                },
                {
                    data: 'p2'
                },
                {
                    data: 'pidsus7'
                },
                {
                    data: 'p8'
                },
                {
                    data: 'tap_tersangka'
                },
                {
                    data: 'p16'
                },
                {
                    data: 'p21'
                },
                {
                    data: 'surat_auditor'
                },
                {
                    data: 'putusan'
                },
                {
                    data: 'd4'
                },
                {
                    data: 'p48'
                },
                {
                    data: 'p48a'
                },
                {
                    data: 'pidana_badan'
                },
                {
                    data: 'denda'
                },
                {
                    data: 'uang_pengganti'
                },
                {
                    data: 'barang_bukti'
                },
                {
                    data: 'tahapan_penanganan'
                },
                {
                    data: 'keterangan'
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
                [22, 'desc']
            ],
            'columnDefs': [
              {
                  "targets": [0,5,12],
                  "bSortable": false
              },
            ]
        });

        var typingTimer;
        // by typing
        $('#name-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(2).search($('#name-filter').val()).draw();
            }, 500);
        });
        $('#satuan-filter').on('change', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(1).search($('#satuan-filter').val()).draw();
            }, 500);
        });
        $('#date-sp-filter').on('change', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                table.column(4).search($('#date-sp-filter').val()).draw();
            }, 500);
        });
    </script>
@endpush

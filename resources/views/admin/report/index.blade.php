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

          <div class="px-4 py-3 border-bottom mb-4">
            <br>
            <form class="row g-3 needs-validation custom-input" novalidate="">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label" for="name">Filter By:</label>
                    </div>
                    <div class="col-4">
                        <input class="form-control" type="date" id="range-date" name="range-date">
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>

          <div class="card-body">
            <div class="table-responsive theme-scrollbar">
              <table class="table display">
                <thead>
                  <tr class="text-center">
                    <th>NO</th>
                    <th>NAMA SATKER</th>
                    <th>LAPDU MASUK</th>
                    <th>LAPDU SELESAI</th>
                    <th>JUMLAH PENYELIDIKAN</th>
                    <th>JUMLAH TUNGGAKAN PENYELIDIKAN</th>
                    <th>JUMLAH PENYIDIKAN</th>
                    <th>JUMLAH TUNGGAKAN PENYIDIKAN</th>
                    <th>JUMLAH PENUNTUTAN</th>
                    <th>JUMLAH EKSEKUSI</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key=>$data)
                        <tr style="text-align: center">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['lapdu_masuk'] }}</td>
                            <td>{{ $data['lapdu_selesai'] }}</td>
                            <td>{{ $data['jumlah_penyelidikan'] }}</td>
                            <td>{{ $data['jumlah_tunggakan_penyelidikan'] }}</td>
                            <td>{{ $data['jumlah_penyidikan'] }}</td>
                            <td>{{ $data['jumlah_tunggakan_penyidikan'] }}</td>
                            <td>{{ $data['jumlah_penuntutan'] }}</td>
                            <td>{{ $data['jumlah_eksekusi'] }}</td>
                        </tr>
                    @endforeach
                    <tr style="text-align: center">
                        <td colspan="2">Jumlah</td>
                        <td>{{ $total_lapdu_masuk }}</td>
                        <td>{{ $total_lapdu_selesai }}</td>
                        <td>{{ $total_jumlah_penyelidikan }}</td>
                        <td>{{ $total_jumlah_tunggakan_penyelidikan }}</td>
                        <td>{{ $total_jumlah_penyidikan }}</td>
                        <td>{{ $total_jumlah_tunggakan_penyidikan }}</td>
                        <td>{{ $total_jumlah_penuntutan }}</td>
                        <td>{{ $total_jumlah_eksekusi }}</td>
                    </tr>
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
        
    </script>
@endpush

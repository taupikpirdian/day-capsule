@extends('layouts.app')
@section('content')
<div class="container-fluid default-dashboard"> 
    <div class="row widget-grid">
      <div class="col-xl-5 col-md-6 proorder-xl-1 proorder-md-1">  
        <div class="card profile-greeting p-0">
          <div class="card-body">
            <div class="img-overlay">
              <h1>Good day, {{ Auth::user()->name }}</h1>
              <p>Selamat datang di Dashboard SIRIMAU</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-7 col-md-5 proorder-xl-3 proorder-md-3"> 
        <div class="card shifts-char-box">
          <div class="card-header card-no-border pb-0">
            <div class="header-top"> 
              <h4>Data Overview</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="row"> 
              <div class="col-5"> 
                <div class="overview" id="shifts-overview"></div>
              </div>
              <div class="col-7 shifts-overview">
                <div class="d-flex gap-2"> 
                  <div class="flex-shrink-0"><span class="bg-primary"> </span></div>
                  <div class="flex-grow-1"> 
                    <h6>Penyelidikan</h6>
                  </div>
                  <span id="span-penyelidikan">-</span>
                </div>
                <div class="d-flex gap-2"> 
                  <div class="flex-shrink-0"><span class="bg-secondary"></span></div>
                  <div class="flex-grow-1"> 
                    <h6>Penyidikan</h6>
                  </div>
                  <span id="span-penyidikan">-</span>
                </div>
                <div class="d-flex gap-2"> 
                  <div class="flex-shrink-0"><span class="bg-warning"> </span></div>
                  <div class="flex-grow-1"> 
                    <h6>Tuntutan</h6>
                  </div>
                  <span id="span-tuntutan">-</span>
                </div>
                <div class="d-flex gap-2"> 
                  <div class="flex-shrink-0"><span class="bg-tertiary"></span></div>
                  <div class="flex-grow-1"> 
                    <h6>Eksekusi</h6>
                  </div>
                  <span id="span-eksekusi">-</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 proorder-xl-5 box-col-7 proorder-md-5"> 
        <div class="card">
          <div class="card-header card-no-border pb-0">
            <div class="header-top">
              <h4>List Data</h4>
            </div>
          </div>
          <div class="card-body pt-0 projects px-0">
            <div class="table-responsive theme-scrollbar">
              <table class="table display" id="selling-product" style="width:100%">
                <thead>
                  <tr> 
                    <th> 
                      No
                    </th>
                    <th>Satker</th>
                    <th>Nama Tersangka</th>
                    <th>Jenis Perkara</th>
                    <th>Kasus Posisi</th>
                    <th>Tahap Penanganan</th>
                    <th>Keterangan</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($actors as $key=>$actor)
                    @php
                      $viewUrl = "";
                      if($actor->tahapan == PENYELIDIKAN){
                        $viewUrl = route('penyelidikan.show', $actor->uuid_penyelidikan);
                      }elseif($actor->tahapan == PENYIDIKAN){
                        $viewUrl = route('penyidikan.show', $actor->uuid_penyidikan);
                      }elseif($actor->tahapan == TUNTUTAN){
                        $viewUrl = route('penuntutan.show', $actor->uuid_penuntutan);
                      }elseif($actor->tahapan == EKSEKUSI){
                        $viewUrl = route('eksekusi.show', $actor->uuid_eksekusi);
                      }
                    @endphp
                    <tr>
                      <td> {{ $key + 1 }}</td>
                      <td> {{ $actor->satuan }}</td>
                      <td> {{ $actor->name }}</td>
                      <td> {{ $actor->jenisPerkara ? $actor->jenisPerkara->name : '' }}</td>
                      <td> {{ $actor->kasus_posisi }}</td>
                      <td> {{ $actor->tahapan }}</td>
                      <td> {{ $actor->keterangan }}</td>
                      <td class="text-center"> 
                        <div class="dropdown icon-dropdown">
                          <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                            <a class="dropdown-item" href="{{$viewUrl}}">Detail</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push ('after-scripts')
    <script>
      // ----------Shifts Overview-----//
      var url = "{{ route('dashboard.overview') }}";
      callDataWithAjax(url, 'POST', {}).then((data) => {
          let jsonObject = JSON.parse(data);
          $('#span-penyelidikan').html(jsonObject.total_penyelidikan)
          $('#span-penyidikan').html(jsonObject.total_penyidikan)
          $('#span-tuntutan').html(jsonObject.total_tuntutan)
          $('#span-eksekusi').html(jsonObject.total_eksekusi)
          var option = {
            labels: ["Penyelidikan", "Penyidikan", "Tuntutan", "Eksekusi"],
            series: jsonObject.array_value,
            chart: {
                type: "donut",
                height: 200,
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            stroke: {
                width: 6,
            },
            plotOptions: {
                pie: {
                    expandOnClick: false,
                    donut: {
                        size: "83%",
                        labels: {
                            show: true,
                            name: {
                                offsetY: 4,
                            },
                            total: {
                                show: true,
                                fontSize: "20px",
                                fontFamily: "Outfit', sans-serif",
                                fontWeight: 600,
                                label: jsonObject.total,
                                formatter: () => "Total Overview",
                            },
                        },
                    },
                },
            },
            states: {
                normal: {
                    filter: {
                        type: "none",
                    },
                },
                hover: {
                    filter: {
                        type: "none",
                    },
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: "none",
                    },
                },
            },
            colors: ["#48A3D7", "#D77748", "#C95E9E", "#7A70BA"],
          };
          var chart = new ApexCharts(
              document.querySelector("#shifts-overview"),
              option
          );
          chart.render();
      }).catch((xhr) => {
          alert('Error: ' + xhr.responseText);
      })
    </script>
@endpush

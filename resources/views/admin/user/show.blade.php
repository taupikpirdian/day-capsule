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
            <form class="row g-3 needs-validation custom-input" novalidate="">
                <div class="col-12">
                    <label class="form-label" for="name">Nama</label>
                    <input class="form-control" id="name" type="text" value="{{ $data->name }}" readonly>
                </div>

                <div class="col-12">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" type="email" value="{{ $data->email }}" readonly>
                </div>

                <div class="col-12">
                    <label class="form-label" for="role">Role</label>
                    <input class="form-control" id="email" type="email" value="{{$data->roles->pluck('name')[0] }}" readonly>
                </div>
                <div class="col-12">
                    <a class="btn btn-info" href="{{ route("users.index") }}" type="button">Kembali</a>
                </div>
            </form>
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
      // ----------Shifts Overview-----//
    </script>
@endpush

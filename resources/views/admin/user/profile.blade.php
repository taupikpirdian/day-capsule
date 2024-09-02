@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">My Profile</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ $url_action }}" class="row g-3 needs-validation custom-input" novalidate="">
                @csrf
                <div class="row mb-2">
                  <div class="profile-title mt-2">
                    <div class="d-flex">                        
                      <img class="img-70 rounded-circle" alt="" src="../assets/images/user/7.jpg">
                      <div class="flex-grow-1">
                        <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                        <p>{{Auth::user()->roles->pluck('name')[0]}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Email-Address</label>
                  <input class="form-control" value="{{ Auth::user()->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input class="form-control" type="text" value="{{ Auth::user()->name }}" name="name" required>
                  </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" id="password" name="password">
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('password'))
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                  </div>
                <div class="form-footer">
                  <button class="btn btn-primary btn-block" type="submit">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Container-fluid starts-->
<div style="height: 10px"></div>
@endsection

@push ('after-scripts')
    <script>
       
    </script>
@endpush

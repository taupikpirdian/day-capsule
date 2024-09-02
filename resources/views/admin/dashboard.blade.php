@extends('layouts.app')
@section('content')
<div class="container-fluid default-dashboard"> 
    <div class="row widget-grid">
      <div class="col-xl-12 col-md-6 proorder-xl-1 proorder-md-1">  
        <div class="card profile-greeting p-0">
          <div class="card-body">
            <div class="img-overlay">
              <h1>Good day, {{ Auth::user()->name }}</h1>
              <p>Selamat datang di Dashboard Day Capsule</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push ('after-scripts')
    <script>
    </script>
@endpush

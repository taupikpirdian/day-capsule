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
            <form method="POST" action="{{ $url_action }}" class="row g-3 needs-validation custom-input" novalidate="">
                @if($is_edit)
                    @method('PUT')
                @endif            
                @csrf
                
                <div class="col-12">
                    <label class="form-label" for="name">Nama <span class="required">*</span></label>
                    <input class="form-control" id="name" type="text" placeholder="Name" name="name" value="{{old('name', isset($data) ? $data->name : "")}}" required>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                </div>

                <div class="col-12">
                    <label class="form-label" for="email">Email <span class="required">*</span></label>
                    <input class="form-control" id="email" type="email" placeholder="Email" name="email" value="{{old('email', isset($data) ? $data->email : "")}}" required>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('email'))
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label" for="role">Role <span class="required">*</span></label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @if(old('role', isset($data) ? $data->roles->pluck('name')[0] : "") == $role->name) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('role'))
                        <div class="error-message">{{ $errors->first('role') }}</div>
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label" for="password">Password @if($is_edit == false) <span class="required">*</span> @endif</label>
                    <input class="form-control" id="password" type="password" placeholder="Password" name="password" @if($is_edit == false) required @endif>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('password'))
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password @if($is_edit == false) <span class="required">*</span> @endif</label>
                    <input class="form-control" id="password_confirmation" type="password" placeholder="Password" name="password_confirmation" @if(!$is_edit) required @endif>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                </div>

                <div class="col-12">
                    <a class="btn btn-info" href="{{ route("users.index") }}" type="button">Kembali</a>
                    <button class="btn btn-primary" type="submit">Submit</button>
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

@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Saldo</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ $url_action }}" class="row g-3 needs-validation custom-input" novalidate="">
                @csrf
                <div class="mb-3">
                  <label class="form-label">JUMLAH TUNGGAKAN PERKARA PENYELIDIKAN</label>
                  <input class="form-control" type="number" name="penyelidikan" value="{{old('penyelidikan', isset($data) ? $data->penyelidikan : "")}}" required>
                  <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('penyelidikan'))
                        <div class="error-message">{{ $errors->first('penyelidikan') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                  <label class="form-label">JUMLAH TUNGGAKAN PERKARA PENYIDIKAN</label>
                  <input class="form-control" type="number" name="penyidikan" value="{{old('penyidikan', isset($data) ? $data->penyidikan : "")}}" required>
                  <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('penyidikan'))
                        <div class="error-message">{{ $errors->first('penyidikan') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                  <label class="form-label">JUMLAH TUNGGAKAN PERKARA PENUNTUTAN</label>
                  <input class="form-control" type="number" name="penuntutan" value="{{old('penuntutan', isset($data) ? $data->penuntutan : "")}}" required>
                  <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('penuntutan'))
                        <div class="error-message">{{ $errors->first('penuntutan') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                  <label class="form-label">JUMLAH TUNGGAKAN PERKARA EKSEKUSI </label>
                  <input class="form-control" type="number" name="eksekusi" value="{{old('eksekusi', isset($data) ? $data->eksekusi : "")}}" required>
                  <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('eksekusi'))
                        <div class="error-message">{{ $errors->first('eksekusi') }}</div>
                    @endif
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

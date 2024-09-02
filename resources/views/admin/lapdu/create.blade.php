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

                @if($is_admin)
                  <div class="col-12">
                    <label class="form-label" for="role">Satuan Kerja <span class="required">*</span></label>
                    <select class="form-control select2-dynamic" id="institution_category_part_id" name="institution_category_part_id" required @if($is_show) disabled @endif>
                        <option value="">Pilih Satuan Kerja</option>
                        @foreach ($satuan_kerjas as $satuan_kerja)
                        <option value="{{ $satuan_kerja->id }}" @if(old('institution_category_part_id', isset($data) ? $data->institution_category_part_id : "") == $satuan_kerja->id) selected @endif>{{ $satuan_kerja->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('institution_category_part_id'))
                        <div class="error-message">{{ $errors->first('institution_category_part_id') }}</div>
                    @endif
                  </div>
                @endif
                
                <div class="col-12">
                    <label class="form-label" for="sender_name">NAMA PENGIRIM LAPDU <span class="required">*</span></label>
                    <input class="form-control" id="sender_name" type="text" placeholder="Name" name="sender_name" value="{{old('sender_name', isset($data) ? $data->sender_name : "")}}" required>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('sender_name'))
                        <div class="error-message">{{ $errors->first('sender_name') }}</div>
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label" for="kasus_posisi">KASUS POSISI <span class="required">*</span></label>
                    <textarea class="form-control" id="kasus_posisi" name="kasus_posisi" required>{{old('kasus_posisi', isset($data) ? $data->kasus_posisi : "")}}</textarea>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('kasus_posisi'))
                        <div class="error-message">{{ $errors->first('kasus_posisi') }}</div>
                    @endif
                </div>

                <div class="col-12">
                    <a class="btn btn-info" href="{{ route("lapdu.index") }}" type="button">Kembali</a>
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
        $('.select2-dynamic').select2()
    </script>
@endpush

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
            <form method="POST" action="{{ $url_action }}" class="row g-3 needs-validation custom-input" novalidate="" enctype="multipart/form-data">
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
                    <label class="form-label" for="role">Jenis Perkara <span class="required">*</span></label>
                    <select class="form-control select2-dynamic" id="jenis_perkara_id" name="jenis_perkara_id" required @if($is_show) disabled @endif>
                        <option value="">Pilih Jenis Perkara</option>
                        @foreach ($jenis_perkaras as $jenis_perkara)
                        <option value="{{ $jenis_perkara->id }}" @if(old('jenis_perkara_id', isset($data) ? $data->jenis_perkara_id : "") == $jenis_perkara->id) selected @endif>{{ $jenis_perkara->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                    @if ($errors->has('jenis_perkara_id'))
                        <div class="error-message">{{ $errors->first('jenis_perkara_id') }}</div>
                    @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="role">Status <span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="status" name="status" required @if($is_show) disabled @endif>
                      <option value="">Pilih Status</option>
                      <option value="SAKSI" @if(old('status', isset($data) ? $data->status : "") == "SAKSI") selected @endif>SAKSI</option>
                      <option value="TERSANGKA" @if(old('status', isset($data) ? $data->status : "") == "TERSANGKA") selected @endif>TERSANGKA</option>
                      <option value="TERDAKWA" @if(old('status', isset($data) ? $data->status : "") == "TERDAKWA") selected @endif>TERDAKWA</option>
                      <option value="TERPIDANA" @if(old('status', isset($data) ? $data->status : "") == "TERPIDANA") selected @endif>TERPIDANA</option>
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('status'))
                      <div class="error-message">{{ $errors->first('status') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="name">Nama <span class="required">*</span></label>
                  <input class="form-control" id="name" type="text" placeholder="Name" name="name" value="{{old('name', isset($data) ? $data->name : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('name'))
                      <div class="error-message">{{ $errors->first('name') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_sp">NO SP LID <span class="required">*</span></label>
                  <input class="form-control" id="no_sp" type="text" placeholder="No SP LID" name="no_sp" value="{{old('no_sp', isset($data) ? $data->no_sp : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('no_sp'))
                      <div class="error-message">{{ $errors->first('no_sp') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_sp">Tanggal SP LID <span class="required">*</span></label>
                  <input class="form-control" id="date_sp" type="date" placeholder="Tanggal SP LID" name="date_sp" value="{{old('date_sp', isset($data) ? $data->date_sp : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('date_sp'))
                      <div class="error-message">{{ $errors->first('date_sp') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="kasus_posisi">Kasus Posisi <span class="required">*</span></label>
                  <textarea class="form-control" id="kasus_posisi" name="kasus_posisi" required @if($is_show) disabled @endif>{{old('kasus_posisi', isset($data) ? $data->kasus_posisi : "")}}</textarea>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('kasus_posisi'))
                      <div class="error-message">{{ $errors->first('kasus_posisi') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="asal_perkara">Asal Perkara <span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="asal_perkara" name="asal_perkara" required @if($is_show) disabled @endif>
                    <option value="">Pilih Asal Perkara</option>
                    <option value="KEJAKSAAN" @if(old('asal_perkara', isset($data) ? $data->asal_perkara : "") == "KEJAKSAAN") selected @endif>KEJAKSAAN</option>
                    <option value="KEPOLISIAN" @if(old('asal_perkara', isset($data) ? $data->asal_perkara : "") == "KEPOLISIAN") selected @endif>KEPOLISIAN</option>
                    <option value="PPNS" @if(old('asal_perkara', isset($data) ? $data->asal_perkara : "") == "PPNS") selected @endif>PPNS</option>
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('asal_perkara'))
                      <div class="error-message">{{ $errors->first('asal_perkara') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="jenis_perkara_prioritas">Jenis Perkara Prioritas<span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="jenis_perkara_prioritas" name="jenis_perkara_prioritas" required @if($is_show) disabled @endif>
                    <option value="">Pilih Asal Perkara</option>
                    <option value="7 Perkara Direktif" @if(old('jenis_perkara_prioritas', isset($data) ? $data->jenis_perkara_prioritas : "") == "7 Perkara Direktif") selected @endif>7 Perkara Direktif</option>
                    <option value="Diluar 7 Perkara Direktif" @if(old('jenis_perkara_prioritas', isset($data) ? $data->jenis_perkara_prioritas : "") == "Diluar 7 Perkara Direktif") selected @endif>Diluar 7 Perkara Direktif</option>
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('jenis_perkara_prioritas'))
                      <div class="error-message">{{ $errors->first('jenis_perkara_prioritas') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="pnbp">Pengembalian Uang Negara (PNBP) <span class="required">*</span></label>
                  <input class="form-control" id="pnbp" type="text" placeholder="Pengembalian Uang Negara (PNBP)" name="pnbp" value="{{old('pnbp', isset($data) ? $data->pnbp : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('pnbp'))
                      <div class="error-message">{{ $errors->first('pnbp') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="keterangan">Keterangan <span class="required">*</span></label>
                  <textarea class="form-control" id="keterangan" name="keterangan" required @if($is_show) disabled @endif>{{old('keterangan', isset($data) ? $data->keterangan : "")}}</textarea>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('keterangan'))
                      <div class="error-message">{{ $errors->first('keterangan') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p2">P2 </label>
                  <input class="form-control" id="p2" type="file" name="p2" @if(!$is_edit) @endif @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p2'))
                      <div class="error-message">{{ $errors->first('p2') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->fileP2)
                      <a target='_blank' href="/file/berkas/{{$data->fileP2->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="capture_cms_p2">Capture CMS P-2 </label>
                  <input class="form-control" id="capture_cms_p2" type="file" name="capture_cms_p2" @if(!$is_edit)  @endif @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('capture_cms_p2'))
                      <div class="error-message">{{ $errors->first('capture_cms_p2') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->fileCaptureCmsP2)
                      <a target='_blank' href="/file/berkas/{{$data->fileCaptureCmsP2->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="sp3">PENGHENTIAN PENANGANAN PERKARA (SP3) @if(!$is_edit) @endif</label>
                  <input class="form-control" id="sp3" type="file" name="sp3" @if(!$is_edit)  @endif @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('sp3'))
                      <div class="error-message">{{ $errors->first('sp3') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->sp3)
                      <a target='_blank' href="/file/berkas/{{$data->sp3->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="catatan">Catatan Pimpinan</label>
                  <input class="form-control" id="catatan" type="text" placeholder="Catatan" name="catatan" value="{{old('catatan', isset($data) ? $data->catatan : "")}}" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('catatan'))
                      <div class="error-message">{{ $errors->first('catatan') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <a class="btn btn-info" href="{{ route("penyelidikan.index") }}" type="button">Kembali</a>
                  @if($is_show)
                    <a class="btn btn-warning" href="{{ url('penyidikan/create') . '?forward=' . urlencode($data->uuid_actor) }}" type="button">Ajukan Penyidikan</a>
                  @endif
                  @if(!$is_show)
                    <button class="btn btn-primary" type="submit">Submit</button>
                  @endif
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

        getAndSetCurrencyFormat("#pnbp");
        $("#pnbp").on("keyup",function(){
          viewCurrency($(this).val(), "#pnbp");
        });
    </script>
@endpush

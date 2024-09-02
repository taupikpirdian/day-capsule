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
                <div class="col-6 d-none">
                  <label class="form-label" for="forward">F <span class="required">*</span></label>
                  <input class="form-control" id="forward" type="text" name="forward" value="{{ $forward }}" readonly>
                </div>
                @if($is_admin)
                  <div class="col-12">
                    <label class="form-label" for="institution_category_part_id">SATUAN KERJA <span class="required">*</span></label>
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
                    <label class="form-label" for="jenis_perkara_id">JENIS PERKARA <span class="required">*</span></label>
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
                  <label class="form-label" for="status">STATUS <span class="required">*</span></label>
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
                  <label class="form-label" for="name">NAMA <span class="required">*</span></label>
                  <input class="form-control" id="name" type="text" placeholder="Name" name="name" value="{{old('name', isset($data) ? $data->name : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('name'))
                      <div class="error-message">{{ $errors->first('name') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_sp_lid">NO SP-LID </label>
                  <input class="form-control" id="no_sp_lid" type="text" placeholder="No SP-LID" value="{{old('no_sp_lid', isset($data) ? $data->no_sp_lid : "")}}" disabled>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('no_sp_lid'))
                      <div class="error-message">{{ $errors->first('no_sp_lid') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_sp_lid">TANGGAL SP-LID </label>
                  <input class="form-control" id="date_sp_lid" type="date" placeholder="Date SP-LID" value="{{old('date_sp_lid', isset($data) ? $data->date_sp_lid : "")}}" disabled>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('date_sp_lid'))
                      <div class="error-message">{{ $errors->first('date_sp_lid') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_sp_dik">NO SP-DIK <span class="required">*</span></label>
                  <input class="form-control" id="no_sp_dik" type="text" placeholder="No SP-LID" value="{{old('no_sp_dik', isset($data) ? $data->no_sp_dik : "")}}" disabled>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('no_sp_dik'))
                      <div class="error-message">{{ $errors->first('no_sp_dik') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_sp_dik">TANGGAL SP-DIK <span class="required">*</span></label>
                  <input class="form-control" id="date_sp_dik" type="date" placeholder="Date SP-LID" value="{{old('date_sp_dik', isset($data) ? $data->date_sp_dik : "")}}" disabled>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('date_sp_dik'))
                      <div class="error-message">{{ $errors->first('date_sp_dik') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_spdp">NO SPDP <span class="required">*</span></label>
                  <input class="form-control" id="no_spdp" type="text" placeholder="No SPDP" name="no_spdp" value="{{old('no_spdp', isset($data) ? $data->no_spdp : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('no_spdp'))
                      <div class="error-message">{{ $errors->first('no_spdp') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_spdp">TANGGAL SPDP <span class="required">*</span></label>
                  <input class="form-control" id="date_spdp" type="date" placeholder="Date SPDP" name="date_spdp" value="{{old('date_spdp', isset($data) ? $data->date_spdp : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('date_spdp'))
                      <div class="error-message">{{ $errors->first('date_spdp') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="jpu">JPU <span class="required">*</span></label>
                  <textarea class="form-control" id="jpu" name="jpu" required @if($is_show) disabled @endif>{{old('jpu', isset($data) ? $data->jpu : "")}}</textarea>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('jpu'))
                      <div class="error-message">{{ $errors->first('jpu') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="kasus_posisi">KASUS POSISI <span class="required">*</span></label>
                  <textarea class="form-control" id="kasus_posisi" name="kasus_posisi" required @if($is_show) disabled @endif>{{old('kasus_posisi', isset($data) ? $data->kasus_posisi : "")}}</textarea>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('kasus_posisi'))
                      <div class="error-message">{{ $errors->first('kasus_posisi') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="asal_perkara">ASAL PERKARA <span class="required">*</span></label>
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

                <div class="col-12">
                  <label class="form-label" for="keterangan">KETERANGAN <span class="required">*</span></label>
                  <textarea class="form-control" id="keterangan" name="keterangan" required @if($is_show) disabled @endif>{{old('keterangan', isset($data) ? $data->keterangan : "")}}</textarea>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('keterangan'))
                      <div class="error-message">{{ $errors->first('keterangan') }}</div>
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label">P2</label>
                  @if(isset($data))
                    @if(isset($data->penyelidikan->fileP2))
                      <br>
                      <a target='_blank' href="/file/berkas/{{$data->penyelidikan->fileP2->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label">PIDSUS-7</label>
                  @if(isset($data))
                    @if($data->penyidikan->pidsus7)
                      <br>
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->pidsus7->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label">P-8</label>
                  @if(isset($data))
                    @if($data->penyidikan->p8)
                      <br>
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->p8->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label">TAP TERSANGKA (Pidsus-18)</label>
                  @if(isset($data))
                    @if($data->penyidikan->tapTersangka)
                      <br>
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->tapTersangka->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-8">
                  <label class="form-label">P-21</label>
                  @if(isset($data))
                    @if($data->penyidikan->p21)
                      <br>
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->p21->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p16a">P-16A </label>
                  <input class="form-control" id="p16a" type="file" name="p16a" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p16a'))
                      <div class="error-message">{{ $errors->first('p16a') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p16a)
                      <a target='_blank' href="/file/berkas/{{$data->p16a->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p31">P-31 </label>
                  <input class="form-control" id="p31" type="file" name="p31" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p31'))
                      <div class="error-message">{{ $errors->first('p31') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p31)
                      <a target='_blank' href="/file/berkas/{{$data->p31->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p38">P-38 </label>
                  <input class="form-control" id="p38" type="file" name="p38" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p38'))
                      <div class="error-message">{{ $errors->first('p38') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p38)
                      <a target='_blank' href="/file/berkas/{{$data->p38->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="putusan">Putusan </label>
                  <input class="form-control" id="putusan" type="file" name="putusan" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('putusan'))
                      <div class="error-message">{{ $errors->first('putusan') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->putusan)
                      <a target='_blank' href="/file/berkas/{{$data->putusan->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="surat_auditor">SURAT DARI AUDITOR </label>
                  <input class="form-control" id="surat_auditor" type="file" name="surat_auditor" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('surat_auditor'))
                      <div class="error-message">{{ $errors->first('surat_auditor') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->suratAuditor)
                      <a target='_blank' href="/file/berkas/{{$data->suratAuditor->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="sp3">PENGHENTIAN PENANGANAN PERKARA (SP3) @if(!$is_edit) @endif</label>
                  <input class="form-control" id="sp3" type="file" name="sp3" @if($is_show) disabled @endif>
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
                  <label class="form-label" for="catatan">CATATAN PIMPINAN/DISPOSISI <span class="required">*</span></label>
                  <input class="form-control" id="catatan" type="text" placeholder="Catatan" name="catatan" value="{{old('catatan', isset($data) ? $data->catatan : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('catatan'))
                      <div class="error-message">{{ $errors->first('catatan') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <a class="btn btn-info" href="{{ route("penuntutan.index") }}" type="button">Kembali</a>
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
    </script>
@endpush

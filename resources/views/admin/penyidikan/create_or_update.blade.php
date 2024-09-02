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
                    <label class="form-label" for="institution_category_part_id">Satuan Kerja <span class="required">*</span></label>
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
                    <label class="form-label" for="jenis_perkara_id">Jenis Perkara <span class="required">*</span></label>
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
                  <label class="form-label" for="status">Status <span class="required">*</span></label>
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
                  <label class="form-label" for="pekerjaan_id">Pekerjaan <span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="pekerjaan_id" name="pekerjaan_id" required @if($is_show) disabled @endif>
                      <option value="">Pilih Pekerjaan</option>
                      @foreach($pekerjaans as $pekerjaan)
                      <option value="{{ $pekerjaan->id }}" @if(old('pekerjaan_id', isset($data) ? $data->pekerjaan_id : "") == $pekerjaan->id) selected @endif>{{ $pekerjaan->name }}</option>
                      @endforeach
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('pekerjaan_id'))
                      <div class="error-message">{{ $errors->first('pekerjaan_id') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="nilai_kerugian">Nilai Kerugian <span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="nilai_kerugian" name="nilai_kerugian" required @if($is_show) disabled @endif>
                    <option value="">Pilih Nilai Kerugian</option>
                    <option value="<5 miliar" @if(old('nilai_kerugian', isset($data) ? $data->nilai_kerugian : "") == "<5 miliar") selected @endif> <5 miliar </option>
                    <option value=">5 miliar" @if(old('nilai_kerugian', isset($data) ? $data->nilai_kerugian : "") == ">5 miliar") selected @endif> >5 miliar </option>
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('nilai_kerugian'))
                      <div class="error-message">{{ $errors->first('nilai_kerugian') }}</div>
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label" for="kerugian_perekonomian_negara">Kerugian Perekonomian Negara</label><br>
                  <input class="checkbox_animated" id="kerugian_perekonomian_negara" name="kerugian_perekonomian_negara" type="checkbox" @if(old('kerugian_perekonomian_negara', isset($data) ? $data->kerugian_perekonomian_negara : "") == 1) checked @endif @if($is_show) disabled @endif>
                </div>

                <div class="col-4">
                  <label class="form-label" for="korperasi">Korperasi</label><br>
                  <input class="checkbox_animated" id="korperasi" name="korperasi" type="checkbox" @if(old('korperasi', isset($data) ? $data->korperasi : "") == 1) checked @endif @if($is_show) disabled @endif>
                </div>

                <div class="col-4">
                  <label class="form-label" for="disertai_tppu">Disertai TPPU </label><br>
                  <input class="checkbox_animated" id="disertai_tppu" name="disertai_tppu" type="checkbox" @if(old('disertai_tppu', isset($data) ? $data->disertai_tppu : "") == 1) checked @endif @if($is_show) disabled @endif>
                </div>

                <div class="col-6">
                  <label class="form-label" for="penyelamatan_kerugian_negara">Penyelamatan Kerugian Negara <span class="required">*</span></label>
                  <input class="form-control" id="penyelamatan_kerugian_negara" type="text" placeholder="Penyelamatan Kerugian Negara" name="penyelamatan_kerugian_negara" value="{{old('penyelamatan_kerugian_negara', isset($data) ? $data->penyelamatan_kerugian_negara : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('penyelamatan_kerugian_negara'))
                      <div class="error-message">{{ $errors->first('penyelamatan_kerugian_negara') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_sp_dik">NO SP DIK <span class="required">*</span></label>
                  <input class="form-control" id="no_sp_dik" type="text" placeholder="No SP DIK" name="no_sp_dik" value="{{old('no_sp_dik', isset($data) ? $data->no_sp_dik : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('no_sp_dik'))
                      <div class="error-message">{{ $errors->first('no_sp_dik') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="date_sp_dik">Tanggal SP DIK <span class="required">*</span></label>
                  <input class="form-control" id="date_sp_dik" type="date" placeholder="Tanggal SP LID" name="date_sp_dik" value="{{old('date_sp_dik', isset($data) ? $data->date_sp_dik : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('date_sp_dik'))
                      <div class="error-message">{{ $errors->first('date_sp_dik') }}</div>
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
                  <label class="form-label" for="perkara_pasal_35_ayat_1">Perkara Pasal 35 Ayat 1 Huruf K<span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="perkara_pasal_35_ayat_1" name="perkara_pasal_35_ayat_1" required @if($is_show) disabled @endif>
                    <option value="">Pilih Asal Perkara</option>
                    <option value="Ya" @if(old('perkara_pasal_35_ayat_1', isset($data) ? $data->perkara_pasal_35_ayat_1 : "") == "Ya") selected @endif>Ya</option>
                    <option value="Tidak" @if(old('perkara_pasal_35_ayat_1', isset($data) ? $data->perkara_pasal_35_ayat_1 : "") == "Tidak") selected @endif>Tidak</option>
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('perkara_pasal_35_ayat_1'))
                      <div class="error-message">{{ $errors->first('perkara_pasal_35_ayat_1') }}</div>
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
                  <label class="form-label" for="pidsus7">Pidsus 7</label>
                  <input class="form-control" id="pidsus7" type="file" name="pidsus7" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('pidsus7'))
                      <div class="error-message">{{ $errors->first('pidsus7') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->pidsus7)
                      <a target='_blank' href="/file/berkas/{{$data->pidsus7->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p8">P-8</label>
                  <input class="form-control" id="p8" type="file" name="p8" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p8'))
                      <div class="error-message">{{ $errors->first('p8') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p8)
                      <a target='_blank' href="/file/berkas/{{$data->p8->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="capture_cms_p8">Capture CMS P-8</label>
                  <input class="form-control" id="capture_cms_p8" type="file" name="capture_cms_p8" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('capture_cms_p8'))
                      <div class="error-message">{{ $errors->first('capture_cms_p8') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->fileCaptureCmsP8)
                      <a target='_blank' href="/file/berkas/{{$data->fileCaptureCmsP8->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="tap_tersangka">TAP TERSANGKA (Pidsus-18)</label>
                  <input class="form-control" id="tap_tersangka" type="file" name="tap_tersangka" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('tap_tersangka'))
                      <div class="error-message">{{ $errors->first('tap_tersangka') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->tapTersangka)
                      <a target='_blank' href="/file/berkas/{{$data->tapTersangka->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p16">P16</label>
                  <input class="form-control" id="p16" type="file" name="p16" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p16'))
                      <div class="error-message">{{ $errors->first('p16') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p16)
                      <a target='_blank' href="/file/berkas/{{$data->p16->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p21">P21</label>
                  <input class="form-control" id="p21" type="file" name="p21" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p21'))
                      <div class="error-message">{{ $errors->first('p21') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p21)
                      <a target='_blank' href="/file/berkas/{{$data->p21->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="ba_ekspose">BA EKSPOSE</label>
                  <input class="form-control" id="ba_ekspose" type="file" name="ba_ekspose" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('ba_ekspose'))
                      <div class="error-message">{{ $errors->first('ba_ekspose') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->fileBaEkspose)
                      <a target='_blank' href="/file/berkas/{{$data->fileBaEkspose->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
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

                @if (Auth::user()->hasRole('kejati'))
                <div class="col-12">
                  <label class="form-label" for="limpah">Limpah <span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="limpah" name="limpah" @if(Auth::user()->hasRole('kejati')) required @endif @if($is_show) disabled @endif>
                      <option value="">Pilih Satuan Kerja Limpah</option>
                      @foreach ($satuan_kerjas as $satuan_kerja)
                        @if($satuan_kerja->name != 'KEJAKSAAN TINGGI SUMATERA SELATAN')
                          <option value="{{ $satuan_kerja->id }}" @if(old('limpah', isset($data) ? isset($data->actor) ? $data->actor->limpah : "" : "") == $satuan_kerja->id) selected @endif>{{ $satuan_kerja->name }}</option>
                        @endif
                      @endforeach
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('limpah'))
                      <div class="error-message">{{ $errors->first('limpah') }}</div>
                  @endif
                </div>
                @endif

                <div class="col-12">
                  <label class="form-label" for="catatan">Catatan Pimpinan <span class="required">*</span></label>
                  <input class="form-control" id="catatan" type="text" placeholder="Catatan" name="catatan" value="{{old('catatan', isset($data) ? $data->catatan : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('catatan'))
                      <div class="error-message">{{ $errors->first('catatan') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <a class="btn btn-info" href="{{ route("penyidikan.index") }}" type="button">Kembali</a>
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

        getAndSetCurrencyFormat("#penyelamatan_kerugian_negara");
        $("#penyelamatan_kerugian_negara").on("keyup",function(){
          viewCurrency($(this).val(), "#penyelamatan_kerugian_negara");
        });
    </script>
@endpush

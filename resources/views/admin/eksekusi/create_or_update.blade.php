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
                  <label class="form-label" for="no_sp_lid">NO SP-LID </label>
                  <input class="form-control" id="no_sp_lid" type="text" placeholder="No SP LID" name="no_sp_lid" value="{{old('no_sp_lid', isset($data) ? $data->no_sp_lid : "")}}" disabled>
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_sp_lid">Tanggal SP-LID </label>
                  <input class="form-control" id="date_sp_lid" type="date" placeholder="Tanggal SP LID" name="date_sp_lid" value="{{old('date_sp_lid', isset($data) ? $data->date_sp_lid : "")}}" disabled>
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_sp_dik">NO SP-DIK </label>
                  <input class="form-control" id="no_sp_dik" type="text" placeholder="No SP DIK" name="no_sp_dik" value="{{old('no_sp_dik', isset($data) ? $data->no_sp_dik : "")}}" disabled>
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_sp_dik">Tanggal SP-DIK </label>
                  <input class="form-control" id="date_sp_dik" type="date" placeholder="Tanggal SP DIK" name="date_sp_dik" value="{{old('date_sp_dik', isset($data) ? $data->date_sp_dik : "")}}" disabled>
                </div>

                <div class="col-6">
                  <label class="form-label" for="no_spdp">NO SPDP </label>
                  <input class="form-control" id="no_spdp" type="text" placeholder="No SP SPDP" name="no_spdp" value="{{old('no_spdp', isset($data) ? $data->no_spdp : "")}}" disabled>
                </div>

                <div class="col-6">
                  <label class="form-label" for="date_spdp">Tanggal SPDP </label>
                  <input class="form-control" id="date_spdp" type="date" placeholder="Tanggal SP SPDP" name="date_spdp" value="{{old('date_spdp', isset($data) ? $data->date_spdp : "")}}" disabled>
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

                <div class="col-12">
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
                  <label class="form-label" for="pidana_badan">PIDANA BADAN <span class="required">*</span></label>
                  <input class="form-control" id="pidana_badan" type="text" placeholder="Pidana Badan" name="pidana_badan" value="{{old('pidana_badan', isset($data) ? $data->pidana_badan : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('pidana_badan'))
                      <div class="error-message">{{ $errors->first('pidana_badan') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="subsider_pidana_badan">SUBSIDER PIDANA BADAN <span class="required">*</span></label>
                  <input class="form-control" id="subsider_pidana_badan" type="text" placeholder="Sumber Pidana Badan" name="subsider_pidana_badan" value="{{old('subsider_pidana_badan', isset($data) ? $data->subsider_pidana_badan : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('subsider_pidana_badan'))
                      <div class="error-message">{{ $errors->first('subsider_pidana_badan') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="denda">DENDA <span class="required">*</span></label>
                  <input class="form-control" id="denda" type="text" placeholder="Denda" name="denda" value="{{old('denda', isset($data) ? $data->denda : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('denda'))
                      <div class="error-message">{{ $errors->first('denda') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="subsider_denda">SUBSIDER DENDA <span class="required">*</span></label>
                  <input class="form-control" id="subsider_denda" type="text" placeholder="Sumber Denda" name="subsider_denda" value="{{old('subsider_denda', isset($data) ? $data->subsider_denda : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('subsider_denda'))
                      <div class="error-message">{{ $errors->first('subsider_denda') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="uang_pengganti">UANG PENGGANTI <span class="required">*</span></label>
                  <input class="form-control" id="uang_pengganti" type="text" placeholder="Uang Pengganti" name="uang_pengganti" value="{{old('uang_pengganti', isset($data) ? $data->uang_pengganti : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('uang_pengganti'))
                      <div class="error-message">{{ $errors->first('uang_pengganti') }}</div>
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="barang_bukti">BARANG BUKTI <span class="required">*</span></label>
                  <input class="form-control" id="barang_bukti" type="text" placeholder="Barang Bukti" name="barang_bukti" value="{{old('barang_bukti', isset($data) ? $data->barang_bukti : "")}}" required @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('barang_bukti'))
                      <div class="error-message">{{ $errors->first('barang_bukti') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="pelelangan_benda_sitaan">PELELANGAN BENDA SITAAN <span class="required">*</span></label>
                  <select class="form-control select2-dynamic" id="pelelangan_benda_sitaan" name="pelelangan_benda_sitaan" required @if($is_show) disabled @endif>
                    <option value="">Pilih Asal Perkara</option>
                    <option value="ya" @if(old('pelelangan_benda_sitaan', isset($data) ? $data->pelelangan_barang_sitaan : "") == "ya") selected @endif>Ya</option>
                    <option value="tidak" @if(old('pelelangan_benda_sitaan', isset($data) ? $data->pelelangan_barang_sitaan : "") == "tidak") selected @endif>Tidak</option>
                  </select>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('pelelangan_benda_sitaan'))
                      <div class="error-message">{{ $errors->first('pelelangan_benda_sitaan') }}</div>
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

                <div class="col-4">
                  <label class="form-label">P2</label>
                  @if(isset($data))
                    @if($data->penyelidikan->fileP2)
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
                  <label class="form-label" for="tap_tersangka">TAP TERSANGKA </label>
                  <br>
                  @if(isset($data))
                    @if($data->penyidikan->tapTersangka)
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->tapTersangka->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label" for="p16">P-16 </label>
                  <br>
                  @if(isset($data))
                    @if($data->penyidikan->p16)
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->p16->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label" for="p21">P-21 </label>
                  <br>
                  @if(isset($data))
                    @if($data->penyidikan->p21)
                      <a target='_blank' href="/file/berkas/{{$data->penyidikan->p21->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label" for="surat_auditor">SURAT DARI AUDITOR </label>
                  <br>
                  @if(isset($data))
                    @if($data->penuntutan->suratAuditor)
                      <a target='_blank' href="/file/berkas/{{$data->penuntutan->suratAuditor->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label" for="surat_auditor">P-31 </label>
                  <br>
                  @if(isset($data))
                    @if($data->penuntutan->p31)
                      <a target='_blank' href="/file/berkas/{{$data->penuntutan->p31->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-4">
                  <label class="form-label" for="surat_auditor">P-38 </label>
                  <br>
                  @if(isset($data))
                    @if($data->penuntutan->p38)
                      <a target='_blank' href="/file/berkas/{{$data->penuntutan->p38->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-12">
                  <label class="form-label" for="surat_auditor">Putusan </label>
                  <br>
                  @if(isset($data))
                    @if($data->penuntutan->putusan)
                      <a target='_blank' href="/file/berkas/{{$data->penuntutan->putusan->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p48">P-48 </label>
                  <input class="form-control" id="p48" type="file" name="p48" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p48'))
                      <div class="error-message">{{ $errors->first('p48') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p48)
                      <a target='_blank' href="/file/berkas/{{$data->p48->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="p48a">P-48A (Asset Tracing) </label>
                  <input class="form-control" id="p48a" type="file" name="p48a" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('p48a'))
                      <div class="error-message">{{ $errors->first('p48a') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->p48a)
                      <a target='_blank' href="/file/berkas/{{$data->p48a->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="d4">D-4 </label>
                  <input class="form-control" id="d4" type="file" name="d4" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('d4'))
                      <div class="error-message">{{ $errors->first('d4') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->d4)
                      <a target='_blank' href="/file/berkas/{{$data->d4->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-6">
                  <label class="form-label" for="pidsus38">Pidsus 38 </label>
                  <input class="form-control" id="pidsus38" type="file" name="pidsus38" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('pidsus38'))
                      <div class="error-message">{{ $errors->first('pidsus38') }}</div>
                  @endif
                  @if(isset($data))
                    @if($data->pidsus38)
                      <a target='_blank' href="/file/berkas/{{$data->pidsus38->file_path}}" class='font-secondary'>Download <i class='fa fa-download' aria-hidden='true'></i></a>
                    @endif
                  @endif
                </div>

                <div class="col-12">
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
                  <label class="form-label" for="catatan">CATATAN PIMPINAN/DISPOSISI </label>
                  <input class="form-control" id="catatan" type="text" placeholder="Catatan" name="catatan" value="{{old('catatan', isset($data) ? $data->catatan : "")}}" @if($is_show) disabled @endif>
                  <div class="invalid-feedback">Please enter your valid </div>
                  <div class="valid-feedback">Looks's Good!</div>
                  @if ($errors->has('catatan'))
                      <div class="error-message">{{ $errors->first('catatan') }}</div>
                  @endif
                </div>

                <div class="col-12">
                  <a class="btn btn-info" href="{{ route("eksekusi.index") }}" type="button">Kembali</a>
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

        getAndSetCurrencyFormat("#denda");
        $("#denda").on("keyup",function(){
          viewCurrency($(this).val(), "#denda");
        });

        getAndSetCurrencyFormat("#uang_pengganti");
        $("#uang_pengganti").on("keyup",function(){
          viewCurrency($(this).val(), "#uang_pengganti");
        });
    </script>
@endpush

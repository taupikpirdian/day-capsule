<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\PenyidikanRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PenyidikanUpdateRequest;
use App\Repositories\Interfaces\ActorRepositoryInterface;
use App\Repositories\Interfaces\PekerjaanRepositoryInterface;
use App\Repositories\Interfaces\PenyidikanRepositoryInterface;
use App\Repositories\Interfaces\FileStorageRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;
use App\Repositories\Interfaces\JenisPerkaraRepositoryInterface;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;
use App\Repositories\Interfaces\AccessDataRepositoryInterface;

class PenyidikanController extends Controller
{
    public $title, $user, $penyelidikanRepo, $jenisPerkaraRepo, $satuanKerjaRepo, $actorRepo, $fileStorageRepo, $pekerjaanRepo, $penyidikanRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit, $accessDataRepo;

    public function __construct(
        PenyelidikanRepositoryInterface $penyelidikanRepo,
        JenisPerkaraRepositoryInterface $jenisPerkaraRepo,
        SatuanKerjaRepositoryInterface $satuanKerjaRepo,
        ActorRepositoryInterface $actorRepo,
        FileStorageRepositoryInterface $fileStorageRepo,
        PekerjaanRepositoryInterface $pekerjaanRepo,
        PenyidikanRepositoryInterface $penyidikanRepo,
        AccessDataRepositoryInterface $accessDataRepo,
    ) {
        $this->title = "Penyidikan";
        $this->penyelidikanRepo = $penyelidikanRepo;
        $this->jenisPerkaraRepo = $jenisPerkaraRepo;
        $this->satuanKerjaRepo = $satuanKerjaRepo;
        $this->actorRepo = $actorRepo;
        $this->fileStorageRepo = $fileStorageRepo;
        $this->pekerjaanRepo = $pekerjaanRepo;
        $this->penyidikanRepo = $penyidikanRepo;
        $this->accessDataRepo = $accessDataRepo;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_LIST_PENYIDIKAN);
            $this->havePermissionDelete = $this->user->can(PERMISSION_DELETE_PENYIDIKAN);
            $this->havePermissionEdit = $this->user->can(PERMISSION_UPDATE_PENYIDIKAN);
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies(PERMISSION_LIST_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'satuans' => $this->satuanKerjaRepo->getAll()
        ];
        return view('admin.penyidikan.index', $data);
    }

    public function datatable(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_LIST_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        if (request()->ajax()) {
            /**
             * column shown in the table
             */
            $columns = [
                'penyidikans.id',
                'institution_category_parts.name',
                'actors.name',
                'penyidikans.no_sp_dik',
                'penyidikans.date_sp_dik',
                'penyidikans.pidsus7',
                'penyidikans.p8',
                'jenis_perkaras.name',
                'actors.tahapan',
                'penyidikans.status',
                'penyidikans.created_at',
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $posts = $this->penyidikanRepo->getAll();
            foreach ($request->columns as $key => $col) {
                $search = $request->input('columns.' . $key . '.search.value');
                if (!is_null($search)) {
                    if ($col['data'] == 'satuan') {
                        $posts = $posts->where('actors.institution_category_part_id', $search);
                    }elseif($col['data'] == 'name'){
                        $posts = $posts->where('actors.name', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'no_sp_dik'){
                        $posts = $posts->where('penyidikans.no_sp_dik', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'date_sp_dik'){
                        $dateRange = splitDateRange($search);
                        if($dateRange){
                            $posts = $posts->whereBetween('date_sp_dik', $dateRange);
                        }
                    }elseif($col['data'] == 'jenis_perkara'){
                        $posts = $posts->where('jenis_perkaras.name', $search);
                    }elseif($col['data'] == 'kasus_posisi'){
                        $posts = $posts->where('actors.kasus_posisi', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'tahapan'){
                        $posts = $posts->where('actors.tahapan', $search);
                    }elseif($col['data'] == 'keterangan'){
                        $posts = $posts->where('penyidikans.keterangan', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'status'){
                        $posts = $posts->where('penyidikans.status', $search);
                    }
                }
            }

            $totalData = $posts->count();
            $posts = $posts->skip($start)->take($limit)->orderBy($order, $dir)->get();
            $data = array();
            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $button = '';
                    if ($this->user->hasRole('kejari')){
                        $button .= '<li class="edit"> <a href="' . url('penuntutan/create') . '?forward=' . urlencode($post->uuid_actor) . '"><i class="fa fa-step-forward"></i></a></li>';
                    }
                    if ($this->havePermissionView) {
                        $button .= '<li class="detail"> <a href="' . route('penyidikan.show', $post->uuid) . '"><i class="fa fa-eye"></i></a></li>';
                    }
                    if ($this->havePermissionEdit) {
                        $button .= '<li class="edit"> <a href="' . route('penyidikan.edit', $post->uuid) . '"><i class="fa fa-pencil-square-o"></i></a></li>';
                    }
                    if ($this->havePermissionDelete) {
                        $button .= '<li class="delete"> <a type="button" onclick="deleteData(\'' . $post->id . '\')"><i class="fa fa-trash"></i></a></li>';
                    }

                    $htmlButton = '<ul class="action"> 
                            '.$button.'
                        </ul>';

                    $color = "background-light-info";
                    $font = "font-info";
                    if ($post->status == SUDAH_DISPOSISI){
                        $color = "background-light-success";
                        $font = "font-success";
                    }else if($post->status == BELUM_DISPOSISI){
                        $color = "background-light-danger";
                        $font = "font-danger";
                    }
                    $status = '<div class="btn ' . $color . ' ' . $font . ' f-w-500">' . strtoupper($post->status ? $post->status : '-') . '</div>';
                    $btnDownloadPidsus = "-";
                    if($post->pidsus7){
                        if($post->pidsus7->file_path){
                            $urlFile = $post->pidsus7->file_path;
                            $btnDownloadPidsus = "<a target='_blank' href=" . "/file/berkas/" . $urlFile . " class='font-secondary'><i class='fa fa-download' aria-hidden='true'></i></a>";
                        }
                    }
                    $btnDownloadP8 = "-";
                    if($post->p8){
                        if($post->p8->file_path){
                            $urlFile = $post->p8->file_path;
                            $btnDownloadP8 = "<a target='_blank' href=" . "/file/berkas/" . $urlFile . " class='font-secondary'><i class='fa fa-download' aria-hidden='true'></i></a>";
                        }
                    }

                    $nestedData['satuan'] = $post->satuan;
                    $nestedData['name'] = $post->name;
                    $nestedData['no_sp_dik'] = $post->no_sp_dik;
                    $nestedData['date_sp_dik'] = formatDateTimeV2($post->date_sp_dik);
                    $nestedData['pidsus7'] = $btnDownloadPidsus;
                    $nestedData['p8'] = $btnDownloadP8;
                    $nestedData['jpu'] = $post->jpu;
                    $nestedData['jenis_perkara'] = $post->jenis_perkara;
                    $nestedData['tahapan'] = $post->tahapan;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = formatDateTime($post->created_at);
                    
                    $nestedData['action'] = $htmlButton;
                    $nestedData['DT_RowIndex'] = ($key + 1) + $start;

                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalData),
                "data"            => $data
            );

            return response()->json($json_data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_CREATE_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        if($request->forward){
            $actor = $this->actorRepo->findOneByUuid($request->forward);
            if(!$actor){
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
            $title = "Create " . $this->title . " (" . $actor->name . ")";
        }else{
            $title = "Create " . $this->title;
        }
        $data = [
            'title' => $title,
            'is_edit' => false,
            'is_show' => false,
            'url_action' => route('penyidikan.store'),
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'pekerjaans' => $this->pekerjaanRepo->getAll(),
            'data' => isset($actor) ? $actor : null,
            'forward' => $request->forward,
            'is_admin' => $this->user->hasRole('admin')
        ];
        return view('admin.penyidikan.create_or_update', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_CREATE_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new PenyidikanRequest())->rules(), (new PenyidikanRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            if($this->user->hasRole('kejati') && !$request->limpah){
                return Redirect::back()->withErrors(['limpah' => 'Limpah harus diisi'])->withInput();
            }

            DB::beginTransaction();

            // get institutions
            $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
            // store actors
            $dtoActor = [
                'name' => $request->name,
                'tahapan' => PENYIDIKAN,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'status' => $request->status,
                'jenis_perkara_prioritas' => $request->jenis_perkara_prioritas,
                'asal_perkara' => $request->asal_perkara,
                'kasus_posisi' => $request->kasus_posisi,
                'pekerjaan_id' => $request->pekerjaan_id,
                'jpu' => $request->jpu,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'limpah' => $request->limpah,
            ];
            if($this->user->hasRole('admin')){
                $dtoActor['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoActor['institution_category_part_id'] = $request->institution_category_part_id;
            }

            if($request->forward == ""){
                $dtoActor['uuid'] = Str::uuid()->toString();
                $actor = $this->actorRepo->store($dtoActor);

                $dtoAccessDataNew = [
                    'actor_id' => $actor->id,
                    'is_limpah' => 0,
                ];
                if($this->user->hasRole('admin')){
                    $dtoAccessDataNew['institution_category_id'] = $satuanKerja->institution_category_id;
                    $dtoAccessDataNew['institution_category_part_id'] = $request->institution_category_part_id;
                }
                $this->accessDataRepo->store($dtoAccessDataNew);
            }else{
                $actorData = $this->actorRepo->findOneByUuid($request->forward);
                if(!$actorData){
                    return redirect()->back()->with('error', 'Data tidak ditemukan');
                }
                $dtoActor['id'] = $actorData->id;
                $actor = $this->actorRepo->update($dtoActor);

                // update status penyelidikan
                $penyelidikan = $this->penyelidikanRepo->findOneByActorId($actor->id);
                $this->penyelidikanRepo->updateStatus($penyelidikan->id, SUDAH_DISPOSISI);
            }

            // limpah
            if($request->limpah && $this->user->hasRole('kejati')){
                $satuanKerjaLimpah = $this->satuanKerjaRepo->findOneByPartId($request->limpah);
                // store access data
                $dtoAccessData = [
                    'actor_id' => $actor->id,
                    'is_limpah' => 1,
                    'institution_category_id' => $satuanKerjaLimpah->institution_category_id,
                    'institution_category_part_id' => $request->limpah
                ];
                $this->accessDataRepo->store($dtoAccessData);
            }

            // store penyidikan
            $dto = [
                'uuid' => Str::uuid()->toString(),
                'actor_id' => $actor->id,
                'no_sp_dik' => $request->no_sp_dik,
                'date_sp_dik' => $request->date_sp_dik,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'status' => BELUM_DISPOSISI,
                'nilai_kerugian' => $request->nilai_kerugian,
                'disertai_tppu' => $request->disertai_tppu ? true : false,
                'perkara_pasal_35_ayat_1' => $request->perkara_pasal_35_ayat_1,
                'korperasi' => $request->korperasi == "on" ? true : false,
                'penyelamatan_kerugian_negara' => nanRpStringToInt($request->penyelamatan_kerugian_negara),
                'kerugian_perekonomian_negara' => $request->kerugian_perekonomian_negara == "on" ? true : false,
            ];
            $penyidikan = $this->penyidikanRepo->store($dto);
            $files = ['pidsus7', 'p8', 'capture_cms_p8', 'tap_tersangka', 'p16', 'p21', 'ba_ekspose', 'sp3'];
            foreach($files as $nameForm){
                if($request->$nameForm){
                    // upload file to gdrive and storage
                    $file = storeFile($request, $actor->uuid, $nameForm, STORAGE_BERKAS);
                    // store data to database
                    $fileType = typeFile($nameForm);
                    if($fileType == ""){
                        return redirect()->back()->with('error', 'File type not found')->withInput();
                    }
                    $dtoStorage = [
                        'file_name' => $file['name_file'],
                        'file_path' => $file['path'],
                        'file_size' => 0,
                        'file_format' => "",
                        'file_type' => $fileType,
                        'data_uuid' => $penyidikan->uuid,
                        'data_type' => PENYIDIKAN,
                        'url_gdrive' => "",
                    ];
                    $this->fileStorageRepo->store($dtoStorage);
                }
            }

            DB::commit();
            return redirect()->route('penyidikan.index')->with('success', 'Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies(PERMISSION_LIST_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Detail " . $this->title,
            'is_edit' => false,
            'is_show' => true,
            'url_action' => "",
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => $this->penyidikanRepo->findOneByUuid($id),
            'pekerjaans' => $this->pekerjaanRepo->getAll(),
            'forward' => "",
            'is_admin' => $this->user->hasRole('admin')
        ];

        return view('admin.penyidikan.create_or_update', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies(PERMISSION_UPDATE_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Edit " . $this->title,
            'is_edit' => true,
            'is_show' => false,
            'url_action' => route('penyidikan.update', $id),
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => $this->penyidikanRepo->findOneByUuid($id),
            'pekerjaans' => $this->pekerjaanRepo->getAll(),
            'forward' => "",
            'is_admin' => $this->user->hasRole('admin')
        ];
        return view('admin.penyidikan.create_or_update', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies(PERMISSION_UPDATE_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            // get penyelidikan
            $penyidikan = $this->penyidikanRepo->findOneByUuid($id);
            $validator = Validator::make($request->all(), (new PenyidikanUpdateRequest())->rules($penyidikan->id), (new PenyidikanUpdateRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            // get institutions
            $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
            // get actor before
            $oldActor = $this->actorRepo->findOne($penyidikan->actor_id);
            if ($oldActor->limpah != $request->limpah) {
                if(!$this->user->hasRole('kejati')){
                    return Redirect::back()->with('error', 'Anda tidak mempunyai akses untuk melakukan update data ini')->withInput();
                }
                $this->actorRepo->updateLimpah($penyidikan->actor_id, $request->limpah);

                // remove access data before
                $this->accessDataRepo->deleteLimpah($penyidikan->actor_id);

                // update access data
                $satuanKerjaLimpah = $this->satuanKerjaRepo->findOneByPartId($request->limpah);
                // store access data
                $dtoAccessData = [
                    'actor_id' => $penyidikan->actor_id,
                    'is_limpah' => 1,
                    'institution_category_id' => $satuanKerjaLimpah->institution_category_id,
                    'institution_category_part_id' => $request->limpah
                ];
                $this->accessDataRepo->store($dtoAccessData);
            }
            
            // store actors
            $dtoActor = [
                'id' => $penyidikan->actor_id,
                'name' => $request->name,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'status' => $request->status,
                'jenis_perkara_prioritas' => $request->jenis_perkara_prioritas,
                'asal_perkara' => $request->asal_perkara,
                'kasus_posisi' => $request->kasus_posisi,
                'pekerjaan_id' => $request->pekerjaan_id,
                'jpu' => $request->jpu,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'limpah' => $request->limpah,
            ];
            if($this->user->hasRole('admin')){
                $dtoActor['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoActor['institution_category_part_id'] = $request->institution_category_part_id;
            }
            $actor = $this->actorRepo->update($dtoActor);
            $dtoPenyidikan = [
                'id' => $penyidikan->id,
                'no_sp_dik' => $request->no_sp_dik,
                'date_sp_dik' => $request->date_sp_dik,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'nilai_kerugian' => $request->nilai_kerugian,
                'disertai_tppu' => $request->disertai_tppu ? true : false,
                'perkara_pasal_35_ayat_1' => $request->perkara_pasal_35_ayat_1,
                'korperasi' => $request->korperasi == "on" ? true : false,
                'penyelamatan_kerugian_negara' => nanRpStringToInt($request->penyelamatan_kerugian_negara),
                'kerugian_perekonomian_negara' => $request->kerugian_perekonomian_negara == "on" ? true : false,
            ];
            $this->penyidikanRepo->update($dtoPenyidikan);

            $files = ['pidsus7', 'p8', 'capture_cms_p8', 'tap_tersangka', 'p16', 'p21', 'ba_ekspose', 'sp3'];
            foreach($files as $nameForm){
                if($request->$nameForm){
                    // upload file to gdrive and storage
                    $file = storeFile($request, $actor->uuid, $nameForm, STORAGE_BERKAS);
                    // store data to database
                    $fileType = typeFile($nameForm);
                    if($fileType == ""){
                        return redirect()->back()->with('error', 'File type not found')->withInput();
                    }
                    $dtoStorage = [
                        'file_name' => $file['name_file'],
                        'file_path' => $file['path'],
                        'file_size' => 0,
                        'file_format' => "",
                        'file_type' => $fileType,
                        'data_uuid' => $penyidikan->uuid,
                        'data_type' => PENYIDIKAN,
                        'url_gdrive' => "",
                    ];

                    $this->fileStorageRepo->store($dtoStorage);
                }
            }

            DB::commit();
            return redirect()->route('penyidikan.index')->with('success', 'Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies(PERMISSION_DELETE_PENYIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            DB::beginTransaction();
            $penyidikan = $this->penyidikanRepo->findOne($id);
            // remove penyelidikans
            $this->penyidikanRepo->delete($id);
            // remove files
            $this->fileStorageRepo->delete($penyidikan->uuid);
            DB::commit();
            return redirect()->route('penyidikan.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }
}

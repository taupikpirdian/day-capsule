<?php

namespace App\Http\Controllers\admin;

use App\Models\AccessData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PenyelidikanRequest;
use App\Http\Requests\UpdatePenyelidikanRequest;
use App\Repositories\Interfaces\ActorRepositoryInterface;
use App\Repositories\Interfaces\AccessDataRepositoryInterface;
use App\Repositories\Interfaces\FileStorageRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;
use App\Repositories\Interfaces\JenisPerkaraRepositoryInterface;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;

class PenyelidikanController extends Controller
{
    public $title, $user, $penyelidikanRepo, $jenisPerkaraRepo, $satuanKerjaRepo, $actorRepo, $fileStorageRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit, $accessDataRepo;

    public function __construct(
        PenyelidikanRepositoryInterface $penyelidikanRepo,
        JenisPerkaraRepositoryInterface $jenisPerkaraRepo,
        SatuanKerjaRepositoryInterface $satuanKerjaRepo,
        ActorRepositoryInterface $actorRepo,
        FileStorageRepositoryInterface $fileStorageRepo,
        AccessDataRepositoryInterface $accessDataRepo,
    ) {
        $this->title = "Penyelidikan";
        $this->penyelidikanRepo = $penyelidikanRepo;
        $this->jenisPerkaraRepo = $jenisPerkaraRepo;
        $this->satuanKerjaRepo = $satuanKerjaRepo;
        $this->actorRepo = $actorRepo;
        $this->fileStorageRepo = $fileStorageRepo;
        $this->accessDataRepo = $accessDataRepo;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_LIST_PENYELIDIKAN);
            $this->havePermissionDelete = $this->user->can(PERMISSION_DELETE_PENYELIDIKAN);
            $this->havePermissionEdit = $this->user->can(PERMISSION_UPDATE_PENYELIDIKAN);
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
        abort_if(Gate::denies(PERMISSION_LIST_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'satuans' => $this->satuanKerjaRepo->getAll()
        ];
        return view('admin.penyelidikan.index', $data);
    }

    public function datatable(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_LIST_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        if (request()->ajax()) {
            /**
             * column shown in the table
             */
            $columns = [
                'penyelidikans.id',
                'institution_category_parts.name',
                'actors.name',
                'penyelidikans.no_sp',
                'penyelidikans.date_sp',
                'penyelidikans.p2',
                'jenis_perkaras.name',
                'penyelidikans.kasus_posisi',
                'actors.tahapan',
                'penyelidikans.keterangan',
                'penyelidikans.status',
                'penyelidikans.created_at',
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $posts = $this->penyelidikanRepo->getAll();
            foreach ($request->columns as $key => $col) {
                $search = $request->input('columns.' . $key . '.search.value');
                if (!is_null($search)) {
                    if ($col['data'] == 'satuan') {
                        $posts = $posts->where('actors.institution_category_part_id', $search);
                    }elseif($col['data'] == 'name'){
                        $posts = $posts->where('actors.name', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'no_sp'){
                        $posts = $posts->where('penyelidikans.no_sp', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'date_sp'){
                        $dateRange = splitDateRange($search);
                        if($dateRange){
                            $posts = $posts->whereBetween('penyelidikans.date_sp', $dateRange);
                        }
                    }elseif($col['data'] == 'jenis_perkara'){
                        $posts = $posts->where('jenis_perkaras.name', $search);
                    }elseif($col['data'] == 'kasus_posisi'){
                        $posts = $posts->where('actors.kasus_posisi', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'tahapan'){
                        $posts = $posts->where('actors.tahapan', $search);
                    }elseif($col['data'] == 'keterangan'){
                        $posts = $posts->where('penyelidikans.keterangan', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'status'){
                        $posts = $posts->where('penyelidikans.status', $search);
                    }
                }
            }

            $totalData = $posts->count();
            $posts = $posts->skip($start)->take($limit)->orderBy($order, $dir)->get();
            $data = array();
            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $button = '';
                    if($post->status == BELUM_DISPOSISI){
                        $button .= '<li class="edit"> <a href="' . url('penyidikan/create') . '?forward=' . urlencode($post->uuid_actor) . '"><i class="fa fa-step-forward"></i></a></li>';
                    }

                    if ($this->havePermissionView) {
                        $button .= '<li class="detail"> <a href="' . route('penyelidikan.show', $post->uuid) . '"><i class="fa fa-eye"></i></a></li>';
                    }
                    if ($this->havePermissionEdit) {
                        $button .= '<li class="edit"> <a href="' . route('penyelidikan.edit', $post->uuid) . '"><i class="fa fa-pencil-square-o"></i></a></li>';
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
                    $btnDownload = "-";
                    if($post->fileP2){
                        if($post->fileP2->file_path){
                            $urlFile = $post->fileP2->file_path;
                            $btnDownload = "<a target='_blank' href=" . "/file/berkas/" . $urlFile . " class='font-secondary'><i class='fa fa-download' aria-hidden='true'></i></a>";
                        }
                    }else{
                        $btnDownload = "-";
                    }

                    $nestedData['satuan'] = $post->satuan;
                    $nestedData['name'] = $post->name;
                    $nestedData['no_sp'] = $post->no_sp;
                    $nestedData['date_sp'] = formatDateTimeV2($post->date_sp);
                    $nestedData['p2'] = $btnDownload;
                    $nestedData['jenis_perkara'] = $post->jenis_perkara;
                    $nestedData['kasus_posisi'] = $post->kasus_posisi;
                    $nestedData['tahapan'] = $post->tahapan;
                    $nestedData['keterangan'] = $post->keterangan;
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
    public function create()
    {
        abort_if(Gate::denies(PERMISSION_CREATE_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Create " . $this->title,
            'is_edit' => false,
            'is_show' => false,
            'url_action' => route('penyelidikan.store'),
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'is_admin' => $this->user->hasRole('admin'),
        ];
        return view('admin.penyelidikan.create_or_update', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_CREATE_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new PenyelidikanRequest())->rules(), (new PenyelidikanRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();

            // get institutions
            $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
            // store actors
            $dtoActor = [
                'uuid' => Str::uuid()->toString(),
                'name' => $request->name,
                'tahapan' => PENYELIDIKAN,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'status' => $request->status,
                'jenis_perkara_prioritas' => $request->jenis_perkara_prioritas,
                'asal_perkara' => $request->asal_perkara,
                'kasus_posisi' => $request->kasus_posisi,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
            ];
            if($this->user->hasRole('admin')){
                $dtoActor['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoActor['institution_category_part_id'] = $request->institution_category_part_id;
            }
            
            $actor = $this->actorRepo->store($dtoActor);
            // store penyelidikans
            $dto = [
                'uuid' => Str::uuid()->toString(),
                'actor_id' => $actor->id,
                'no_sp' => $request->no_sp,
                'date_sp' => $request->date_sp,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'status' => BELUM_DISPOSISI,
                'pnbp' => nanRpStringToInt($request->pnbp),
            ];
            $penyelidikan = $this->penyelidikanRepo->store($dto);

            $files = ['p2', 'capture_cms_p2', 'sp3'];
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
                        'data_uuid' => $penyelidikan->uuid,
                        'data_type' => PENYELIDIKAN,
                        'url_gdrive' => "",
                    ];
    
                    $this->fileStorageRepo->store($dtoStorage);
                }
            }

            // store access data
            $dtoAccessData = [
                'actor_id' => $actor->id,
                'is_limpah' => 0,
            ];
            if($this->user->hasRole('admin')){
                $dtoAccessData['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoAccessData['institution_category_part_id'] = $request->institution_category_part_id;
            }
            $this->accessDataRepo->store($dtoAccessData);
            DB::commit();
            return redirect()->route('penyelidikan.index')->with('success', 'Data Berhasil Disimpan');
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
        abort_if(Gate::denies(PERMISSION_LIST_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Detail " . $this->title,
            'is_edit' => false,
            'is_show' => true,
            'url_action' => "",
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => $this->penyelidikanRepo->findOneByUuid($id),
            'is_admin' => $this->user->hasRole('admin'),
        ];
        return view('admin.penyelidikan.create_or_update', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies(PERMISSION_UPDATE_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Edit " . $this->title,
            'is_edit' => true,
            'is_show' => false,
            'url_action' => route('penyelidikan.update', $id),
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => $this->penyelidikanRepo->findOneByUuid($id),
            'is_admin' => $this->user->hasRole('admin'),
        ];
        return view('admin.penyelidikan.create_or_update', $data);
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
        abort_if(Gate::denies(PERMISSION_UPDATE_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            // get penyelidikan
            $penyelidikan = $this->penyelidikanRepo->findOneByUuid($id);
            $validator = Validator::make($request->all(), (new UpdatePenyelidikanRequest())->rules($penyelidikan->id), (new UpdatePenyelidikanRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();

            // get institutions
            $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
            // store actors
            $dtoActor = [
                'id' => $penyelidikan->actor_id,
                'name' => $request->name,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'status' => $request->status,
                'jenis_perkara_prioritas' => $request->jenis_perkara_prioritas,
                'asal_perkara' => $request->asal_perkara,
                'kasus_posisi' => $request->kasus_posisi,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
            ];
            if($this->user->hasRole('admin')){
                $dtoActor['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoActor['institution_category_part_id'] = $request->institution_category_part_id;
            }

            $actor = $this->actorRepo->update($dtoActor);
            $dtoPenyelidikan = [
                'id' => $penyelidikan->id,
                'no_sp' => $request->no_sp,
                'date_sp' => $request->date_sp,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'pnbp' => nanRpStringToInt($request->pnbp),
            ];
            $this->penyelidikanRepo->update($dtoPenyelidikan);

            $files = ['p2', 'capture_cms_p2', 'sp3'];
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
                        'data_uuid' => $penyelidikan->uuid,
                        'data_type' => PENYELIDIKAN,
                        'url_gdrive' => "",
                    ];
    
                    $this->fileStorageRepo->store($dtoStorage);
                }
            }

            DB::commit();
            return redirect()->route('penyelidikan.index')->with('success', 'Data Berhasil Disimpan');
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
        abort_if(Gate::denies(PERMISSION_DELETE_PENYELIDIKAN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            DB::beginTransaction();
            $penyelidikan = $this->penyelidikanRepo->findOne($id);
            // remove actors
            $this->actorRepo->delete($penyelidikan->actor_id);
            // remove penyelidikans
            $this->penyelidikanRepo->delete($id);
            // remove files
            $this->fileStorageRepo->delete($penyelidikan->uuid);
            // remove access
            $this->accessDataRepo->delete($penyelidikan->actor_id);
            DB::commit();
            return redirect()->route('penyelidikan.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }
}

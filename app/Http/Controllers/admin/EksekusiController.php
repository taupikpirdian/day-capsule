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
use App\Http\Requests\EksekusiRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EksekusiUpdateRequest;
use App\Repositories\Interfaces\ActorRepositoryInterface;
use App\Repositories\Interfaces\EksekusiRepositoryInterface;
use App\Repositories\Interfaces\PekerjaanRepositoryInterface;
use App\Repositories\Interfaces\PenuntutanRepositoryInterface;
use App\Repositories\Interfaces\PenyidikanRepositoryInterface;
use App\Repositories\Interfaces\FileStorageRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;
use App\Repositories\Interfaces\JenisPerkaraRepositoryInterface;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;

class EksekusiController extends Controller
{
    public $title, $user, $penyelidikanRepo, $jenisPerkaraRepo, $satuanKerjaRepo, $actorRepo, $fileStorageRepo, $pekerjaanRepo, $penyidikanRepo, $eksekusiRepo, $penuntutanRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;

    public function __construct(
        PenyelidikanRepositoryInterface $penyelidikanRepo,
        JenisPerkaraRepositoryInterface $jenisPerkaraRepo,
        SatuanKerjaRepositoryInterface $satuanKerjaRepo,
        ActorRepositoryInterface $actorRepo,
        FileStorageRepositoryInterface $fileStorageRepo,
        PekerjaanRepositoryInterface $pekerjaanRepo,
        PenyidikanRepositoryInterface $penyidikanRepo,
        EksekusiRepositoryInterface $eksekusiRepo,
        PenuntutanRepositoryInterface $penuntutanRepo,
    ) {
        $this->title = "Eksekusi";
        $this->penyelidikanRepo = $penyelidikanRepo;
        $this->jenisPerkaraRepo = $jenisPerkaraRepo;
        $this->satuanKerjaRepo = $satuanKerjaRepo;
        $this->actorRepo = $actorRepo;
        $this->fileStorageRepo = $fileStorageRepo;
        $this->pekerjaanRepo = $pekerjaanRepo;
        $this->penyidikanRepo = $penyidikanRepo;
        $this->eksekusiRepo = $eksekusiRepo;
        $this->penuntutanRepo = $penuntutanRepo;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_LIST_EKSEKUSI);
            $this->havePermissionDelete = $this->user->can(PERMISSION_DELETE_EKSEKUSI);
            $this->havePermissionEdit = $this->user->can(PERMISSION_UPDATE_EKSEKUSI);
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
        abort_if(Gate::denies(PERMISSION_LIST_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'satuans' => $this->satuanKerjaRepo->getAll()
        ];
        return view('admin.eksekusi.index', $data);
    }

    public function datatable(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_LIST_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        if (request()->ajax()) {
            /**
             * column shown in the table
             */
            $columns = [
                'penuntutans.id',
                'institution_category_parts.name',
                'actors.name',
                'actors.asal_perkara',
                'p2',
                'pidsus7',
                'p8',
                'tap_tersangka',
                'p16',
                'p21',
                'surat_auditor',
                'putusan',
                'd4',
                'p38',
                'p48',
                'eksekusis.pidana_badan',
                'eksekusis.denda',
                'eksekusis.uang_pengganti',
                'eksekusis.barang_bukti',
                'actors.tahapan',
                'penuntutans.keterangan',
                'penuntutans.status',
                'eksekusis.created_at',
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $posts = $this->eksekusiRepo->getAll();
            foreach ($request->columns as $key => $col) {
                $search = $request->input('columns.' . $key . '.search.value');
                if (!is_null($search)) {
                    if ($col['data'] == 'satuan') {
                        $posts = $posts->where('actors.institution_category_part_id', $search);
                    }elseif($col['data'] == 'name'){
                        $posts = $posts->where('actors.name', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'jenis_perkara'){
                        $posts = $posts->where('jenis_perkaras.name', $search);
                    }
                }
            }

            $totalData = $posts->count();
            $posts = $posts->skip($start)->take($limit)->orderBy($order, $dir)->get();
            $data = array();
            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $button = '';
                    if ($this->havePermissionView) {
                        $button .= '<li class="detail"> <a href="' . route('eksekusi.show', $post->uuid) . '"><i class="fa fa-eye"></i></a></li>';
                    }
                    if ($this->havePermissionEdit) {
                        $button .= '<li class="edit"> <a href="' . route('eksekusi.edit', $post->uuid) . '"><i class="fa fa-pencil-square-o"></i></a></li>';
                    }
                    $htmlButton = '<ul class="action"> 
                            '.$button.'
                        </ul>';

                    $color = "background-light-info";
                    $font = "font-info";
                    if ($post->status == MEMENUHI){
                        $color = "background-light-success";
                        $font = "font-success";
                    }else if($post->status == TIDAK_MEMENUHI){
                        $color = "background-light-danger";
                        $font = "font-danger";
                    }
                    $status = '<div class="btn ' . $color . ' ' . $font . ' f-w-500">' . strtoupper($post->status ? $post->status : '-') . '</div>';
                    $btnDownloadp2 = "-";
                    if($post->penyelidikan){
                        if($post->penyelidikan->fileP2){
                            $urlFile = $post->penyelidikan->fileP2->file_path;
                            $btnDownloadp2 = fullPath($urlFile);
                        }
                    }
                    $btnDownloadpidsus7 = "-";
                    if($post->penyidikan){
                        if($post->penyidikan->pidsus7){
                            $urlFile = $post->penyidikan->pidsus7->file_path;
                            $btnDownloadpidsus7 = fullPath($urlFile);
                        }
                    }
                    $btnDownloadp8 = "-";
                    if($post->penyidikan){
                        if($post->penyidikan->p8){
                            $urlFile = $post->penyidikan->p8->file_path;
                            $btnDownloadp8 = fullPath($urlFile);
                        }
                    }
                    $btnDownloadtapTersangka = "-";
                    if($post->penyidikan){
                        if($post->penyidikan->tapTersangka){
                            $urlFile = $post->penyidikan->tapTersangka->file_path;
                            $btnDownloadtapTersangka = fullPath($urlFile);
                        }
                    }
                    $btnDownloadp16 = "-";
                    if($post->penyidikan){
                        if($post->penyidikan->p16){
                            $urlFile = $post->penyidikan->p16->file_path;
                            $btnDownloadp16 = fullPath($urlFile);
                        }
                    }
                    $btnDownloadp21 = "-";
                    if($post->penyidikan){
                        if($post->penyidikan->p21){
                            $urlFile = $post->penyidikan->p21->file_path;
                            $btnDownloadp21 = fullPath($urlFile);
                        }
                    }
                    $btnDownloadsuratAuditor = "-";
                    if($post->penuntutan){
                        if($post->penuntutan->suratAuditor){
                            $urlFile = $post->penuntutan->suratAuditor->file_path;
                            $btnDownloadsuratAuditor = fullPath($urlFile);
                        }
                    }
                    $btnPutusan = "-";
                    if($post->penuntutan){
                        if($post->penuntutan->putusan){
                            $urlFile = $post->penuntutan->putusan->file_path;
                            $btnPutusan = fullPath($urlFile);
                        }
                    }
                    $btnP48 = "-";
                    if($post->p48){
                        if($post->p48->file_path){
                            $urlFile = $post->p48->file_path;
                            $btnP48 = fullPath($urlFile);
                        }
                    }
                    $btnP48a = "-";
                    if($post->p48a){
                        if($post->p48a->file_path){
                            $urlFile = $post->p48a->file_path;
                            $btnP48a = fullPath($urlFile);
                        }
                    }
                    $d4 = "-";
                    if($post->d4){
                        if($post->d4->file_path){
                            $urlFile = $post->d4->file_path;
                            $d4 = fullPath($urlFile);
                        }
                    }

                    $nestedData['satuan'] = $post->satuan;
                    $nestedData['name'] = $post->name;
                    $nestedData['asal_perkara'] = $post->asal_perkara;
                    $nestedData['p2'] = $btnDownloadp2;
                    $nestedData['pidsus7'] = $btnDownloadpidsus7;
                    $nestedData['p8'] = $btnDownloadp8;
                    $nestedData['tap_tersangka'] = $btnDownloadtapTersangka;
                    $nestedData['p16'] = $btnDownloadp16;
                    $nestedData['p21'] = $btnDownloadp21;
                    $nestedData['surat_auditor'] = $btnDownloadsuratAuditor;
                    $nestedData['putusan'] = $btnPutusan;
                    $nestedData['d4'] = $d4;
                    $nestedData['p48'] = $btnP48;
                    $nestedData['p48a'] = $btnP48a;
                    $nestedData['pidana_badan'] = $post->pidana_badan;
                    $nestedData['denda'] = formatRupiah($post->denda);
                    $nestedData['uang_pengganti'] = formatRupiah($post->uang_pengganti);
                    $nestedData['barang_bukti'] = $post->barang_bukti;
                    $nestedData['tahapan_penanganan'] = $post->tahapan;
                    $nestedData['keterangan'] = $post->jenis_perkara;
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
        abort_if(Gate::denies(PERMISSION_CREATE_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        if($request->forward){
            $actor = $this->actorRepo->findOneByUuidWithJoin($request->forward);
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
            'url_action' => route('eksekusi.store'),
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => isset($actor) ? $actor : null,
            'forward' => $request->forward,
            'is_admin' => $this->user->hasRole('admin')
        ];
        return view('admin.eksekusi.create_or_update', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_CREATE_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new EksekusiRequest())->rules(), (new EksekusiRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            // get institutions
            $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
            $actorData = $this->actorRepo->findOneByUuid($request->forward);
            if(!$actorData){
                return redirect()->back()->with('error', 'Data tidak ditemukan')->withInput();
            }

            // store actors
            $dtoActor = [
                'id' => $actorData->id,
                'name' => $request->name,
                'tahapan' => EKSEKUSI,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'status' => $request->status,
                'asal_perkara' => $request->asal_perkara,
                'kasus_posisi' => $request->kasus_posisi,
                'jpu' => $request->jpu,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
            ];
            if($this->user->hasRole('admin')){
                $dtoActor['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoActor['institution_category_part_id'] = $request->institution_category_part_id;
            }

            $actor = $this->actorRepo->update($dtoActor);
            // update status penuntutan
            $penuntutan = $this->penuntutanRepo->findOneByActorId($actor->id);
            $this->penuntutanRepo->updateStatus($penuntutan->id, SUDAH_DISPOSISI);
            
            // store eksekusi
            $dto = [
                'uuid' => Str::uuid()->toString(),
                'actor_id' => $actor->id,
                'pidana_badan' => $request->pidana_badan,
                'subsider_pidana_badan' => $request->subsider_pidana_badan,
                'denda' => nanRpStringToInt($request->denda),
                'subsider_denda' => $request->subsider_denda,
                'uang_pengganti' => nanRpStringToInt($request->uang_pengganti),
                'barang_bukti' => $request->barang_bukti,
                'pelelangan_barang_sitaan' => $request->pelelangan_benda_sitaan,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'status' => BELUM_DISPOSISI,
            ];
            $eksekusi = $this->eksekusiRepo->store($dto);

            $files = ['p48', 'p48a', 'd4', 'pidsus38', 'sp3'];
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
                        'data_uuid' => $eksekusi->uuid,
                        'data_type' => EKSEKUSI,
                        'url_gdrive' => "",
                    ];

                    $this->fileStorageRepo->store($dtoStorage);
                }
            }

            DB::commit();
            return redirect()->route('eksekusi.index')->with('success', 'Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
        abort_if(Gate::denies(PERMISSION_LIST_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Detail " . $this->title,
            'is_edit' => false,
            'is_show' => true,
            'url_action' => "",
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => $this->eksekusiRepo->findOneByUuid($id),
            'forward' => "",
            'is_admin' => $this->user->hasRole('admin')
        ];
        return view('admin.eksekusi.create_or_update', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies(PERMISSION_UPDATE_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Edit " . $this->title,
            'is_edit' => true,
            'is_show' => false,
            'url_action' => route('eksekusi.update', $id),
            'jenis_perkaras' => $this->jenisPerkaraRepo->getAll(),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'data' => $this->eksekusiRepo->findOneByUuid($id),
            'forward' => "",
            'is_admin' => $this->user->hasRole('admin')
        ];
        return view('admin.eksekusi.create_or_update', $data);
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
        abort_if(Gate::denies(PERMISSION_UPDATE_EKSEKUSI), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new EksekusiUpdateRequest())->rules(), (new EksekusiUpdateRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            // get institutions
            $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
            $eksekusi = $this->eksekusiRepo->findOneByUuid($id);
            
            // store actors
            $dtoActor = [
                'id' => $eksekusi->actor_id,
                'name' => $request->name,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'status' => $request->status,
                'asal_perkara' => $request->asal_perkara,
                'kasus_posisi' => $request->kasus_posisi,
                'jpu' => $request->jpu,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
            ];
            if($this->user->hasRole('admin')){
                $dtoActor['institution_category_id'] = $satuanKerja->institution_category_id;
                $dtoActor['institution_category_part_id'] = $request->institution_category_part_id;
            }
            
            $actor = $this->actorRepo->update($dtoActor);
            
            // store eksekusi
            $dto = [
                'id' => $eksekusi->id,
                'pidana_badan' => $request->pidana_badan,
                'subsider_pidana_badan' => $request->subsider_pidana_badan,
                'denda' => nanRpStringToInt($request->denda),
                'subsider_denda' => $request->subsider_denda,
                'uang_pengganti' => nanRpStringToInt($request->uang_pengganti),
                'barang_bukti' => $request->barang_bukti,
                'pelelangan_barang_sitaan' => $request->pelelangan_benda_sitaan,
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
            ];
            $eksekusi = $this->eksekusiRepo->update($dto);
            $files = ['p48', 'p48a', 'd4', 'pidsus38', 'sp3'];
            foreach($files as $nameForm){
                if($request->$nameForm){
                    // upload file to gdrive and storage
                    $file = storeFile($request, $actor->uuid, $nameForm, STORAGE_BERKAS);
                    // store data t
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
                        'data_uuid' => $eksekusi->uuid,
                        'data_type' => EKSEKUSI,
                        'url_gdrive' => "",
                    ];
                    $this->fileStorageRepo->store($dtoStorage);
                }
            }

            DB::commit();
            return redirect()->route('eksekusi.index')->with('success', 'Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error')->withInput();
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
        //
    }
}

<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LapduRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\LapduRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;

class LapduController extends Controller
{
    public $title, $user, $lapduRepo, $satuanKerjaRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;

    public function __construct(
        LapduRepositoryInterface $lapduRepo,
        SatuanKerjaRepositoryInterface $satuanKerjaRepo,
    ) {
        $this->title = "LAPDU";
        $this->lapduRepo = $lapduRepo;
        $this->satuanKerjaRepo = $satuanKerjaRepo;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_LIST_LAPDU);
            $this->havePermissionDelete = $this->user->can(PERMISSION_CREATE_LAPDU);
            $this->havePermissionEdit = $this->user->can(PERMISSION_UPDATE_LAPDU);
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
        abort_if(Gate::denies(PERMISSION_LIST_LAPDU), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'satuans' => $this->satuanKerjaRepo->getAll()
        ];
        return view('admin.lapdu.index', $data);
    }

    public function datatable(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_LIST_LAPDU), Response::HTTP_FORBIDDEN, 'Forbidden');
        if (request()->ajax()) {
            /**
             * column shown in the table
             */
            $columns = [
                'lapduses.id',
                'satuan',
                'lapduses.sender_name',
                'lapduses.kasus_posisi',
                'lapduses.status',
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $posts = $this->lapduRepo->getAll();
            foreach ($request->columns as $key => $col) {
                $search = $request->input('columns.' . $key . '.search.value');
                if (!is_null($search)) {
                    if ($col['data'] == 'sender_name') {
                        $posts = $posts->where('sender_name', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'kasus_posisi'){
                        $posts = $posts->where('kasus_posisi', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'status'){
                        $posts = $posts->where('status', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'satuan'){
                        $posts = $posts->where('institution_category_part_id', $search);
                    }
                }
            }
            $totalData = $posts->count();
            $posts = $posts->skip($start)->take($limit)->orderBy($order, $dir)->get();
            $data = array();

            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $button = '';
                    if ($post->status == PENDING){
                        if ($this->user->hasRole('admin')) {
                            $button .= '<li class="edit"> <a type="button" onclick="approveData(\'' . $post->id . '\')"><i class="fa fa-check-square-o" aria-hidden="true"></i></a></li>';
                            $button .= '<li class="edit"> <a type="button" onclick="rejectData(\'' . $post->id . '\')"><i style="color: red" class="fa fa-window-close-o" aria-hidden="true"></i></a></li>';
                        }
                    }
                    if ($this->havePermissionDelete) {
                        $button .= '<li class="delete"> <a type="button" onclick="deleteData(\'' . $post->id . '\')"><i class="fa fa-trash"></i></a></li>';
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
                    $status = '<div class="btn ' . $color . ' ' . $font . ' f-w-500">' . strtoupper($post->status) . '</div>';
                    
                    $nestedData['satuan'] = $post->satuanKerja ? $post->satuanKerja->name : '';
                    $nestedData['sender_name'] = $post->sender_name;
                    $nestedData['kasus_posisi'] = $post->kasus_posisi;
                    $nestedData['status'] = $status;
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
        abort_if(Gate::denies(PERMISSION_CREATE_LAPDU), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'is_edit' => false,
            'is_show' => false,
            'url_action' => route('lapdu.store'),
            'satuan_kerjas' => $this->satuanKerjaRepo->getAll(),
            'is_admin' => $this->user->hasRole('admin'),
        ];

        return view('admin.lapdu.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_CREATE_LAPDU), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new LapduRequest())->rules(), (new LapduRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            $dto = [
                'sender_name' => $request->sender_name,
                'kasus_posisi' => $request->kasus_posisi,
                'status' => PENDING,
            ];

            if($this->user->hasRole('admin')){
                $satuanKerja = $this->satuanKerjaRepo->findOneByPartId($request->institution_category_part_id);
                $dto['institution_category_id'] = $satuanKerja->institution_category_id;
                $dto['institution_category_part_id'] = $request->institution_category_part_id;
            }

            $this->lapduRepo->store($dto);
            DB::commit();
            return redirect()->route('lapdu.index')->with('success', 'Data Berhasil Disimpan');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        abort_if(Gate::denies(PERMISSION_UPDATE_LAPDU), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            DB::beginTransaction();
            $data = $this->lapduRepo->findOne($id);
            if($data){
                $status = $request->status == "approve" ? MEMENUHI : TIDAK_MEMENUHI;
                $this->lapduRepo->updateStatus($id, $status);
            }else{
                return Redirect::back()->with('error', 'Data Not Found');
            }
            DB::commit();
            return redirect()->route('lapdu.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
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
        abort_if(Gate::denies(PERMISSION_DELETE_LAPDU), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            DB::beginTransaction();
            $data = $this->lapduRepo->findOne($id);
            if($data){
                $this->lapduRepo->delete($id);
            }
            DB::commit();
            return redirect()->route('lapdu.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }
}

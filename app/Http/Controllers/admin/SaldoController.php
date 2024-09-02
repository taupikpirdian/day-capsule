<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SaldoRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\SaldoRepositoryInterface;

class SaldoController extends Controller
{
    public $title, $saldoRepo, $user;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;

    public function __construct(
        SaldoRepositoryInterface $saldoRepo,
    ) {
        $this->title = "Saldo";
        $this->saldoRepo = $saldoRepo;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_LIST_SALDO);
            $this->havePermissionEdit = $this->user->can(PERMISSION_UPDATE_SALDO);
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
        $data = [
            'data' => $this->saldoRepo->findOne(),
            'url_action' => route('saldo.update')
        ];
        return view('admin.saldo.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), (new SaldoRequest())->rules(), (new SaldoRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            $dto = [
                'penyelidikan' => $request->penyelidikan,
                'penyidikan' => $request->penyidikan,
                'penuntutan' => $request->penuntutan,
                'eksekusi' => $request->eksekusi,
            ];

            $data =  $this->saldoRepo->findOne();
            if($data){
                $this->saldoRepo->update($dto);
            }else{
                $this->saldoRepo->create($dto);
            }
            DB::commit();
            return Redirect::back()->with('success', 'Data Berhasil Disimpan');
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
        //
    }
}

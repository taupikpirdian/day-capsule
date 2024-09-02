<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class RoleController extends Controller
{
    public $title, $roleRepo, $permissionRepo;

    public function __construct(
        RoleRepositoryInterface $roleRepo,
        PermissionRepositoryInterface $permissionRepo
    ) {
        $this->title = "Role";
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'datas' => $this->roleRepo->getAll(),
        ];

        return view('admin.role.index', $data);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $role = $this->roleRepo->findOne($id);
        $arrPermission = [];
        foreach($role->permissions as $per){
            array_push($arrPermission, $per->name);
        }
        $data = [
            'title' => "Edit " . $this->title,
            'data' => $role,
            'permissions' => $this->permissionRepo->getAll(),
            'arr_permission' => $arrPermission
        ];

        return view('admin.role.edit', $data);
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
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new RoleRequest())->rules(), (new RoleRequest())->messages());
            if ($validator->fails()) {
                Log::error("bad request: " [$validator->getMessageBag()->toArray()]);
                return Redirect::back()->with('error', 'bad request');
            }
            DB::beginTransaction();
            // update permission
            $this->permissionRepo->updatePermissionRole($id, $request->permissions);
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Data Berhasil Disimpan');
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

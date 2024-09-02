<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    public $title, $userRepo, $user, $roleRepo;

    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;

    public function __construct(
        UserRepositoryInterface $userRepo,
        RoleRepositoryInterface $roleRepo,
    ) {
        $this->title = "User";
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_LIST_USER);
            $this->havePermissionDelete = $this->user->can(PERMISSION_DELETE_USER);
            $this->havePermissionEdit = $this->user->can(PERMISSION_UPDATE_USER);
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
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
        ];

        return view('admin.user.index', $data);
    }

    public function datatable(Request $request)
    {
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        if (request()->ajax()) {
            /**
             * column shown in the table
             */
            $columns = [
                'users.id',
                'users.name',
                'users.email',
                'roles.name',
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $posts = $this->userRepo->getAll();
            foreach ($request->columns as $key => $col) {
                $search = $request->input('columns.' . $key . '.search.value');
                if (!is_null($search)) {
                    if ($col['data'] == 'name') {
                        $posts = $posts->where('name', 'like', '%' . $search . '%');
                    }elseif($col['data'] == 'email'){
                        $posts = $posts->where('email', 'like', '%' . $search . '%');
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
                        $button .= '<li class="detail"> <a href="' . route('users.show', $post->id) . '"><i class="fa fa-eye"></i></a></li>';
                    }
                    if ($this->havePermissionEdit) {
                        $button .= '<li class="edit"> <a href="' . route('users.edit', $post->id) . '"><i class="fa fa-pencil-square-o"></i></a></li>';
                    }
                    if ($this->havePermissionDelete) {
                        $button .= '<li class="delete"> <a type="button" onclick="deleteData(\'' . $post->id . '\')"><i class="fa fa-trash"></i></a></li>';
                    }

                    $htmlButton = '<ul class="action"> 
                            '.$button.'
                        </ul>';

                    $nestedData['name'] = $post->name;
                    $nestedData['email'] = $post->email;
                    $nestedData['role'] = $post->roles ? $post->roles->pluck('name') : "";
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
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'roles' => $this->roleRepo->getAll(),
            'is_edit' => false,
            'url_action' => route('users.store')
        ];

        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new UserRequest())->rules(), (new UserRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            $dto = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            $user = $this->userRepo->store($dto);
            $user->assignRole($request->role);
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
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
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => "Edit " . $this->title,
            'roles' => $this->roleRepo->getAll(),
            'data' => $this->userRepo->findOne($id),
        ];

        return view('admin.user.show', $data);
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
        $data = [
            'title' => "Edit " . $this->title,
            'roles' => $this->roleRepo->getAll(),
            'data' => $this->userRepo->findOne($id),
            'is_edit' => true,
            'url_action' => route('users.update', $id)
        ];

        return view('admin.user.create', $data);
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
            $validator = Validator::make($request->all(), (new UserUpdateRequest())->rules($id), (new UserUpdateRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            $dto = [
                'id' => $id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : "",
            ];
            $user = $this->userRepo->update($dto);
            $user->syncRoles([]);
            $user->assignRole($request->role);
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Data Berhasil Disimpan');
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
        abort_if(!Auth::user()->hasRole(ROLE_ADMIN), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            DB::beginTransaction();
            $user = $this->userRepo->findOne($id);
            if($user){
                $user->syncRoles([]);
                $this->userRepo->delete($id);
            }
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }

    public function profile()
    {
        $data = [
            'url_action' => route('users.profile', $this->user->id)
        ];
        return view('admin.user.profile', $data);
    }

    public function profileUpdate(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), (new UserUpdateProfileRequest())->rules($id), (new UserUpdateProfileRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            $dto = [
                'id' => $id,
                'name' => $request->name,
                'password' => $request->password ? Hash::make($request->password) : "",
            ];
            $this->userRepo->update($dto);
            DB::commit();
            return redirect()->route('users.profile.index')->with('success', 'Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }
}

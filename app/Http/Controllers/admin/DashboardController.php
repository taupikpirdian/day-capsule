<?php

namespace App\Http\Controllers\admin;

use App\Models\Eksekusi;
use App\Models\Penuntutan;
use App\Models\Penyidikan;
use App\Models\Penyelidikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\ActorRepositoryInterface;

class DashboardController extends Controller
{
    public $title, $user, $actorRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;
    
    public function __construct(
        ActorRepositoryInterface $actorRepo,
    ) {
        $this->title = "Dashboard";
        $this->actorRepo = $actorRepo;

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
        $data = [
            'title' => $this->title,
            'actors' => $this->actorRepo->getAll()->get()
        ];
        return view('admin.dashboard', $data);
    }

    public function overview()
    {
        $data = [
            'total_penyelidikan' => Penyelidikan::count(),
            'total_penyidikan' => Penyidikan::count(),
            'total_tuntutan' => Penuntutan::count(),
            'total_eksekusi' => Eksekusi::count(),
        ];
        $data['array_value'] = array_values($data);
        $data['total'] = $data['total_penyelidikan'] + $data['total_penyidikan'] + $data['total_tuntutan'] + $data['total_eksekusi'];
        return response(json_encode($data), 200);
    }
}

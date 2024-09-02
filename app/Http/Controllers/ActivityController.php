<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ActivityRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public $title, $user;
    public $repoActivity;
    public $repoTag;
    public function __construct(
        ActivityRepositoryInterface $repoActivity,
        TagRepositoryInterface $repoTag,
    ) {
        $this->title = "Activity";
        $this->repoActivity = $repoActivity;
        $this->repoTag = $repoTag;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
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
        abort_if(Gate::denies(PERMISSION_LIST_ACTIVITY), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = [
            'title' => $this->title,
            'data_titles' => $this->repoActivity->getTitles(),
            'data_tags' => $this->repoTag->getTag(),
        ];
        return view('activity.index', $data);
    }
    
    public function datatable(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_LIST_ACTIVITY), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data = $this->repoActivity->datatable($request);
        $totalRecords = $this->repoActivity->totalRecords($request);
        
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->setTotalRecords($totalRecords)
            ->addColumn('action', function ($data) {
                $button = '';
                $button .= '<li class="delete"> <a type="button" onclick="deleteData(\'' . $data->id . '\')"><i class="fa fa-trash"></i></a></li>';

                $htmlButton = '<ul class="action"> 
                        '.$button.'
                    </ul>';
                return $htmlButton;
            })
            ->addColumn('date', function ($data) {
                return dateToHumanReadable($data->date);
            })
            ->toJson();

            
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
        abort_if(Gate::denies(PERMISSION_CREATE_ACTIVITY), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            $validator = Validator::make($request->all(), (new ActivityRequest())->rules(), (new ActivityRequest())->messages());
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            $dto = [
                'user_id' => $this->user->id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'desc' => $request->desc,
                'date' => $request->date,
                'time' => $request->time,
                'time_spent' => convertToMinutes($request->time_spent),
            ];
            $activity = $this->repoActivity->store($dto);

            $tags = $request->tag;
            foreach ($tags as $tag) {
                $arr = [
                    'title' => $tag,
                    'slug' => Str::slug($tag),
                    'data_id' => $activity->id,
                    'data_type' => 'activity',
                ];
                $this->repoTag->store($arr);
            }
            DB::commit();

            return redirect()->route('activity.index')->with('success', 'Data Berhasil Disimpan');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies(PERMISSION_DELETE_ACTIVITY), Response::HTTP_FORBIDDEN, 'Forbidden');
        try {
            DB::beginTransaction();
            $this->repoActivity->delete($id);
            $this->repoTag->delete($id);
            DB::commit();
            return redirect()->route('activity.index')->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return Redirect::back()->with('error', 'Internal Server Error');
        }
    }

    public function titles()
    {
        $datas = $this->repoActivity->getTitles();
        $arr = [];
        foreach ($datas as $data) {
            array_push($arr, $data->title);
        }
        return $arr;
    }
}

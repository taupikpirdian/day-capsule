<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Interfaces\LapduRepositoryInterface;
use App\Repositories\Interfaces\SaldoRepositoryInterface;
use App\Repositories\Interfaces\EksekusiRepositoryInterface;
use App\Repositories\Interfaces\PenuntutanRepositoryInterface;
use App\Repositories\Interfaces\PenyidikanRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;

class ReportController extends Controller
{
    public $title, $user, $lapduRepo, $satuanKerjaRepo, $penyelidikanRepo, $penyidikanRepo, $penuntutanRepo, $eksekusiRepo, $saldoRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;
    
    public function __construct(
        LapduRepositoryInterface $lapduRepo,
        SatuanKerjaRepositoryInterface $satuanKerjaRepo,
        PenyelidikanRepositoryInterface $penyelidikanRepo,
        PenyidikanRepositoryInterface $penyidikanRepo,
        PenuntutanRepositoryInterface $penuntutanRepo,
        EksekusiRepositoryInterface $eksekusiRepo,
        SaldoRepositoryInterface $saldoRepo
    ) {
        $this->title = "REPORT";
        $this->lapduRepo = $lapduRepo;
        $this->satuanKerjaRepo = $satuanKerjaRepo;
        $this->penyelidikanRepo = $penyelidikanRepo;
        $this->penyidikanRepo = $penyidikanRepo;
        $this->penuntutanRepo = $penuntutanRepo;
        $this->eksekusiRepo = $eksekusiRepo;
        $this->saldoRepo = $saldoRepo;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->havePermissionView = $this->user->can(PERMISSION_REPORT);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies(PERMISSION_REPORT), Response::HTTP_FORBIDDEN, 'Forbidden');
        $datas = [];
        $satuanKerja = $this->satuanKerjaRepo->getAll();
        $dateRange = splitDateRange($request->input('range-date'));

        $totalLapduMasuk = 0;
        $totalLapduSelesai = 0;
        $totalJumlahPenyelidikan = 0;
        $totalJumlahTunggakanPenyelidikan = 0;
        $totalJumlahPenyidikan = 0;
        $totalJumlahTunggakanPenyidikan = 0;
        $totalJumlahPenuntutan = 0;
        $totalJumlahEksekusi = 0;

        // get jumlah tunggakan
        $saldo = $this->tunggakanBySaldo();

        foreach ($satuanKerja as $key => $value) {
            $arr['name'] = $value->name;
            $arr['lapdu_masuk'] = $this->lapduRepo->count($value->id, PENDING, $dateRange);
            $arr['lapdu_selesai'] = $this->lapduRepo->count($value->id, MEMENUHI, $dateRange);
            $arr['jumlah_penyelidikan'] = $this->penyelidikanRepo->count($value->id, [SUDAH_DISPOSISI, BELUM_DISPOSISI], $dateRange);
            $arr['jumlah_tunggakan_penyelidikan'] = $saldo->penyelidikan;
            // $arr['jumlah_tunggakan_penyelidikan'] = $this->penyelidikanRepo->count($value->id, [BELUM_DISPOSISI], $dateRange);
            $arr['jumlah_penyidikan'] = $this->penyidikanRepo->count($value->id, [SUDAH_DISPOSISI, BELUM_DISPOSISI], $dateRange);
            $arr['jumlah_tunggakan_penyidikan'] = $saldo->penyidikan;
            // $arr['jumlah_tunggakan_penyidikan'] = $this->penyidikanRepo->count($value->id, [BELUM_DISPOSISI], $dateRange);
            $arr['jumlah_penuntutan'] = $this->penuntutanRepo->count($value->id, [SUDAH_DISPOSISI, BELUM_DISPOSISI], $dateRange);
            $arr['jumlah_eksekusi'] = $this->eksekusiRepo->count($value->id, [SUDAH_DISPOSISI, BELUM_DISPOSISI], $dateRange);

            $totalLapduMasuk += $arr['lapdu_masuk'];
            $totalLapduSelesai += $arr['lapdu_selesai'];
            $totalJumlahPenyelidikan += $arr['jumlah_penyelidikan'];
            $totalJumlahTunggakanPenyelidikan += $arr['jumlah_tunggakan_penyelidikan'];
            $totalJumlahPenyidikan += $arr['jumlah_penyidikan'];
            $totalJumlahTunggakanPenyidikan += $arr['jumlah_tunggakan_penyidikan'];
            $totalJumlahPenuntutan += $arr['jumlah_penuntutan'];
            $totalJumlahEksekusi += $arr['jumlah_eksekusi'];
            array_push($datas, $arr);
        }
        $data = [
            'title' => $this->title,
            'datas' => $datas,
            'total_lapdu_masuk' => $totalLapduMasuk,
            'total_lapdu_selesai' => $totalLapduSelesai,
            'total_jumlah_penyelidikan' => $totalJumlahPenyelidikan,
            'total_jumlah_tunggakan_penyelidikan' => $totalJumlahTunggakanPenyelidikan,
            'total_jumlah_penyidikan' => $totalJumlahPenyidikan,
            'total_jumlah_tunggakan_penyidikan' => $totalJumlahTunggakanPenyidikan,
            'total_jumlah_penuntutan' => $totalJumlahPenuntutan,
            'total_jumlah_eksekusi' => $totalJumlahEksekusi
        ];
        return view('admin.report.index', $data);
    }

    function tunggakanBySaldo()
    {
        return $this->saldoRepo->findOne();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Eksekusi;
use App\Models\Penuntutan;
use App\Models\Penyelidikan;
use App\Models\Penyidikan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $data = [
            'total_penyelidikan' => Penyelidikan::count(),
            'total_penyidikan' => Penyidikan::count(),
            'total_tuntutan' => Penuntutan::count(),
            'total_eksekusi' => Eksekusi::count(),
        ];
        return view('landing', $data);
    }
}

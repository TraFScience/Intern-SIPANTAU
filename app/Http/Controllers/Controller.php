<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use App\Models\JenisBencana;
use App\Models\Wilayah;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $kejadian = KejadianBencana::with(['pelapor', 'jenisBencana', 'wilayah'])->latest()->get();
        return view('kejadian-index', compact('kejadian'));
    }

    public function create()
    {
        $jenisBencana = JenisBencana::all();
        $wilayah = Wilayah::all();
        return view('kejadian-create', compact('jenisBencana', 'wilayah'));
    }
}

<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

class SaldoHutangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan saldo hutang');
    }
}

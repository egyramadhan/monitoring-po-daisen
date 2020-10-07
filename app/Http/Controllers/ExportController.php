<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ExportDataTable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


class ExportController extends Controller
{
    public function index(ExportDataTable $dataTable)
    {
        return $dataTable->render('price_list');
    }
}

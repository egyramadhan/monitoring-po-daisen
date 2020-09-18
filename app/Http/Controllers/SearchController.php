<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase_order;

class SearchController extends Controller
{
    //
    public function autocomplete(Request $request)
    {
        // dd($request);
        $data = Purchase_order::select("supplier as name")->where("supplier", "LIKE", "%{$request->input('supp')}%")->get();
        // dd($data);
        return response()->json($data);
    }

    public function autocomplete_po(Request $request)
    {
        // dd($request);
        $data = Purchase_order::select("naming_series as name_po")->where("naming_series", "LIKE", "%{$request->input('po_no')}%")->get();
        return response()->json($data);
    }
}

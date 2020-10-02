<?php

namespace App\Http\Controllers;

use App\MaterialReturn;
use Illuminate\Http\Request;
use App\Libraries\TransactionService;
use App\MaterialItemReturn;
use DB;

class MaterialReturnController extends Controller
{
    public function getReturn()
    {
        $service = new TransactionService();
        DB::beginTransaction();

        try {
            $get_material_return = $service->getMaterialReturn();
            foreach ($get_material_return['data'] as $key => $get_material_return) {
                $check_data = MaterialReturn::where('naming_series', $get_material_return['name'])->first();
                if (empty($check_data)) {
                    $purchase_request_insert = MaterialReturn::create([
                        'naming_series' => $get_material_return['name'],
                        'parent_po' => $get_material_return['po_no'],
                        'is_return' => $get_material_return['is_return'],
                        'supplier' => $get_material_return['supplier'],
                        'no_delivery_order' => $get_material_return['supplier_delivery_note'],
                        'time_delivery_order' => $get_material_return['delivery_time'],
                        'posting_date' => $get_material_return['posting_date'],
                        'posting_time' => $get_material_return['posting_time'],
                    ]);
                    $get_material_return_items = $service->getMaterialReturnItems($get_material_return['name']);
                    $get_material_return_Items_singles = $get_material_return_items['data']['items'];
                    foreach ($get_material_return_Items_singles as $key => $get_material_return_Items_single) {
                        $purchase_request_item_insert = MaterialItemReturn::create([
                            'naming_series_id' => $get_material_return_Items_single['parent'],
                            'code' => $get_material_return_Items_single['item_code'],
                            'description' => $get_material_return_Items_single['description'],
                            'qty_return' => $get_material_return_Items_single['qty'],
                            'unit' => $get_material_return_Items_single['uom'],
                            'price' => $get_material_return_Items_single['rate'],
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
        return response()->json(['message' => 'data updated', 'code' => '200']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Display the specified resource.
     *
     * @param  \App\MaterialReturn  $materialReturn
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialReturn $materialReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialReturn  $materialReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialReturn $materialReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialReturn  $materialReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialReturn $materialReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialReturn  $materialReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialReturn $materialReturn)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\TransactionService;
use App\Material_receive;
use App\Material_receive_item;
use DB;

class MaterialReceiveController extends Controller
{
    public function get_material_receipt()
    {
        $service = new TransactionService();
        DB::beginTransaction();

        try {
            $get_material_receipt = $service->getMaterialReceives();
            foreach ($get_material_receipt['data'] as $key => $get_material_receipt) {
                $check_data = Material_receive::where('naming_series', $get_material_receipt['name'])->first();
                if (empty($check_data)) {
                    $purchase_request_insert = Material_receive::create([
                        'naming_series' => $get_material_receipt['name'],
                        'parent_po' => $get_material_receipt['po_no'],
                        'supplier' => $get_material_receipt['supplier'],
                        'no_delivery_order' => $get_material_receipt['supplier_delivery_note'],
                        'time_delivery_order' => $get_material_receipt['delivery_time'],
                        'posting_date' => $get_material_receipt['posting_date'],
                        'posting_time' => $get_material_receipt['posting_time'],
                    ]);
                    $get_material_receipt_items = $service->getMaterialReceiveItems($get_material_receipt['name']);
                    $get_material_receipt_Items_singles = $get_material_receipt_items['data']['items'];
                    foreach ($get_material_receipt_Items_singles as $key => $get_material_receipt_Items_single) {
                        $purchase_request_item_insert = Material_receive_item::create([
                            'naming_series_id' => $get_material_receipt_Items_single['parent'],
                            'purchase_order' => $get_material_receipt_Items_single['purchase_order'],
                            'code' => $get_material_receipt_Items_single['item_code'],
                            'description' => $get_material_receipt_Items_single['description'],
                            'qty_receipt' => $get_material_receipt_Items_single['qty'],
                            'unit' => $get_material_receipt_Items_single['uom'],
                            'price' => $get_material_receipt_Items_single['rate'],
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
        //
    }
}

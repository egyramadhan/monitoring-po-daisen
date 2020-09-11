<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\TransactionService;
use App\Purchase_request;
use App\Purchase_request_item;
use DB;

class PurchaseRequestController extends Controller
{
    public function get_material_request()
    {
        $service = new TransactionService();
        DB::beginTransaction();

        try {
            $get_purchase_requests = $service->getMaterialRequest();
            foreach ($get_purchase_requests['data'] as $key => $get_purchase_request) {
                $check_data = Purchase_request::where('naming_series', $get_purchase_request['name'])->first();
                if (empty($check_data)) {
                    $purchase_request_insert = Purchase_request::create([
                        'naming_series' => $get_purchase_request['name'],
                        'supplier' => $get_purchase_request['supplier'],
                        'type' => $get_purchase_request['material_request_type'],
                        'schedule_date' => $get_purchase_request['schedule_date'],
                        'company' => $get_purchase_request['company'],
                        'request_by' => $get_purchase_request['request_by'],
                    ]);

                    $get_purchase_request_items = $service->getMaterialRequestItems($get_purchase_request['name']);
                    $get_purchase_request_Items_singles = $get_purchase_request_items['data']['items'];
                    foreach ($get_purchase_request_Items_singles as $key => $get_purchase_request_Items_single) {
                        $purchase_request_item_insert = Purchase_request_item::create([
                            'naming_series_id' => $get_purchase_request_Items_single['parent'],
                            'code' => $get_purchase_request_Items_single['item_code'],
                            'description' => $get_purchase_request_Items_single['description'],
                            'qty' => $get_purchase_request_Items_single['qty'],
                            'unit' => $get_purchase_request_Items_single['uom'],
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

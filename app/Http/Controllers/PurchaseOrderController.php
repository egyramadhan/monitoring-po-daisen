<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\TransactionService;
use App\Purchase_order;
use App\Purchase_order_item;
use APP\Price;
use DB;

class PurchaseOrderController extends Controller
{
    public function get_purchase_order()
    {
        $service = new TransactionService();
        DB::beginTransaction();

        try {
            $get_purchase_orders = $service->getPurchaseOders();
            foreach ($get_purchase_orders['data'] as $key => $get_purchase_order) {
                $check_data = Purchase_order::where('naming_series', $get_purchase_order['name'])->first();
                if (empty($check_data)) {
                    $purchase_request_insert = Purchase_order::create([
                        'naming_series' => $get_purchase_order['name'],
                        'material_request' => $get_purchase_order['material_request'],
                        'supplier' => $get_purchase_order['supplier'],
                        'posting_date' => $get_purchase_order['transaction_date'],
                        'requested_by_date' => $get_purchase_order['schedule_date'],
                    ]);
                    $get_purchase_order_items = $service->getPurchaseOrderItems($get_purchase_order['name']);
                    $get_purchase_order_Items_singles = $get_purchase_order_items['data']['items'];
                    foreach ($get_purchase_order_Items_singles as $key => $get_purchase_order_Items_single) {
                        $purchase_request_item_insert = Purchase_order_item::create([
                            'naming_series_id' => $get_purchase_order_Items_single['parent'],
                            'code' => $get_purchase_order_Items_single['item_code'],
                            'description' => $get_purchase_order_Items_single['description'],
                            'qty' => $get_purchase_order_Items_single['qty'],
                            'uom' => $get_purchase_order_Items_single['uom'],
                            'price' => $get_purchase_order_Items_single['rate'],
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

    public function cekStatus()
    {
        $service = new TransactionService();
        $get_purchase_orders = $service->statusClose();
        dd($get_purchase_order);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

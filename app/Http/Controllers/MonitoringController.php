<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\TransactionService;
use App\Purchase_request;
use App\Purchase_request_item;
use App\Purchase_order;
use App\Purchase_order_item;
use App\Material_receive;
use App\Material_receive_item;
use App\monitoring_po_daisen;
use DB;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::table('purchase_orders')
        //     ->join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
        //     ->get();
        $datas = DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
            ->get();
        // dd($datas);
        foreach ($datas as $key => $data) {
            # code...
            $check_data = monitoring_po_daisen::where('po_no', $data->naming_series)->first();
            // dd($check_data);
            if (empty($check_data)) {
                # code...
                $monitoring_po_insert = monitoring_po_daisen::create([
                    'supplier' => $data->supplier,
                    'pr' => $data->material_request,
                    'po_date' => $data->posting_date,
                    'po_no' => $data->naming_series,
                    'po_delivery' => $data->requested_by_date,
                    'code' => $data->code,
                    'item_description' => $data->description,
                    'po_qty' => $data->qty,
                    'currency' => $data->price,
                    'uom' => $data->uom,
                ]);
            }
        }

        $data_receipts = DB::table('material_receives')
            ->join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
            ->where('material_receives.counted', '=', '0')
            ->get();

        // dd($data_receipts);
        foreach ($data_receipts as $key => $data_receipt) {
            # code...
            $check_data_material_receipt = monitoring_po_daisen::where('po_no', $data_receipt->parent_po)->first();
            if (!empty($check_data_material_receipt)) {
                # code...
                // dd($check_data_material_receipt->balance);
                if (empty($check_data_material_receipt->balance)) {
                    # code...
                    $hasil = $data_receipt->qty_receipt;
                } elseif (!empty($check_data_material_receipt->balance)) {
                    # code...
                    $hasil = $check_data_material_receipt->balance + $data_receipt->qty_receipt;
                }

                // $hasil = $data_receipt->qty_receipt - $check_data_material_receipt->balance;
                $update_balance_qty = monitoring_po_daisen::where('po_no', $data_receipt->parent_po)
                    ->update([
                        'balance' => $hasil
                    ]);
                $update_material_receipt = Material_receive::where('naming_series', $data_receipt->naming_series)
                    ->update([
                        'counted' => '1'
                    ]);
            }
        }
    }

    public function dashboard()
    {
        $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
            ->paginate(5);
        return view('index', compact('data'));
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

    public function tampil()
    {
        return view('receipt');
    }
    public function show($id)
    {

        $parent_po = DB::table('purchase_orders')->where('naming_series', $id)->first();
        $data = DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
            ->where('purchase_orders.naming_series', '=', $id)
            ->where(function ($query) {
                $query->where('purchase_order_items.is_sync', '=', "0");
            })
            ->get();
        // dd($data);
        if (!empty($data)) {
            # code...
            foreach ($data as $key => $dt) {
                # code...
                if ($dt->is_sync === "0") {
                    # code...
                    $monitoring_insert = monitoring_po_daisen::create([
                        'po_no' => $dt->naming_series,
                        'code' => $dt->code,
                        'description' => $dt->description,
                        'po_qty' => $dt->qty,
                        'currency' => $dt->price,
                        'uom' => $dt->uom,
                    ]);
                    $purchase_order_sync = Purchase_order_item::where('naming_series_id', $dt->naming_series)
                        ->update([
                            'is_sync' => '1'
                        ]);
                }
            }
            $po = DB::table('monitoring_po_daisens')
                ->select('code', 'description', 'po_qty', 'uom', 'currency', DB::raw('sum(qty_receipt) as qty_receipt'), DB::raw('(sum(qty_receipt) - po_qty) as balance'))
                ->where('po_no', $id)
                ->groupBy('code', 'description', 'po_qty', 'uom', 'currency')
                ->get();
        }

        $check_if_receipts = DB::table('material_receives')
            ->join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
            ->where('material_receives.parent_po', '=', $id)
            ->where(function ($query) {
                $query->where('material_receive_items.is_calculated', '=', "0");
            })
            ->get();
        // dd($check_if_receipts);
        if (!empty($check_if_receipts)) {
            # code...
            foreach ($check_if_receipts as $key => $check_if_receipt) {
                # code...
                if ($check_if_receipt->is_calculated === "0") {
                    # code...
                    $number_po = $check_if_receipt->parent_po;
                    $code = $check_if_receipt->code;
                    $receipt = $check_if_receipt->qty_receipt;
                    $check_have_qty_receive = DB::table('monitoring_po_daisens')->where('po_no', '=', $number_po)
                        ->where('code', '=', $code)
                        ->first();
                    // dd($check_have_qty_receive);
                    if (!empty($check_have_qty_receive->qty_receipt)) {
                        # code...
                        $update_qty_receipt = DB::table('monitoring_po_daisens')->where('po_no', '=', $number_po)
                            ->where('code', '=', $code)
                            ->update(['qty_receipt' => $receipt + $check_have_qty_receive->qty_receipt]);
                        $update_calculated = Material_receive_item::where('naming_series_id', $check_if_receipt->naming_series)
                            ->update([
                                'is_calculated' => '1'
                            ]);
                    } else {
                        # code...
                        $update_qty_receipt = DB::table('monitoring_po_daisens')->where('po_no', '=', $number_po)
                            ->where('code', '=', $code)
                            ->update(['qty_receipt' => $receipt]);
                        $update_calculated = Material_receive_item::where('naming_series_id', $check_if_receipt->naming_series)
                            ->update([
                                'is_calculated' => '1'
                            ]);
                    }
                }
            }
        }

        $po = DB::table('monitoring_po_daisens')
            ->select('code', 'description', 'po_qty', 'uom', 'currency', DB::raw('sum(qty_receipt) as qty_receipt'), DB::raw('(sum(qty_receipt) - po_qty) as balance'))
            ->where('po_no', $id)
            ->groupBy('code', 'description', 'po_qty', 'uom', 'currency')
            ->get();

        $material_receipt = DB::table('material_receives')
            ->join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
            ->where('material_receives.parent_po', '=', $id)
            ->get();

        $counter_parent = 0;
        $counter_child = 0;
        return view('detail_po', compact('po', 'parent_po', 'material_receipt', 'counter_parent', 'counter_child'));
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

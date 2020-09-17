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
use Facade\FlareClient\Http\Response;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
            ->get();
    }

    public function dashboard()
    {

        $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
            ->paginate(5);
        foreach ($data as $key => $dt) {
            # code...
            // dd($dt);
            $check = Material_receive::join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
                ->select(DB::raw('sum(qty_receipt) as total_receipt'))
                ->where('parent_po', $dt->naming_series)->first();
            if (!empty($check)) {
                # code...
                $sum_order = Purchase_order_item::select(DB::raw('sum(qty) as total_qty'))
                    ->where('naming_series_id', $dt->naming_series)
                    ->first();
                if ($check->total_receipt < $sum_order->total_qty) {
                    # code...
                    $update_data_po = Purchase_order::where('naming_series', $dt->naming_series)
                        ->update([
                            'status' => 'partial'
                        ]);
                } elseif ($check->total_receipt == $check->total_receipt) {
                    # code...
                    $update_data_po = Purchase_order::where('naming_series', $dt->naming_series)
                        ->update([
                            'status' => 'completed'
                        ]);
                }

                // dd('partial');
            } else {
                # code...
                $update_data_po = Purchase_order::where('naming_series', $dt->naming_series)
                    ->update([
                        'status' => 'to receipt'
                    ]);
            }
        }
        // dd($data);
        // $datas = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
        //     ->join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
        //     ->select(DB::raw('purchase_order_items.naming_series_id, sum(purchase_order_items.qty) as total_po'))
        //     ->groupBy('purchase_order_items.naming_series_id')
        //     ->get();
        // foreach ($datas as $key => $data) {
        //     # code...
        //     $data_check = Material_receive::where('parent_po', $data->naming_series_id)->get();
        //     if (!empty($data_check)) {
        //         # code...
        //         $data_seconds = Material_receive::join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
        //             ->select(DB::raw('sum(material_receive_items.qty_receipt) as total_receipt'))
        //             ->where('material_receives.parent_po', $data->naming_series_id)
        //             ->first();
        //         // dd($data_seconds);
        //         $data_thirty = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
        //             ->where('purchase_orders.naming_series', $data->naming_series_id)
        //             ->first();
        //         // dd($data_seconds, $data_thirty);
        //         $a = array(
        //             // 0 =>
        //             array(
        //                 'naming_series' => $data->naming_series_id,
        //                 'total_po' => $data->total_po,
        //                 'total_receipt' => $data_seconds->total_receipt,
        //                 'posting_date' => $data_thirty->schedule_date,
        //                 'request_by' => $data_thirty->request_by,
        //                 'requested_by_date' => $data_thirty->requested_by_date,
        //                 'material_request' => $data_thirty->material_request,
        //                 'supplier' => $data_thirty->supplier
        //             ),
        //         );
        //     }
        // }

        // dd($a);
        // $data2 = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
        //     ->join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
        //     ->join('monitoring_po_daisens', 'purchase_orders.naming_series', '=', 'monitoring_po_daisens.po_no')
        //     ->select(DB::raw('purchase_order_items.naming_series_id, sum(monitoring_po_daisens.qty_receipt) as total_receipt'))
        //     ->groupBy('purchase_order_items.naming_series_id')
        //     ->get();

        // $data_sum_orders = Purchase_order_item::select(DB::raw('naming_series_id, sum(qty) as total_po'))
        //     ->groupBy('naming_series_id')->get();
        // foreach ($data_sum_orders as $key => $data_sum_order) {
        //     # code...
        //     if (!empty($data_sum_order)) {
        //         # code...
        //         $data_sum_receipts = Material_receive::join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
        //             ->select(DB::raw('material_receives.parent_po, sum(qty_receipt) as total_mr'))
        //             ->groupBy('material_receives.parent_po')
        //             ->get();
        //         foreach ($data_sum_receipts as $key => $data_sum_receipt) {
        //             # code...
        //             if (!empty($data_sum_receipt)) {
        //                 # code...
        //                 if ($data_sum_order->naming_series_id == $data_sum_receipt->parent_po) {
        //                     # code...
        //                     if ($data_sum_order->total_po == 0) {
        //                         # code...
        //                         $status = 'to receipt';
        //                     } elseif ($data_sum_order->total_po > $data_sum_receipt->total_mr) {
        //                         # code...
        //                         $status = 'partial';
        //                     } elseif ($data_sum_order->total_po == $data_sum_receipt->total_mr) {
        //                         # code...
        //                         $status = 'completed';
        //                     }
        //                 }
        //             } elseif (empty($data_sum_receipt)) {
        //                 # code...
        //                 $status = 'to receipt';
        //             }
        //         }
        //     }
        // }
        // $hasil = $status;

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

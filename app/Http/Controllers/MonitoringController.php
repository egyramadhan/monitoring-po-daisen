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
use App\MaterialReturn;
use App\MaterialItemReturn;
use App\monitoring_po_daisen;
use DB;
// use Facade\FlareClient\Http\Response;
use Response;

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

    public function dashboard(Request $request)
    {
        $po_number = $request->po_number;
        $date = $request->dates;
        $supplier = $request->supplier;
        $status = $request->statues;



        if (empty($po_number) && empty($date) && empty($supplier) && empty($status)) {
            # code...
            $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
                ->paginate(10);
        }

        if (!empty($po_number)) {
            # code...
            $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
                ->where('purchase_orders.naming_series', 'LIKE', '%' . $po_number . '%')
                ->paginate(10);
        }

        if (!empty($supplier)) {
            # code...
            $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
                ->where('purchase_orders.supplier', 'LIKE', '%' . $supplier . '%')
                ->paginate(10);
        }

        if (!empty($date)) {
            # code...
            $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
                ->where('purchase_orders.posting_date', 'LIKE', '%' . $date . '%')
                ->paginate(10);
        }

        if (!empty($status)) {
            # code...
            $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')
                ->where('purchase_orders.status', 'LIKE', '%' . $status . '%')
                ->paginate(10);
        }

        $data = Purchase_request::join('purchase_orders', 'purchase_requests.naming_series', '=', 'purchase_orders.material_request')->paginate(10);
        foreach ($data as $key => $dt) {
            # code...
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
            }
        }


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

        $check_if_returns = DB::table('material_returns')
            ->join('material_return_items', 'material_returns.naming_series', '=', 'material_return_items.naming_series_id')
            ->where('material_returns.parent_po', '=', $id)
            ->where(function ($query) {
                $query->where('material_return_items.is_calculated', '=', "0");
            })
            ->get();

        if (!empty($check_if_returns)) {
            # code...
            foreach ($check_if_returns as $key => $check_if_return) {
                # code...
                if ($check_if_return->is_calculated === "0") {
                    # code...
                    $number_po = $check_if_return->parent_po;
                    $code = $check_if_return->code;
                    $receipt = $check_if_return->qty_return;
                    $check_have_qty_return = DB::table('monitoring_po_daisens')->where('po_no', '=', $number_po)
                        ->where('code', '=', $code)
                        ->first();
                    // dd($receipt);
                    if (!empty($check_have_qty_return->qty_receipt)) {
                        # code...
                        $update_qty_return = DB::table('monitoring_po_daisens')->where('po_no', '=', $number_po)
                            ->where('code', '=', $code)
                            ->update(['qty_receipt' => $receipt + $check_have_qty_return->qty_receipt]);
                        $update_calculated = MaterialItemReturn::where('naming_series_id', $check_if_return->naming_series)
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

        $material_return = DB::table('material_returns')
            ->join('material_return_items', 'material_returns.naming_series', '=', 'material_return_items.naming_series_id')
            ->where('material_returns.parent_po', '=', $id)
            ->get();

        $counter_parent = 0;
        $counter_child = 0;
        return view('detail_po', compact('po', 'parent_po', 'material_receipt', 'material_return', 'counter_parent', 'counter_child'));
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

    public function dataMaterialReceipt($id)
    {
        $material_receipt = DB::table('material_receives')
            ->join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
            ->where('material_receives.parent_po', '=', $id)
            ->get();
        return response()->json($material_receipt, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Price;
use App\Purchase_order;
use App\Purchase_order_item;
use App\Masteritem;
use App\Libraries\TransactionService;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use App\DataTables\ExportDataTable;

class ListPriceController extends Controller
{

    public function getDataPrice()
    {
        $service = new TransactionService();
        DB::beginTransaction();
        try {
            $get_item_price = $service->getItemPrice();
            dd($get_item_price);
            foreach ($get_item_price['data'] as $key => $get_item_price) {
                $check_data = Price::where('naming_series', $get_item_price['name'])->first();
                if (empty($check_data)) {
                    $get_item_price_items = $service->getItemPriceDetail($get_item_price['name']);
                    $get_item_price_Items_singles = $get_item_price_items['data'];
                    $purchase_request_item_insert = Price::create([
                        'item_code' => $get_item_price_Items_singles['item_code'],
                        'description' => $get_item_price_Items_singles['item_description'],
                        'price_buying' => $get_item_price_Items_singles['price_list_rate'],
                        'currency' => $get_item_price_Items_singles['currency'],
                        'creation' => $get_item_price_Items_singles['creation'],
                    ]);
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

    public function getItemPricePO()
    {
        $get_item_prices = Purchase_order::join('purchase_order_items', 'purchase_orders.naming_series', '=', 'purchase_order_items.naming_series_id')
            ->get();
        foreach ($get_item_prices as $key => $get_item_price) {
            # code...
            $check_item_price = Masteritem::where('item_code', $get_item_price->code)->first();
            // dd($check_item_price);
            //master data jika tidak ada didatabase create baru
            if (empty($check_item_price)) {
                # code...
                $data_insert = Masteritem::create([
                    'item_code' => $get_item_price->code,
                    'description' => $get_item_price->description,
                    'supplier' => $get_item_price->supplier,
                ]);
            }

            $check_po_in_price = Price::where('no_po', $get_item_price->naming_series)->where('item_code', $get_item_price->code)->first();

            if (empty($check_po_in_price)) {
                # code...
                $data_insert_price = Price::create([
                    'master_item_id' => $check_item_price->id,
                    'no_po' => $get_item_price->naming_series,
                    'item_code' => $get_item_price->code,
                    'description' => $get_item_price->description,
                    'price_buying' => $get_item_price->price,
                    'currency' => 'IDR',
                    'creation' => $get_item_price->created_at
                ]);
            }

            // if (!empty($check_item_price)) {
            //     # code...
            //     if ($check_item_price->price_buying != $get_item_price->price) {
            //         # code...
            //         $data_insert = Price::create([
            //             'master_item_id' => $check_item_price->id,
            //             'item_code' => $get_item_price->code,
            //             'description' => $get_item_price->description,
            //             'price_buying' => $get_item_price->price,
            //             'currency' => 'IDR',
            //             'creation' => $get_item_price->created_at
            //         ]);
            //     }
            // }
        }
        return response()->json(['message' => 'data updated', 'code' => '200']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::select("SELECT master_items.supplier, prices.item_code, prices.`description`, prices.price_buying, MAX(creation), 
                    SUM(prices.`price_buying`) - prices.`price_buying` AS deviation
                            FROM master_items
                            INNER JOIN prices ON master_items.`id` = prices.`master_item_id`
                            GROUP BY prices.`item_code`
                            ORDER BY prices.`creation` DESC;
                    ");
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->item_code . '" data-original-title="Edit" class="edit btn btn-primary btn-sm showProduct">Show</a>';

                    return $btn;
                })
                ->addColumn('indicator', function ($data) {
                    if ($data->price_buying != $data->deviation) {
                        return "<label class='badge badge-success'><span class='fa fa-sort-up'></span></label>";
                    } elseif ($data->price_buying == 0 && $data->deviation == 0) {
                        return "<label class='badge badge-secondary'><span class='fa fa-minus'></span></label>";
                    } else {
                        return "<label class='badge badge-danger'><span class='fa fa-sort-desc'></span></label>";
                    }
                })
                ->rawColumns(['action', 'indicator'])
                ->make(true);
        }
        return view('price_list');
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
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show($item_code)
    {
        $shows = Price::where('item_code', $item_code)->orderBy('no_po', 'desc')->get();
        return response()->json($shows);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Price;
use App\Purchase_order_item;
use App\Libraries\TransactionService;
use Illuminate\Http\Request;
use DB;

class ListPriceController extends Controller
{

    public function getDataPrice()
    {
        $service = new TransactionService();
        DB::beginTransaction();
        try {
            $get_item_price = $service->getItemPrice();
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
        $get_item_prices = Purchase_order_item::all();
        foreach ($get_item_prices as $key => $get_item_price) {
            # code...
            $check_item_price = Price::where('item_code', $get_item_price->code)->first();
            // dd($check_item_price);
            if (empty($check_item_price)) {
                # code...
                $data_insert = Price::create([
                    'item_code' => $get_item_price->code,
                    'description' => $get_item_price->description,
                    'price_buying' => $get_item_price->price,
                    'currency' => 'IDR',
                    'creation' => $get_item_price->created_at
                ]);
            }

            // dd($check_item_price->price_buying, );
            if (!empty($check_item_price)) {
                # code...
                if ($check_item_price->price_buying != $get_item_price->price) {
                    # code...
                    $data_insert = Price::create([
                        'item_code' => $get_item_price->code,
                        'description' => $get_item_price->description,
                        'price_buying' => $get_item_price->price,
                        'currency' => 'IDR',
                        'creation' => $get_item_price->created_at
                    ]);
                }
            }
        }
        return response()->json(['message' => 'data updated', 'code' => '200']);
    }

    public function index()
    {
        //

        $data = Price::paginate(10);

        return view('price_list', compact('data'));
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
    public function show(Price $price)
    {
        //
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

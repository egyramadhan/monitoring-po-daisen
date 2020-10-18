<?php

namespace App\Exports;

use App\monitoring_po_daisen;
use App\Purchase_order;
use App\Purchase_order_item;
// use App\Material_receive;
// use App\Material_receive_item;
// use App\MaterialReturn;
// use App\MaterialItemReturn;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class MonitoringExport implements FromCollection
{
    use Exportable;
    public function collection()
    {
        $purchase_orders = Purchase_order::all();
        $collection = [];
        foreach ($purchase_orders as $purchase_order) {
            $po_id = $purchase_order->naming_series;
            // $data = monitoring_po_daisen::select('po_no', 'code', 'description', 'po_qty', 'currency', 'qty_receipt')->where('po_no', $po_id)->get();
            $data = monitoring_po_daisen::join('material_receive_items', 'monitoring_po_daisens.po_no', '=', 'material_receive_items.purchase_order')
                ->get();
            // $data = Purchase_order_item::select('qty', 'uom', 'price', 'created_at')->where('naming_series_id', $po_id)->get();
            // $data['receipt'] = Material_receive::where('parent_po', $po_id)->get();
            // $data['receipt_items'] = Material_receive_item::where('purchase_order', $po_id)->get();
            // $data['return'] = MaterialReturn::where('parent_po', $po_id)->get();
            // $data['return_items'] = MaterialItemReturn::where('purchase_order', $po_id)->get();
            array_push($collection, $data);
        }
        // dd($collection);
        return collect($data);
    }

    // public function map($monitoring_po_daisen): array
    // {
    //     return [
    //         [
    //             $monitoring_po_daisen->po_no,
    //             $monitoring_po_daisen->code,
    //             $monitoring_po_daisen->description,
    //             $monitoring_po_daisen->po_qty,
    //             $monitoring_po_daisen->qty_receipt,
    //         ]

    //     ];
    // }

    // public function headings(): array
    // {
    //     return [
    //         [
    //             'NOMOR PO',
    //             'CODE',
    //             'DESCRIPTION',
    //             'PO QTY',
    //             'RECEIPT QTY',
    //         ]
    //     ];
    // }
}

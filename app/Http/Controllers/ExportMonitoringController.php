<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MonitoringExport;
use Maatwebsite\Excel\Facades\Excel;

use App\monitoring_po_daisen;
use App\Material_receive;
use App\Material_receive_item;
use App\MaterialReturn;
use App\MaterialItemReturn;
use App\Purchase_order;
use App\Purchase_order_item;
use App\Purchase_request;
use App\Purchase_request_item;

class ExportMonitoringController extends Controller
{
    public function export()
    {
        return Excel::download(new MonitoringExport, 'monitoring.xlsx');
    }

    public function dataShow()
    {
        $purchase_orders = Purchase_order::all();
        $collection = [];
        foreach ($purchase_orders as $purchase_order) {
            $po_id = $purchase_order->naming_series;
            $data = monitoring_po_daisen::where('po_no', $po_id)->get();
            $data = Purchase_order_item::where('naming_series_id', $po_id)->get();
            // $data['receipt'] = Material_receive::where('parent_po', $po_id)->get();
            // $data['receipt_items'] = Material_receive_item::where('purchase_order', $po_id)->get();
            // $data['return'] = MaterialReturn::where('parent_po', $po_id)->get();
            // $data['return_items'] = MaterialItemReturn::where('purchase_order', $po_id)->get();
            array_push($collection, $data);
        }

        return $collection;
    }

    public function ExportMonitoring()
    {
        $monitor = monitoring_po_daisen::select('po_no', 'code', 'description', 'po_qty', 'qty_receipt')->get();

        return Excel::download($monitor, 'monitoring.xlsx');
        // return Excel::create('data_harian', function ($excel) use ($monitor) {
        //     $excel->sheet('mysheet', function ($sheet) use ($contact) {
        //         $sheet->fromArray($monitor);
        //     });
        // })->download('xls');
    }
}

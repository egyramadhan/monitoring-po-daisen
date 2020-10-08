<?php

namespace App\Exports;

use App\monitoring_po_daisen;

use App\Material_receive;
use App\Material_receive_item;
use App\MaterialReturn;
use App\MaterialItemReturn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class MonitoringExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function dataStatus()
    {
        $datasatus = monitoring_po_daisen::all();
        // dd($datasatus);
        // foreach ($datasatus as $key => $datasatu) {
        //     $Receipts = Material_receive::join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
        //         ->where('parent_po', $datasatu->po_no)
        //         ->get();
        //     $Returns = MaterialReturn::join('material_return_items', 'material_returns.naming_series', '=', 'material_return_items.naming_series_id')
        //         ->where('parent_po', $datasatu->po_no)
        //         ->get();
        //     // dd($Receipt);
        //     foreach ($Receipts as $key => $Receipt) {
        //         # code...
        //         foreach ($Returns as $key => $Return) {
        //             # code...
        //             $dataJson = array(
        //                 'name' => $datasatu->po_no,
        //                 'code' => $datasatu->code,
        //                 'description' => $datasatu->description,
        //                 'po_qty' => $datasatu->po_qty,
        //                 'uom' => $datasatu->uom,
        //                 'qty_receipt' => $datasatu->qty_receipt,
        //                 'no_delivery_order' => $Receipt->no_delivery_order,
        //                 'posting_date' => $Receipt->posting_date,
        //                 'description' => $Receipt->description,
        //                 'qty_receipt' => $Receipt->qty_receipt,
        //                 'no_delivery_order' => $Return->no_delivery_order,
        //                 'posting_date' => $Return->posting_date,
        //                 'description' => $Return->description,
        //                 'qty_return' => $Return->qty_return,
        //             );
        //         }
        //     }
        // }
        // return $dataJson;
    }

    public function collection()
    {
        return Material_receive::join('material_receive_items', 'material_receives.naming_series', '=', 'material_receive_items.naming_series_id')
            ->get();
    }

    // public function map($abc): array
    // {
    //     dd($abc);
    //     return [
    //         $abc->po_no,
    //     ];
    // }

    // public function headings(): array
    // {
    //     // return [
    //     //     '#',
    //     //     'po nomor',
    //     // ];
    //     return [
    //         'Name',
    //         'code',
    //         'description',
    //         'po_qty',
    //         'qty_receipt',
    //         'posting_date',
    //         'qty_return,'
    //     ];
    // }
    // public function view(): View
    // {
    //     return view('excel.monitoring', [
    //         'datas' => $this->dataStatus()
    //     ]);
    // }


}

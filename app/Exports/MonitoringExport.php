<?php

namespace App\Exports;

use App\monitoring_po_daisen;
// use App\Material_receive;
// use App\Material_receive_item;
// use App\MaterialReturn;
// use App\MaterialItemReturn;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class MonitoringExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    public function query()
    {
        return monitoring_po_daisen::query();
    }

    public function map($monitoring_po_daisen): array
    {
        return [
            [
                $monitoring_po_daisen->po_no,
                $monitoring_po_daisen->code,
                $monitoring_po_daisen->description,
                $monitoring_po_daisen->po_qty,
                $monitoring_po_daisen->qty_receipt,
            ]

        ];
    }

    public function headings(): array
    {
        return [
            [
                'NOMOR PO',
                'CODE',
                'DESCRIPTION',
                'PO QTY',
                'RECEIPT QTY',
            ]
        ];
    }
}

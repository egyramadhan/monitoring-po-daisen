<?php

namespace App\Exports;

use App\monitoring_po_daisen;
// use App\Material_receive;
// use App\Material_receive_item;
// use App\MaterialReturn;
// use App\MaterialItemReturn;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MonitoringExport implements WithMapping
{

    public function map($user): array
    {
        dd(111111);
        return [
            $user->getFullNameDescription()
        ];
    }
}

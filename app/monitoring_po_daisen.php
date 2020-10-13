<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class monitoring_po_daisen extends Model
{
    protected $table = 'monitoring_po_daisens';
    protected $guarded = [];

    public function getFullNameDescription()
    {
        $po = monitoring_po_daisen::select('description')->first();
        // dd($po);
        return $po;
    }
}

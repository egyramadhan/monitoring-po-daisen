<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monitoring_po_daisen extends Model
{
    protected $table = 'monitoring_po_daisens';
    // protected $guarded = [];
    protected $fillable = ['po_no', 'code', 'description', 'po_qty', 'currency', 'uom', 'qty_receipt'];

    public function getFullNameDescription()
    {
        return $this->description;
    }
}

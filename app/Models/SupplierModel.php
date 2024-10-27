<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table = 'db_tk3.supplier';
    protected $primaryKey = 'IdSupplier';
    public $timestamps = false;
}

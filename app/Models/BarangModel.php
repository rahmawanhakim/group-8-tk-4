<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    protected $table = 'db_tk3.barang';
    protected $primaryKey = 'IdBarang';
    public $timestamps = false;
}

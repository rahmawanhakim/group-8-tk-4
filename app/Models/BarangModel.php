<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    protected $table = 'trifecta.tb_barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;
}

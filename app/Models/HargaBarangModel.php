<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaBarangModel extends Model
{
    protected $table = 'trifecta.tb_harga_barang';
    protected $primaryKey = 'id_harga_barang';
    public $timestamps = false;
}

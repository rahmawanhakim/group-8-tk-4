<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'trifecta.tb_detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    public $timestamps = false;
}

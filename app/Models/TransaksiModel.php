<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    protected $table = 'trifecta.tb_transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    protected $table = 'db_tk3.transaksi';
    protected $primaryKey = 'IdTransaksi';
    public $timestamps = false;
}

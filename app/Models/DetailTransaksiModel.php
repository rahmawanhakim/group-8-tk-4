<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'db_tk3.detail_transaksi';
    protected $primaryKey = 'IdDetailTransaksi';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaModel extends Model
{
    protected $table = 'trifecta.tb_pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaModel extends Model
{
    protected $table = 'db_tk3.pengguna';
    protected $primaryKey = 'IdPengguna';
    public $timestamps = false;
}

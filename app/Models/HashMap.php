<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashMap extends Model
{
    use HasFactory;

    protected $table = 'hash_map';
    protected $primaryKey = 'key';
    protected $keyType = 'string';
}

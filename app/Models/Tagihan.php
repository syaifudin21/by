<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'mandateId','trxId','nomor','nama','items','tagihan', 'status','refNum','src','pgpToken'
    ];

    
}

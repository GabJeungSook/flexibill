<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function fee()
    {
        return $this->belongsTo(Grade::class);
    }
}

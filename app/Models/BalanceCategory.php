<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function balanceSheet()
    {
        return $this->hasMany(BalanceSheet::class,'category_id','id');
    }
}

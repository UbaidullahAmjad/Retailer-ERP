<?php

namespace App\Models;

use App\ProductPurchase;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockManagement extends Model
{
    protected $table = "stock_managements";

    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function purchaseProduct() :BelongsTo
    {
        return $this->belongsTo(ProductPurchase::class,'purchase_product_id','id');
    }

    public function retailer() :BelongsTo
    {
        return $this->belongsTo(User::class,'retailer_id','id');
    }

    public function purchase() :HasMany
    {
        return $this->hasMany(ProductPurchase::class,'product_id','product_id');
    }
    public function article() :BelongsTo
    {
        return $this->belongsTo(Article::class,'product_id','legacyArticleId');
    }
}

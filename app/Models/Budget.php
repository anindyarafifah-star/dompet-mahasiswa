<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = ['user_id', 'category_id', 'month', 'amount'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
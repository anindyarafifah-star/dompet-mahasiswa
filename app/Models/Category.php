<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['user_id', 'name', 'type'];

    /** Kategori bawaan yang dibuat saat pengguna mendaftar. */
    public const DEFAULTS = [
        ['Uang Saku', 'income'], ['Beasiswa', 'income'], ['Pekerjaan Paruh Waktu', 'income'], ['Lainnya', 'income'],
        ['Makan', 'expense'], ['Transportasi', 'expense'], ['Kuliah', 'expense'],
        ['Tempat Tinggal', 'expense'], ['Hiburan', 'expense'], ['Lainnya', 'expense'],
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }
}
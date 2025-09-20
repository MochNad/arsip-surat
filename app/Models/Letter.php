<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'category_id',
        'judul',
        'file_path',
        'file_name'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d H:i');
    }
}

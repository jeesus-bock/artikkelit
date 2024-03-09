<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'updated_by',
        'draft',
        'multi',
        'editing'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

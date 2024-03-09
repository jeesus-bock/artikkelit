<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'tag_id'
    ];
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

}

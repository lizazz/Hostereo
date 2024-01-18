<?php

namespace Modules\News\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\database\factories\TagFactory;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }
}

<?php

namespace Modules\News\app\Models;

use ArrayIterator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\database\factories\PostFactory;

class Post extends Model implements \IteratorAggregate
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }
}

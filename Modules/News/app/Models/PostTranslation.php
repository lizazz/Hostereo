<?php

namespace Modules\News\app\Models;

use Carbon\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\News\Database\factories\PostTranslationsFactory;

class PostTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['post_id', 'language_id', 'title', 'description', 'content'];

    protected static function newFactory(): PostTranslationsFactory
    {
        //return PostTranslationsFactory::new();
    }

    public function language()
    {
        return $this->hasOne(Language::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

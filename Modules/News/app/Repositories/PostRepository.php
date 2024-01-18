<?php

namespace Modules\News\app\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\News\app\Interfaces\PostRepositoryInterface;
use Modules\News\app\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): Collection
    {
        return Post::with('tags', 'translations')->get();
    }

    public function getById(int $postId): Post
    {
        return Post::findOrFail($postId);
    }

    public function delete(int $postId)
    {
        $post = Post::find($postId);
        $post->translations()->delete();
        $post->tags()->detach();
        $post->delete();
    }

    public function create(array $item): Post
    {
        return Post::create($item);
    }

    public function getAllWithPagination(): LengthAwarePaginator
    {
        return Post::with('tags', 'translations')->paginate(10);
    }
}

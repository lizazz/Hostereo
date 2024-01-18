<?php

namespace Modules\News\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\News\app\Http\Requests\PostTranslations\CreatePostTranslationRequest;
use Modules\News\app\Models\Post;
use Modules\News\app\Services\PostTranslationService;

class PostTranslationController extends Controller
{
    /**
     * @var array
     */
    public array $data = [];

    private PostTranslationService $postTransactionService;

    public function __construct(PostTranslationService $postTransactionService)
    {
        $this->postTransactionService = $postTransactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Post::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostTranslationRequest $request): JsonResponse
    {
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        //

        return response()->json($this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        //

        return response()->json($this->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        //

        return response()->json($this->data);
    }
}

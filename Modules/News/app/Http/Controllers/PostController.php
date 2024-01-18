<?php

namespace Modules\News\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Modules\News\app\Http\Requests\Posts\DeleteNewsRequest;
use Modules\News\app\Http\Requests\Posts\CreatePostRequest;
use Modules\News\app\Http\Requests\Posts\SearchPostRequest;
use Modules\News\app\Http\Requests\Posts\UpdatePostRequest;
use Modules\News\app\Interfaces\PostRepositoryInterface;
use Modules\News\app\Interfaces\RepositoryInterface;
use Modules\News\app\Repositories\PostTranslationRepository;
use Modules\News\app\Resources\Posts\PostCollectionResource;
use Modules\News\app\Resources\Posts\PostResource;
use Modules\News\app\Services\PostTranslationService;

class PostController extends Controller
{
    public array $data = [];
    private RepositoryInterface $repository;
    private PostTranslationRepository $postTranslationRepository;
    private PostTranslationService $postTranslationService;

    public function __construct(
        PostRepositoryInterface $postRepository,
        PostTranslationRepository $postTranslationRepository,
        PostTranslationService $postTranslationService
    ) {
        $this->repository = $postRepository;
        $this->postTranslationRepository = $postTranslationRepository;
        $this->postTranslationService = $postTranslationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = $this->repository->getAllWithPagination();
        $postsArray = $posts->toArray();
        $postsArray['data'] = new PostCollectionResource($posts);

        return response()->json($postsArray);
    }

    /**
     * @param CreatePostRequest $request
     * @return JsonResponse
     */
    public function store(CreatePostRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $post = $this->repository->create([]);
            $details = $request->only([
                'translations', 'tags'
            ]);
            $translations = $this->postTranslationService->prepareForSave($post, $details['translations']);
            $this->postTranslationRepository->createMany($post, $translations);
            $post->tags()->sync($details['tags']);
            DB::commit();
        } catch (Exception $exception) {
            DB:rollBack();
            return response()->json(['errors' => ['error' => ['message' => $exception->getMessage()]]]);
        }

        return response()->json(['data' => new PostResource($post)],Response::HTTP_CREATED);
    }

    /**
     * @param UpdatePostRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $post = $this->repository->getById($id);
            $details = $request->only([
                'translations', 'tags'
            ]);
            $translations = $this->postTranslationService->prepareForSave($post, $details['translations']);
            $this->postTranslationRepository->updateMany($post, $translations);
            $post->tags()->sync($details['tags']);
            DB::commit();
        } catch (Exception $exception) {
            DB:rollBack();
            return response()->json(['errors' => ['error' => ['message' => $exception->getMessage()]]]);
        }

        return response()->json([
            'data' => new PostResource($this->repository->getById($id))
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteNewsRequest $request, $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function search(SearchPostRequest $request)
    {
        $parameters = $request->only('languages', 'tags', 'title', 'description', 'content');
        $posts = $this->repository->getAll();
        $filtered = $this->postTranslationService->filter($posts, $parameters);
        return response()->json(['data' => new PostCollectionResource($filtered) ]);
    }
}

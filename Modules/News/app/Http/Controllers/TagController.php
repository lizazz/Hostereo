<?php

namespace Modules\News\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\News\app\Http\Requests\Tags\CreateTagRequest;
use Modules\News\app\Http\Requests\Tags\ShowDeleteTagRequest;
use Modules\News\app\Http\Requests\Tags\UpdateTagRequest;
use Modules\News\app\Interfaces\RepositoryInterface;
use Modules\News\app\Interfaces\TagRepositoryInterface;
use Modules\News\app\Resources\Tags\OneTagResource;
use Modules\News\app\Resources\Tags\TagCollectionResource;

class TagController extends Controller
{
    /**
     * @var array
     */
    public array $data = [];
    /**
     * @var TagRepositoryInterface
     */
    private RepositoryInterface $repository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->repository = $tagRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tags = $this->repository->getAll();
        $tagsArray = $tags->toArray();
        $tagsArray['data'] = new TagCollectionResource($tags);

        return response()->json($tagsArray);
    }

    /**
     * @param CreateTagRequest $request
     * @return JsonResponse
     */
    public function store(CreateTagRequest $request): JsonResponse
    {
        $details = $request->only([
            'name',
        ]);

        return response()->json(
            [
                'data' => new OneTagResource($this->repository->create($details))
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param ShowDeleteTagRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(ShowDeleteTagRequest $request, int $id): JsonResponse
    {
        return response()->json([
            'data' => new OneTagResource($this->repository->getById($id))
        ]);
    }

    /**
     * @param UpdateTagRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTagRequest $request, int $id): JsonResponse
    {
        $details = $request->only([
            'name'
        ]);
        $this->repository->update($id, $details);

        return response()->json([
            'data' => new OneTagResource($this->repository->getById($id))
        ]);
    }

    /**
     * @param ShowDeleteTagRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(ShowDeleteTagRequest $request, $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

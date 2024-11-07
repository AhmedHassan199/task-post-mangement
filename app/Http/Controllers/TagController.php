<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\TagService;
use App\Helpers\ApiResponseHelper; // Import your API response helper
use Illuminate\Http\JsonResponse;
use Exception;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the tags.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $tags = $this->tagService->getAllTags();
            return ApiResponseHelper::success([$tags], 'Tags retrieved successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to retrieve tags.', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created tag.
     *
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function store(TagRequest $request): JsonResponse
    {
        try {
            $tag = $this->tagService->createTag($request->validated());
            return ApiResponseHelper::success([$tag], 'Tag created successfully.', 201);
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to create tag.', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified tag.
     *
     * @param TagRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TagRequest $request, int $id): JsonResponse
    {
        try {
            $tag = $this->tagService->findTagById($id);
            $updatedTag = $this->tagService->updateTag($tag, $request->validated());
            return ApiResponseHelper::success([$updatedTag], 'Tag updated successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to update tag.', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified tag.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $tag = $this->tagService->findTagById($id);
            $this->tagService->deleteTag($tag);
            return ApiResponseHelper::success([], 'Tag deleted successfully.', 200);
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to delete tag.', 500, ['error' => $e->getMessage()]);
        }
    }
}

<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;
use App\Helpers\ApiResponseHelper;
use Illuminate\Http\JsonResponse;
use Exception;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): JsonResponse
    {
        try {
            $posts = $this->postService->getUserPosts();
            return ApiResponseHelper::success([$posts], 'Posts retrieved successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to retrieve posts.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function store(PostRequest $request): JsonResponse
    {
        try {
            $post = $this->postService->createPost($request->validated());
            return ApiResponseHelper::success([$post], 'Post created successfully.', 201);
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to create post.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $post = $this->postService->getPostById($id);
            return ApiResponseHelper::success([$post], 'Post retrieved successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to retrieve post.', 404, ['error' => $e->getMessage()]);
        }
    }

    public function update(PostRequest $request, $id): JsonResponse
    {
        try {
            $post = $this->postService->getPostById($id);
            $updatedPost = $this->postService->updatePost($post, $request->validated());
            return ApiResponseHelper::success([$updatedPost], 'Post updated successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to update post.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $post = $this->postService->getPostById($id);
            $this->postService->deletePost($post);
            return ApiResponseHelper::success([], 'Post deleted successfully.', 200);
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to delete post.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function deletedPosts(): JsonResponse
    {
        try {
            $deletedPosts = $this->postService->getDeletedPosts();
            return ApiResponseHelper::success([$deletedPosts], 'Deleted posts retrieved successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to retrieve deleted posts.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function restore($id): JsonResponse
    {
        try {
            $this->postService->restorePost($id);
            return ApiResponseHelper::success([], 'Post restored successfully.');
        } catch (Exception $e) {
            return ApiResponseHelper::error('Failed to restore post.', 500, ['error' => $e->getMessage()]);
        }
    }
}

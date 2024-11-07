<?php
namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getUserPosts()
    {
        return $this->postRepository->getUserPosts();
    }

    public function createPost(array $data)
    {

        return $this->postRepository->createPost($data);
    }

    public function getPostById($id)
    {
        return $this->postRepository->getPostById($id);
    }

    public function updatePost($post, array $data)
    {
        return $this->postRepository->updatePost($post, $data);
    }

    public function deletePost($post)
    {
        return $this->postRepository->deletePost($post);
    }

    public function getDeletedPosts()
    {
        return $this->postRepository->getDeletedPosts();
    }

    public function restorePost($id)
    {
        return $this->postRepository->restorePost($id);
    }
}

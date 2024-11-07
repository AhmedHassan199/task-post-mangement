<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;


class PostRepository
{
    public function getUserPosts()
    {
        return Post::where('user_id', Auth::id())
            ->orderBy('pinned', 'desc')
            ->get();
    }


    public function createPost(array $data)
    {
        // Store the cover image if it's provided
        $coverImagePath = null;
        if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
            // Store the image and get the path
            $coverImagePath = $data['cover_image']->store('cover_images', 'public');
        }

        // Create the post with the image path
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'body' => $data['body'],
            'cover_image' => $coverImagePath,
            'pinned' => $data['pinned'],
        ]);

        // Attach tags if provided
        if (isset($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }

        return $post;
    }


    public function getPostById($id)
    {
        return Post::where('user_id', Auth::id())->findOrFail($id);
    }

    public function updatePost(Post $post, array $data)
    {
        $post->update($data);

        // Update tags if provided
        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function deletePost(Post $post)
    {
        return $post->delete();
    }

    public function getDeletedPosts()
    {
        return Post::onlyTrashed()->where('user_id', Auth::id())->get();
    }

    public function restorePost($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        return $post->restore();
    }
}

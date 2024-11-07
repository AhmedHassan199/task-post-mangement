<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{
    public function index()
    {
        $stats = Cache::get('user_post_stats');

        if (!$stats) {
            $totalUsers = User::count();
            $totalPosts = Post::count();
            $usersWithZeroPosts = User::doesntHave('posts')->count();

            $stats = [
                'total_users' => $totalUsers,
                'total_posts' => $totalPosts,
                'users_with_zero_posts' => $usersWithZeroPosts,
            ];

            Cache::put('user_post_stats', $stats, 60);
        }

        return response()->json($stats);
    }
}

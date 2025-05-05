<?php

namespace App\Http\Controllers;

use Canvas\Events\PostViewed;
use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Canvas\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CanvasUiController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('canvas-ui')->with([
            'config' => [
                'canvasPath' => config('canvas.path'),
                'user' => $request->user('canvas'),
                'timezone' => config('app.timezone'),
            ],
        ]);
    }

    public function getPosts(Request $request): LengthAwarePaginator
    {
        return Post::latest()->published()->with('user', 'topic')->paginate();
    }

    public function showPost(Request $request, $slug): JsonResponse
    {
        $post = Post::with('user', 'tags', 'topic')->firstWhere('slug', $slug);

        if ($post) {
            event(new PostViewed($post));

            return response()->json($post, 200);
        } else {
            return response()->json(null, 404);
        }
    }

    public function getTags(Request $request): string
    {
        return Tag::all()->toJson();
    }

    public function showTag(Request $request, $slug): JsonResponse
    {
        $tag = Tag::firstWhere('slug', $slug);

        return $tag ? response()->json($tag, 200) : response()->json(null, 404);
    }

    public function getPostsForTag(Request $request, $slug): JsonResponse
    {
        $tag = Tag::firstWhere('slug', $slug);

        return $tag ? response()->json($tag->posts()->with('topic', 'user')->paginate(), 200) : response()->json(null, 200);
    }

    public function getTopics(Request $request): string
    {
        return Topic::all()->toJson();
    }

    public function showTopic(Request $request, $slug): JsonResponse
    {
        $topic = Topic::firstWhere('slug', $slug);

        return $topic ? response()->json($topic, 200) : response()->json(null, 404);
    }

    public function getPostsForTopic(Request $request, $slug): JsonResponse
    {
        $topic = Topic::firstWhere('slug', $slug);

        return $topic ? response()->json($topic->posts()->with('topic', 'user')->paginate(), 200) : response()->json(null, 200);
    }

    public function showUser(Request $request, $id): JsonResponse
    {
        $user = User::with('posts')->find($id);

        return $user ? response()->json($user, 200) : response()->json(null, 404);
    }

    public function getPostsForUser(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        return $user ? response()->json($user->posts()->published()->with('user', 'topic')->paginate(), 200) : response()->json(null, 200);
    }
}

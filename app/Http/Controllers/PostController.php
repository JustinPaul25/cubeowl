<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\Post\PostCreateRequest;
use Illuminate\Support\Facades\Request as ToastRequest;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Post/Index',[
            'toast' => [
                'type' => 'none',
                'message' => 'Something Went Wrong!',
            ]
        ]);
    }

    public function list(Request $request)
    {
        $cages = Post::query();

        if ($request->filled('search')) {
            $cages = $cages->where('title', 'ilike', '%' . $request->input('search') . '%')
                    ->where('body', 'ilike', '%' . $request->input('doc') . '%');
        }

        if ($request->filled('sortTitle')) {
            $cages = $cages->orderBy('title', $request->input('sortTitle'));
        }

        $dataCount = 10;

        $cages = $cages->paginate($dataCount);

        return response()->json($cages);
    }

    public function create()
    {
        return Inertia::render('Post/Create');
    }

    public function store(PostCreateRequest $request)
    {
        try {
            Post::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'author_id' => auth()->id()
            ]);

        } catch (Throwable $caught) {
            return Inertia::render('Post/Create', [
                'toast' => [
                    'type' => 'error',
                    'message' => 'Something Went Wrong!',
                ]
            ]);
        }

        return Inertia::render('Post/Index', [
            'toast' => [
                'type' => 'success',
                'message' => 'Post Created!',
            ]
        ]);
    }
}

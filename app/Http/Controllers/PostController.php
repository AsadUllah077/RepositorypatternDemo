<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Interfaces\PostRepositoryInterface;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->allPaginated(10);
        return view('index', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $this->postRepository->create($data);

        return back()->with('success', 'Post created successfully.');
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $this->postRepository->update($post, $data);

        return back()->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->postRepository->delete($post);

        return back()->with('success', 'Post deleted successfully.');
    }
}

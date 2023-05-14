<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCreateRequest;
use App\Services\Category\CategoryService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postPage()
    {
        $category = (new CategoryService())->categoryList();
        return view('pages.create-post',compact('category'));
    }

    public function postCreate(PostCreateRequest $request)
    {
        (new PostService())->createPost($request);
        return redirect()->route('home');
    }

    public function show($id)
    {
        $post = (new PostService())->getPostById($id);
        return view('pages.post-show',compact('post'));
    }

    public function myPosts()
    {
        $posts = (new PostService())->userPostList();
        return view('pages.home',compact('posts'));
    }
}

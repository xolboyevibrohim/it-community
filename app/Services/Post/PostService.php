<?php

namespace App\Services\Post;

use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected Post|null $post;

    public function userPostList($per_page=10)
    {
        return Post::userPost()->paginate($per_page);
    }

    public function postList()
    {
        return Post::orderBy('id','desc')
        ->with('user')->paginate(10);
    }

    protected function create(array $data)
    {
        return Post::create($data);
    }

    protected function update(array $data): bool
    {
        return $this->post->update($data);
    }

    public function updatePost(int $id, PostUpdateRequest $request)
    {
        $this->getPostById($id);
        $this->checkAuth();
        $post['title'] = $request['title'];
        $post['description'] = $request['description'];
        $post['category_id'] = $request['category_id'];
        $file = $request->file('file') ?? null;
        if (!is_null($file)) {
            $this->deleteFile($this->post->file_url);
            $post['file_url'] = $this->storeFile($file);
        }
        return $this->update($post);
    }

    protected function storeFile($file): string
    {
        $token = generateToken();
        $path = $file->store("public/post/$token");
        return Storage::url($path);
    }

    public function createPost(PostCreateRequest $request)
    {
        $file = $this->storeFile($request->file('file'));
        $post['title'] = $request['title'];
        $post['description'] = $request['description'];
        $post['category_id'] = $request['category_id'];
        $post['file_url'] = $file;
        $post['user_id'] = Auth::id();
        return $this->create($post);
    }

    public function deletePost($id)
    {
        $this->getPostById($id);
        $this->checkAuth();
        $this->deleteFile($this->post->file_url);
        $this->post->delete();
    }

    protected function deleteFile(string $url): void
    {
        if (file_exists(public_path($url))) {
            $path = str_replace('storage', 'public', $url);
            Storage::delete($path);
        }
    }

    public function getPostById($id): ?Post
    {
        $this->post = Post::find($id);
        if (is_null($this->post)) throwError('post topilmadi');
        return $this->post;
    }

    protected function checkAuth()
    {
        if ($this->post->user_id != Auth::id()) throwError('post sizga tegishli emas');
    }
}

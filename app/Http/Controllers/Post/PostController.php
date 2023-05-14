<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostListRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\Post\PaginateResource;
use App\Services\Post\PostService;

/**
 * @group Post
 */
class PostController extends Controller
{
    public function __construct(protected PostService $service)
    {
    }

    /**
     * Post-list (userni postlarini olish)
     * @ResponseFile 200 storage/response/post/list.json
     * @ResponseFile 401 storage/response/auth/401.json
     */
    public function index(PostListRequest $request)
    {
        $post = $this->service->userPostList($request);
        return new PaginateResource($post);
    }

    /**
     * Post-create (post yaratish)
     * @ResponseFile 200 storage/response/register/200.json
     * @ResponseFile 401 storage/response/auth/401.json
     */
    public function store(PostCreateRequest $request)
    {
        $this->service->createPost($request);
        return success();
    }

    /**
     * Post-view (postni id orqali olish)
     * @ResponseFile 200 storage/response/post/show.json
     * @ResponseFile 400 storage/response/post/400.json
     * @ResponseFile 401 storage/response/auth/401.json
     */
    public function show($id)
    {
        $post = $this->service->getPostById($id);
        return success($post);
    }

    /**
     * Post-update (postni id orqali yangilsh)
     * @ResponseFile 200 storage/response/register/200.json
     * @ResponseFile 400 storage/response/post/400.json
     * @ResponseFile 401 storage/response/auth/401.json
     */
    public function update(int $id,PostUpdateRequest $request)
    {
        $this->service->updatePost($id,$request);
        return success();
    }

    /**
     * Post-delete (postni id orqali o'chirish)
     * @ResponseFile 200 storage/response/register/200.json
     * @ResponseFile 400 storage/response/post/400.json
     * @ResponseFile 401 storage/response/auth/401.json
     */
    public function destroy($id)
    {
        $this->service->deletePost($id);
        return success();
    }
}

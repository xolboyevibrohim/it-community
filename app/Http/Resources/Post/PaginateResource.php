<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
    public function withResponse($request, $response)
    {
        $res = json_decode($response->getContent(), true);
        $page['current_page'] = $res['current_page'];
        $page['per_page'] = $res['per_page'];
        $page['total'] = $res['total'];
        $page['last_page'] = $res['last_page'];
        $res['pagination'] = $page;
        unset($res['links'],$res['current_page'],$res['per_page'],
            $res['total'],$res['last_page'],$res['next_page_url'],
            $res['from'],$res['last_page_url'],$res['first_page_url'],
            $res['path'],$res['prev_page_url'],$res['to']);
        $response->setContent(json_encode($res));
    }
}

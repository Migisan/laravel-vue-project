<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $datetime_format = config('const.DATETIME_FORMAT');

        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'body'       => $this->body,
            'updated_at' => $this->updated_at->format($datetime_format),
            'user'       => new UserResource($this->user),
        ];
    }
}

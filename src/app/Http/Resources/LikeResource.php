<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
            'user'       => new UserResource($this->user),
            'created_at' => $this->created_at->format($datetime_format),
        ];
    }
}

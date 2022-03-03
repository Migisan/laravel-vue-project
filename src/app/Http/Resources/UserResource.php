<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'       => $this->name,
            'email'      => $this->email,
            'image_path' => $this->image_path,
            'updated_at' => $this->updated_at->format($datetime_format),
        ];
    }
}

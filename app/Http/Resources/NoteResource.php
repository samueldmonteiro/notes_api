<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /*return [
            'id' => $this->id,
            'creator' => $this->user_id,
            'title' => $this->title,
            'content' => $this->content,
            'color' => $this->color,
            'created_at' => $this->created_at
        ];*/
        return parent::toArray($request);
    }
}

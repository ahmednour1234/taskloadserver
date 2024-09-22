<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user ? $this->user->name : null, // Assuming Log belongs to a User
            'action' => $this->action,
            'invoice_id' => $this->invoice_id,
            'role' => $this->role,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}


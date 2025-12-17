<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * add session iin class
     * roles and permissions
     * admin staff teacher student
     * roles permission screen
     * 
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name" => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
           

        ];
        
    }
}

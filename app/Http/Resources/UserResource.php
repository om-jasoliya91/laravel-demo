<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'role'=>$this->role,
            'age'=>$this->age,
            'city'=>$this->city,
            'address'=>$this->address,
            'profile_pic'=>$this->profile_pic ? asset('storage/'.$this->profile_pic) : null,
            'created_at'=>$this->created_at->format('Y-m-d H:i:s')
        ];
        }
}

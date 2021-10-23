<?php

namespace App\Http\Resources;
use App\Models\User as UserModel;
use App\Models\Folder;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->withoutWrapping();
        $userSchedules = $this->schedules()->get();
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "schedules"=> $userSchedules,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 * @mixin Employee
 */
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'date_of_birth'=> $this->date_of_birth->getTimestamp(),
            'weight'=> $this->weight,
            'height'=> $this->height,
            'salary'=> $this->salary,
            'position'=> $this->position,
        ];
    }
}

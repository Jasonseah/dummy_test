<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\Resources\Json\JsonResource;

class HashMapResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['key' => "string", 'value' => "string"])]
    public function toArray($request): array
    {
        return [
            'key'   => $this->key,
            'value' => $this->value,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => (float) $this->price,
            'discount_price' => (float) $this->discount_price,
            'discount_percentage' => round($this->discount_percentage, 2),
            'stock' => $this->stock,
            'fabric' => $this->fabric,
            'color' => $this->color,
            'occasion' => $this->occasion,
            'blouse_included' => $this->blouse_included,
            'featured' => $this->featured,
            'trending' => $this->trending,
            'thumbnail' => $this->thumbnail,
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}

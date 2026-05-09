<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getProducts($filter = [])
    {
        $query = Product::where('status', true);

        if (!empty($filter['category'])) {
            $query->where('category_id', $filter['category']);
        }

        if (!empty($filter['search'])) {
            $query->whereRaw("MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", [$filter['search']]);
        }

        if (!empty($filter['price_min']) || !empty($filter['price_max'])) {
            if (!empty($filter['price_min'])) {
                $query->where('price', '>=', $filter['price_min']);
            }
            if (!empty($filter['price_max'])) {
                $query->where('price', '<=', $filter['price_max']);
            }
        }

        if (!empty($filter['fabric'])) {
            $query->where('fabric', $filter['fabric']);
        }

        if (!empty($filter['color'])) {
            $query->where('color', $filter['color']);
        }

        if (!empty($filter['occasion'])) {
            $query->where('occasion', $filter['occasion']);
        }

        if (!empty($filter['sort'])) {
            switch ($filter['sort']) {
                case 'latest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'price_low_to_high':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'price_high_to_low':
                    $query->orderBy('price', 'DESC');
                    break;
                case 'trending':
                    $query->where('trending', true)->orderBy('created_at', 'DESC');
                    break;
                default:
                    $query->orderBy('id', 'DESC');
            }
        }

        return $query->with('category', 'images');
    }

    public function getFeaturedProducts()
    {
        return Product::where('status', true)
            ->where('featured', true)
            ->with('category', 'images')
            ->limit(12)
            ->get();
    }

    public function getTrendingProducts()
    {
        return Product::where('status', true)
            ->where('trending', true)
            ->with('category', 'images')
            ->limit(12)
            ->get();
    }

    public function getLatestProducts($limit = 8)
    {
        return Product::where('status', true)
            ->with('category', 'images')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function getRelatedProducts($productId, $limit = 4)
    {
        $product = Product::find($productId);

        return Product::where('status', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $productId)
            ->with('category', 'images')
            ->limit($limit)
            ->get();
    }

    public function getCategoryProducts($categoryId)
    {
        return Product::where('status', true)
            ->where('category_id', $categoryId)
            ->with('category', 'images');
    }
}

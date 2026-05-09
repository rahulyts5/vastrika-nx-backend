<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Pure Silk Saree',
                'slug' => 'pure-silk-saree',
                'sku' => 'PURE-SILK-001',
                'short_description' => 'Beautiful pure silk saree',
                'description' => 'Premium quality silk saree with traditional weaving',
                'price' => 2500.00,
                'discount_price' => 2000.00,
                'stock' => 10,
                'fabric' => 'Silk',
                'color' => 'Red',
                'occasion' => 'Wedding',
                'blouse_included' => true,
                'featured' => true,
                'trending' => true,
                'seo_title' => 'Pure Silk Saree - Red',
                'seo_description' => 'Beautiful red pure silk saree',
                'status' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Banarasi Gold Saree',
                'slug' => 'banarasi-gold-saree',
                'sku' => 'BANARASI-GOLD-001',
                'short_description' => 'Gold Banarasi saree with zari work',
                'description' => 'Luxurious Banarasi saree with intricate zari embroidery',
                'price' => 3500.00,
                'discount_price' => 2800.00,
                'stock' => 5,
                'fabric' => 'Silk',
                'color' => 'Gold',
                'occasion' => 'Wedding',
                'blouse_included' => true,
                'featured' => true,
                'trending' => false,
                'seo_title' => 'Banarasi Gold Saree',
                'seo_description' => 'Elegant gold Banarasi saree with zari work',
                'status' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Cotton Everyday Saree',
                'slug' => 'cotton-everyday-saree',
                'sku' => 'COTTON-EVERYDAY-001',
                'short_description' => 'Comfortable cotton saree',
                'description' => 'Breathable cotton saree perfect for daily wear',
                'price' => 800.00,
                'discount_price' => 600.00,
                'stock' => 20,
                'fabric' => 'Cotton',
                'color' => 'Blue',
                'occasion' => 'Casual',
                'blouse_included' => false,
                'featured' => false,
                'trending' => true,
                'seo_title' => 'Cotton Everyday Saree',
                'seo_description' => 'Comfortable cotton saree for daily wear',
                'status' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Royal Bridal Saree',
                'slug' => 'royal-bridal-saree',
                'sku' => 'ROYAL-BRIDAL-001',
                'short_description' => 'Luxurious bridal saree',
                'description' => 'Premium bridal saree with royal designs',
                'price' => 5000.00,
                'discount_price' => 4000.00,
                'stock' => 3,
                'fabric' => 'Silk',
                'color' => 'Maroon',
                'occasion' => 'Wedding',
                'blouse_included' => true,
                'featured' => true,
                'trending' => true,
                'seo_title' => 'Royal Bridal Saree',
                'seo_description' => 'Luxurious maroon bridal saree',
                'status' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

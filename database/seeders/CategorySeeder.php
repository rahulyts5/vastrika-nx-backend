<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Silk Sarees',
                'slug' => 'silk-sarees',
                'description' => 'Premium silk sarees with traditional designs',
                'status' => true,
            ],
            [
                'name' => 'Banarasi Sarees',
                'slug' => 'banarasi-sarees',
                'description' => 'Classic Banarasi sarees with intricate zari work',
                'status' => true,
            ],
            [
                'name' => 'Cotton Sarees',
                'slug' => 'cotton-sarees',
                'description' => 'Comfortable cotton sarees for daily wear',
                'status' => true,
            ],
            [
                'name' => 'Wedding Collection',
                'slug' => 'wedding-collection',
                'description' => 'Elegant sarees for wedding occasions',
                'status' => true,
            ],
            [
                'name' => 'Party Wear',
                'slug' => 'party-wear',
                'description' => 'Glamorous sarees for parties and events',
                'status' => true,
            ],
            [
                'name' => 'Designer Sarees',
                'slug' => 'designer-sarees',
                'description' => 'Exclusive designer collections',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

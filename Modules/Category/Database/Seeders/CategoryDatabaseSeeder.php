<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\App\Models\Category;
use Modules\Category\App\Models\SubCategory;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'ايجار',
                'description' => null,
                'image'=> '1749867683415D9775-4CB7-4919-8F93-5608DF68C432.jpg',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'بيع',
                'description' => null,
                'image'=> '17498676950CD53D1C-3495-401C-90B3-1CA843E47DDB.jpg',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
        Category::insert($categories);


        $subCategories = [
            // For Category ID 1 (ايجار)
            [
                'title' => 'اراضي',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'مكاتب تجارية',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'محلات تجارية',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'مزارع',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'شاليهات',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'شقق',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'غير ذلك',
                'category_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // For Category ID 2 (بيع)
            [
                'title' => 'اراضي',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'مكاتب تجارية',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'محلات تجارية',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'مزارع',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'شاليهات',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'شقق',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'غير ذلك',
                'category_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        SubCategory::insert($subCategories);

    }
}

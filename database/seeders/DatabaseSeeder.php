<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Client\App\Models\Client;
use Modules\Category\App\Models\Category;
use Modules\Property\App\Models\Property;
use Modules\Property\App\Models\PropertyImage;
use Modules\Category\App\Models\SubCategory;
use Modules\Admin\Database\Seeders\AdminDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminDatabaseSeeder::class,
            // CategoryDatabaseSeeder::class,
        ]);
        $clients = [
            [
                'first_name' => 'أحمد',
                'last_name' => 'علي',
                'email' => 'ahmed@example.com',
                'phone' => '01234567891',
                'image' => 'https://placehold.co/600x400',
                'password' => Hash::make('123123'),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'محمد',
                'last_name' => 'علي',
                'email' => 'mohamed@example.com',
                'phone' => '01234567892',
                'image' => 'https://placehold.co/600x400',
                'password' => Hash::make('123123'),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Client::insert($clients);

        $categories = [
            [
                'title' => 'سكني',
                'description' => 'عقارات سكنية للمعيشة',
                'is_active' => 1,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'تجاري',
                'description' => 'عقارات تجارية للأعمال',
                'is_active' => 1,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'أرض',
                'description' => 'أراضي للتطوير',
                'is_active' => 1,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Category::insert($categories);

        // Create subcategories
        $subcategories = [
            // Residential subcategories
            [
                'title' => 'شقة',
                'description' => 'شقق سكنية',
                'category_id' => 1,
                'is_active' => 1,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'فيلا',
                'description' => 'فلل سكنية',
                'category_id' => 1,
                'image' => 'https://placehold.co/600x400',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Commercial subcategories
            [
                'title' => 'مكتب',
                'description' => 'مكاتب تجارية',
                'category_id' => 2,
                'image' => 'https://placehold.co/600x400',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'محل تجاري',
                'description' => 'مساحات تجارية',
                'category_id' => 2,
                'image' => 'https://placehold.co/600x400',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Land subcategories
            [
                'title' => 'أرض سكنية',
                'description' => 'أرض للتطوير السكني',
                'category_id' => 3,
                'image' => 'https://placehold.co/600x400',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'أرض تجارية',
                'description' => 'أرض للتطوير التجاري',
                'category_id' => 3,
                'image' => 'https://placehold.co/600x400',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        SubCategory::insert($subcategories);

        $properties = [
            [
                'title' => 'شقة فاخرة في وسط المدينة',
                'description' => 'شقة جميلة مع وسائل راحة عصرية',
                'client_id' => 1,
                'sub_category_id' => 1, // Apartment
                'lat' => '24.7136',
                'long' => '46.6753',
                'city' => 'الرياض',
                'address' => 'وسط المدينة، الرياض',
                'price' => 500000,
                'area' => 120,
                'floor' => 5,
                'directions' => 'شمال',
                'age' => 2,
                'ownership_type' => 'ملك',
                'bedrooms' => 2,
                'living_rooms' => 1,
                'bathrooms' => 2,
                'width_ratio' => 50.22,
                'phone' => '0123456789',
                'whatsapp' => '0123456789',
                'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'notes' => 'هذه ملاحظة تجريبية',
                'unavailable_comment' => null,
                'is_sold' => 0,
                'is_furnished' => 1,
                'is_installment' => 0,
                'is_active' => 1,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'مساحة مكتب تجارية',
                'description' => 'مساحة مكتب في موقع مميز للأعمال',
                'client_id' => 2,
                'sub_category_id' => 3, // Office
                'lat' => '24.7741',
                'long' => '46.7388',
                'city' => 'الرياض',
                'address' => 'الحي التجاري، الرياض',
                'price' => 8000,
                'area' => 200,
                'floor' => 10,
                'directions' => 'جنوب',
                'age' => 1,
                'ownership_type' => 'إيجار',
                'bedrooms' => 0,
                'living_rooms' => 2,
                'bathrooms' => 1,
                'width_ratio' => 50.22,
                'phone' => '0123456789',
                'whatsapp' => '0123456789',
                'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'notes' => 'هذه ملاحظة تجريبية',
                'unavailable_comment' => null,
                'is_sold' => 0,
                'is_furnished' => 1,
                'is_installment' => 1,
                'is_active' => 1,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Property::insert($properties);

        $propertyImages = [
            [
                'property_id' => 1,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 1,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 2,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 2,
                'image' => 'https://placehold.co/600x400',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        PropertyImage::insert($propertyImages);
    }
}

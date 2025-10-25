<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // أولاً ننشئ فئة واحدة إذا لم توجد
        $category = Category::firstOrCreate(
            ['name' => 'Default Category'],
            ['slug' => Str::slug('Default Category')]
        );

        // بعدها ننشئ 10 منتجات مرتبطة بها
        Product::factory(10)->create([
            'category_id' => $category->id,
        ]);
    }
}

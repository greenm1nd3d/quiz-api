<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'user_id' => 1,
            'sku' => 'hammer0001',
            'product' => 'Hammer',
            'content' => 'This is a very nice hammer used by Thor.',
            'photo' => 'https://res.cloudinary.com/dri66pabq/image/upload/v1611050618/hammer_xcqg4m.jpg',
            'price' => 200.00
        ]);

        Product::create([
            'user_id' => 1,
            'sku' => 'paintbru01',
            'product' => 'Paint Brush',
            'content' => 'This is a very nice paint brush used by Leonardo Da Vinci.',
            'photo' => 'https://res.cloudinary.com/dri66pabq/image/upload/v1611050618/paint-brush_b9e948.jpg',
            'price' => 100.00
        ]);

        Product::create([
            'user_id' => 1,
            'sku' => 'handsaw001',
            'product' => 'Hand Saw',
            'content' => 'This a very nice hand saw used by Ole Kirk Christiansen.',
            'photo' => 'https://res.cloudinary.com/dri66pabq/image/upload/v1611050618/handsaw_alcdyj.jpg',
            'price' => 150.00
        ]);

        Product::create([
            'user_id' => 1,
            'sku' => 'woodplan01',
            'product' => 'Wood Planer',
            'content' => 'This is a very good wood planer.',
            'photo' => 'https://res.cloudinary.com/dri66pabq/image/upload/v1611050618/wood-planer_hoe5hd.jpg',
            'price' => 250.00
        ]);

        Product::create([
            'user_id' => 1,
            'sku' => 'drill00001',
            'product' => 'Drill',
            'content' => 'This is a very nice drill.',
            'photo' => 'https://res.cloudinary.com/dri66pabq/image/upload/v1611050618/drill_mdm0hi.jpg',
            'price' => 750.00
        ]);
    }
}

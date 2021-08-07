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
            'sku' => 'hammer0001',
            'product' => 'Hammer',
            'content' => 'This is a very nice hammer used by Thor.',
            'photo' => 'hammer_xcqg4m.jpg',
            'price' => 200.00
        ]);

        Product::create([
            'sku' => 'paintbru01',
            'product' => 'Paint Brush',
            'content' => 'This is a very nice paint brush used by Leonardo Da Vinci.',
            'photo' => 'paint-brush_b9e948.jpg',
            'price' => 100.00
        ]);

        Product::create([
            'sku' => 'handsaw001',
            'product' => 'Hand Saw',
            'content' => 'This a very nice hand saw used by Ole Kirk Christiansen.',
            'photo' => 'handsaw_alcdyj.jpg',
            'price' => 150.00
        ]);

        Product::create([
            'sku' => 'woodplan01',
            'product' => 'Wood Planer',
            'content' => 'This is a very good wood planer.',
            'photo' => 'wood-planer_hoe5hd.jpg',
            'price' => 250.00
        ]);

        Product::create([
            'sku' => 'drill00001',
            'product' => 'Drill',
            'content' => 'This is a very nice drill.',
            'photo' => 'drill_mdm0hi.jpg',
            'price' => 750.00
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image = Image::create([
            'alt' => 'Savage Gear SGS2 All-Around Stap',
            'src' => 'images/Savage Gear SGS2 All-Around.png'
        ]);

        $image->id = 1;
        $image->save();

        $image = Image::create([
            'alt' => 'DTD Panic Shad 16g 120 Combo',
            'src' => 'images/DTD Panic Shad 16g 120 Combo.jpg'
        ]);

        $image->id = 2;
        $image->save();

        $image = Image::create([
            'alt' => 'Varivas Shock Leader',
            'src' => 'images/Varivas Shock Leader.jpg'
        ]);

        $image->id = 3;
        $image->save();
    }
}

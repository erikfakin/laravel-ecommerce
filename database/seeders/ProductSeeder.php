<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Savage Gear SGS2 All-Around',
            'description' => 'Savage Gear SGS2 All-Around Štapovi srednje duljine nude savršenu ravnotežu udaljenosti i točnosti zabacivanja, što ih čini idealnim za čitav niz različitih mjesta za ribolov u morskoj vodi uključujući luke, stijene i plaže. Omogućuju preciznu kontrolu tvrdih i mekih mamaca i, ovisno o težini bacanja koju odaberete, mogu se koristiti za ciljanje na mnoge različite vrste uključujući brancina, plavu ribu, palamide...',
            'price' => 84.81,
            'image_id' => 1,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Silikonac DTD Panic Shad 16g 120 Combo + body',
            'description' => 'Silikonac DTD Panic Shad 16g 120 Combo + body je novost iz DTD-a za 2023 godinu namjenjen lovu brancina opremljen Decoy udicom i proizveden u Japanu.',
            'price' => 6.50,
            'image_id' => 2,
            'category_id' => 2
        ]);

        Product::create([
            'name' => 'Fluorocarbon 100% Varivas Shock Leader',
            'description' => 'VARIVAS Fluorocarbon Shock Leader je tvrda, vrlo procizan leader otporan na abraziju dizajniran posebno za napredne ribolovne tehnike kao što su snažno vrtenje, popping, duboki jigging i ribolov na dnu. Uz izvrsnu otpornost na abraziju za zaštitu od kontakta sa kamenjem, zubima, perajama i dnom čamaca, također ima visoku otpornost na udarce. Uz gotovo nultu vidljivost, materijal od 100% fluorocarbona nestaje u vodi. Ovaj leader se preporučuje za ribolov na tune.
Napravljeno u Japanu.',
            'price' => 10.50,
            'image_id' => 3,
            'category_id' => 3
        ]);
    }
}

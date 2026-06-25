<?php

namespace Database\Seeders;

use App\Models\PartnerLogo;
use Illuminate\Database\Seeder;

class PartnerLogoSeeder extends Seeder
{
    public function run()
    {
        if (PartnerLogo::count() > 0) {
            return;
        }

        $partners = [
            ['name' => 'Allp', 'url' => 'https://floor.ge/?lang=ka', 'file' => 'da-allp.png', 'sort' => 1],
            ['name' => 'Archi', 'url' => 'https://www.archi.ge/ge', 'file' => 'da-archi.png', 'sort' => 2],
            ['name' => 'Dunkin', 'url' => 'https://dd.ge/', 'file' => 'da-dunkin.png', 'sort' => 3],
            ['name' => 'Energony', 'url' => 'https://energony.ge/', 'file' => 'da-energon.png', 'sort' => 4],
            ['name' => 'Element Construction', 'url' => 'https://ec.ge/', 'file' => 'da-element.png', 'sort' => 5],
            ['name' => 'LTB', 'url' => 'https://www.ltb.ge/', 'file' => 'da-ltb.png', 'sort' => 6],
            ['name' => 'Tifox', 'url' => 'https://tfox.ge/', 'file' => 'da-tifox.png', 'sort' => 7],
            ['name' => "McDonald's", 'url' => 'https://mcdonalds.ge/ge/home', 'file' => 'da-mc.png', 'sort' => 8],
            ['name' => 'MDF', 'url' => 'http://mdf.org.ge/', 'file' => 'da-mdf.png', 'sort' => 9],
            ['name' => 'GPP', 'url' => 'http://gpp.ge/ka/', 'file' => 'da-noste.png', 'sort' => 10],
            ['name' => 'Sabauni', 'url' => 'https://www.sabauni.edu.ge/ka', 'file' => 'da-sabauni.png', 'sort' => 11],
            ['name' => 'Terminal Center', 'url' => 'https://terminal.center/', 'file' => 'da-terminal.png', 'sort' => 12],
            ['name' => 'Agrosphere', 'url' => 'https://agrosphere.ge/', 'file' => 'da-agrosphere.png', 'sort' => 13],
        ];

        foreach ($partners as $item) {
            $path = public_path('images/damkveti-logos/'.$item['file']);

            if (! is_file($path)) {
                continue;
            }

            $partner = PartnerLogo::create([
                'name' => $item['name'],
                'url' => $item['url'],
                'image_alt_ka' => $item['name'],
                'image_alt_en' => $item['name'],
                'sort_order' => $item['sort'],
                'status' => 1,
            ]);

            $partner->addMedia($path)->preservingOriginal()->toMediaCollection('main');
        }
    }
}

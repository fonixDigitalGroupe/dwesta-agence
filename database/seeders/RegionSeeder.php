<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'SN' => [
                'Dakar', 'Diourbel', 'Fatick', 'Kaffrine', 'Kaolack', 'Kédougou',
                'Kolda', 'Louga', 'Matam', 'Saint-Louis', 'Sédhiou', 'Tambacounda',
                'Thiès', 'Ziguinchor',
            ],
            'CF' => [
                'Bangui', 'Bamingui-Bangoran', 'Basse-Kotto', 'Haute-Kotto', 'Haut-Mbomou',
                'Kémo', 'Lobaye', 'Mambéré-Kadéï', 'Mbomou', 'Nana-Grébizi', 'Nana-Mambéré',
                "Ombella-M'Poko", 'Ouaka', 'Ouham', 'Ouham-Pendé', 'Sangha-Mbaéré', 'Vakaga',
            ],
            'FR' => [
                'Auvergne-Rhône-Alpes', 'Bourgogne-Franche-Comté', 'Bretagne', 'Centre-Val de Loire',
                'Corse', 'Grand Est', 'Hauts-de-France', 'Île-de-France', 'Normandie',
                'Nouvelle-Aquitaine', 'Occitanie', 'Pays de la Loire', "Provence-Alpes-Côte d'Azur",
            ],
        ];

        foreach ($data as $code => $regions) {
            $country = Country::where('code', $code)->first();
            if (! $country) {
                continue;
            }
            foreach ($regions as $name) {
                Region::updateOrCreate(
                    ['country_id' => $country->id, 'name' => $name],
                    ['is_active' => true]
                );
            }
        }

        $this->command->info('✓ Régions (SN, CF, FR) créées.');
    }
}

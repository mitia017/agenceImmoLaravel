<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superadmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => User::ROLE_SUPERADMIN,
        ]);

        $owner = User::factory()->create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'role' => User::ROLE_OWNER,
        ]);

        $agent = User::factory()->create([
            'name' => 'Agent User',
            'email' => 'agent@example.com',
            'role' => User::ROLE_AGENT,
        ]);

        $users = collect([$superadmin, $owner, $agent]);

        // create realistic option records
        $optionNames = [
            'Balcon',
            'Terrasse',
            'Parking',
            'Garage',
            'Piscine',
            'Jardin',
            'Ascenseur',
            'Cuisine équipée',
            'Climatisation',
            'Chauffage individuel',
            'Proche transport',
            'Double vitrage',
        ];

        if (Option::count() === 0) {
            foreach ($optionNames as $name) {
                Option::factory()->create(['name' => $name]);
            }
        }

        $allOptionIds = Option::pluck('id')->all();

        // create 100 properties and assign randomly to the 3 users
        $properties = Property::factory()->count(100)->create(['sold' => false])->each(function (Property $property) use ($users, $allOptionIds) {
            $property->update(['user_id' => $users->random()->id]);

            $optionIds = [];

            if ($property->price > 500000) {
                $optionIds[] = Option::where('name', 'Parking')->value('id');
                $optionIds[] = Option::where('name', 'Terrasse')->value('id');
            }

            if ($property->surface >= 120) {
                $optionIds[] = Option::where('name', 'Garage')->value('id');
                $optionIds[] = Option::where('name', 'Jardin')->value('id');
            }

            if ($property->rooms >= 4) {
                $optionIds[] = Option::where('name', 'Balcon')->value('id');
                $optionIds[] = Option::where('name', 'Ascenseur')->value('id');
            }

            if ($property->bedrooms >= 3) {
                $optionIds[] = Option::where('name', 'Climatisation')->value('id');
            }

            if (empty($optionIds)) {
                $optionIds[] = fake()->randomElement($allOptionIds);
            }

            $optionIds = array_unique(array_filter($optionIds));
            $optionIds = array_merge($optionIds, fake()->randomElements($allOptionIds, random_int(0, 2)));
            $property->options()->sync(array_unique($optionIds));
        });

        // mark exactly 35 properties as sold (35%)
        $properties->random(35)->each->update(['sold' => true]);

        // optional test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => User::ROLE_OWNER,
        ]);
    }
}

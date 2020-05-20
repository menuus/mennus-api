<?php

use App\Models\CustomerProfiles;
use App\Models\EstablishmentProfiles;
use App\Models\Establishments;
use App\Models\Images;
use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $names = [
            'Juliana Mendonça',
            'Gabriele Lima Polalsky',
            'Katia Bruna Oliveira',
            'Mary Anne Silveira',
            'Bruna de Pontes Souza',
            'Tatiana Furokawa',
            'Antônio Vieira Cordeiro',
            'Bruno Limeira',
        ];

        for ($i=1; $i<=8; $i++)
        {
            $user = factory(User::class, 1)->create([
                'name' => $names[$i-1],
                'email' => Str::slug($names[$i - 1], '-') . '@email.com',
            ])[0];

            $image = Images::create([
                'name' => "Profile do usuário: $user->name",
                'path' => "https://storage.googleapis.com/mennus-images/mock/avatars/$i.jpg",
            ]);
            
            CustomerProfiles::create([
                'image_id' => $image->id
            ])->user()->save($user);
        }

        Establishments::all()->each(function ($establishment) {
            $user = factory(User::class, 1)->create([
                'name' => $establishment->name,
                'email' => "$establishment->slug@email.com",
            ])->first();

            EstablishmentProfiles::create([
                'establishment_id' => $establishment->id
            ])->user()->save($user);
        });
    }
}

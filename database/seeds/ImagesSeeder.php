<?php

use App\Models\Establishments;
use App\Models\FoodCourts;
use App\Models\Images;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createImagesFor(FoodCourts::class, 3, 10, 'business');
        $this->createImagesFor(Establishments::class, 1, 10, 'business');
        $this->PlatesImages();
    }

    public function createImagesFor($model, int $min=0, int $max=5, $fakerImageCategory)
    {
        $faker = Faker\Factory::create();
        $model::all()->each(function ($modelItem) use ($faker, $min, $max, $fakerImageCategory){
            $image = [
                'name' => "Image of '$modelItem->name'",
                'description' => "$modelItem->description (image)",
            ];

            if ($fakerImageCategory)
                $image['path'] = $faker->imageUrl(640, 480, $fakerImageCategory);

            $modelItem->images()->attach(
                factory(Images::class, rand($min, $max))->create($image)->pluck('id')->toArray()
            );
        });
    }

    public function PlatesImages()
    {
        $i=0;
        $j=0;
        foreach (Establishments::all() as $establishment)
        {
            $i++;
            $j=0;

            $image = Images::create([
                'name' => "Logo do estabelecimento: $establishment->name",
                'path' => "https://storage.googleapis.com/mennus-images/mock/plates/$i/logo.png",
            ]);

            // $establishment->logo()->save($establishment);
            $image->establishment_logo()->save($establishment);

            foreach ($establishment->plates as $plate) 
            {
                $j++;

                $image = Images::create([
                    'name' => "Imagem do prato: $plate->name",
                    'path' => "https://storage.googleapis.com/mennus-images/mock/plates/$i/$j.jpg",
                ]);

                $plate->images()->save($image);
            }
        }
    }
}

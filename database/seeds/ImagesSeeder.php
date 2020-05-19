<?php

use App\Models\Establishments;
use App\Models\FoodCourts;
use App\Models\Images;
use App\Models\Plates;
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
        $this->createImagesFor(Plates::class, 0, 3, 'food');
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
}

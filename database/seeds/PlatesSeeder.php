<?php

use App\Models\Establishments;
use App\Models\MenuTypes;
use App\Models\PlateCategories;
use App\Models\Plates;
use Illuminate\Database\Seeder;

class PlatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plates::truncate();

        $this->plate("Picanha brava", "Principal", "Hambúrguer", "Picanha Picles");
        $this->plate("Picanha brava", "Principal", "Hambúrguer", "Picanha Crispy");
        $this->plate("Picanha brava", "Principal", "Hambúrguer", "El Picanha");
        $this->plate("Picanha brava", "Principal", "Hambúrguer", "Junior");
        $this->plate("Picanha brava", "Principal", "Hambúrguer", "Picanha Bacon");
        $this->plate("Picanha brava", "Principal", "Hambúrguer", "Picovid");
        
        $this->plate("Pizza da Nona", "Principal", "Pizza", "Peperoni");
        $this->plate("Pizza da Nona", "Principal", "Pizza", "Lombinho");
        $this->plate("Pizza da Nona", "Principal", "Pizza", "Portuguesa");
        $this->plate("Pizza da Nona", "Principal", "Pizza", "Margueritta");
        $this->plate("Pizza da Nona", "Principal", "Pizza", "Mexicana");
        $this->plate("Pizza da Nona", "Principal", "Pizza", "Veggie");
        
        $this->plate("Sushicity", "Principal", "Japonesa", "Temaki");
        $this->plate("Sushicity", "Principal", "Japonesa", "Yakissoba");
        $this->plate("Sushicity", "Principal", "Japonesa", "Hot Filadelfia");
        $this->plate("Sushicity", "Principal", "Japonesa", "Uramaki Filadelfia");
        $this->plate("Sushicity", "Principal", "Japonesa", "Sashimi");
        $this->plate("Sushicity", "Principal", "Japonesa", "Combinado");

        $this->plate("Mucho nacho", "Principal", "Mexicana", "Nachos");
        $this->plate("Mucho nacho", "Principal", "Mexicana", "Burritos");
        $this->plate("Mucho nacho", "Principal", "Mexicana", "Fajitas");
        $this->plate("Mucho nacho", "Principal", "Mexicana", "Quesadillas");
        $this->plate("Mucho nacho", "Principal", "Mexicana", "Tacos");
        $this->plate("Mucho nacho", "Principal", "Mexicana", "Taco Veggie");
    }

    public function plate($establishment, $menuType, $category, $name)
    {
        factory(Plates::class, 1)->create([
            'name' => $name,
            'establishment_id' => Establishments::where('name', $establishment)->first()->id,
            'menu_type_id' => MenuTypes::where('name', $menuType)->first()->id,
            'plate_category_id' => PlateCategories::where('name', $category)->first()->id,
            'slug' => Str::slug($name, '-'),
            'description' => "",
        ]);
    }
}

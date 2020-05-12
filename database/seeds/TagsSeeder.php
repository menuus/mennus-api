<?php

use App\Models\Tags;
use App\Models\Plates;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run()
    {
        Tags::truncate();

        $this->createTags();

        $this->createTagsFor(Plates::class, 1, 10);
    }

    public function createTags()
    {
        $tags = [ 'manteiga','ovo','queijo','nata','mussarela','iogurte','creme',
            'leite','quindim','cebola','alho','tomate','batata','cenoura','pimentao',
            'bell-basil','salsinha','brocolis','milho','espinafre','cogumelo',
            'gengibre','pimenta','aipo','roemary','pepino','salmoura','abacate',
            'abobora','hortela','berinjela','inhame','limao','maca','banana','lima',
            'morango','laranja','abacaxi','mirtilo','passa','coco','uva','pessego',
            'framboesa','oxicoco','manga','pera','amora','cereja','melancia','kiwi',
            'mamao','goiaba','lichia-frango','bacon','linguica','carne','presunto',
            'cachorro-quente','carne-de-porco','peru','asa-de-galinha','peito-de-frango',
            'cordeiro','molho-de-tomate','molho-de-maionese','molho-de-churrasco',
            'molho-de-pimenta','molho-de-alho'
        ];

        foreach ($tags as $tag)
            Tags::create(['tag' => $tag]);
    }

    public function createTagsFor($model, int $min=0, int $max=5)
    {
        // TODO: test
        // TODO: esta duplicando tags
        $model::all()->each(function ($modelItem) use ($min, $max){
            $modelItem->tags()->attach(
                Tags::all()->random(rand($min, $max))->pluck('id')
            );
        });
    }
}
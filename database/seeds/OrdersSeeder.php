<?php

use App\Models\Establishments;
use App\Models\Orders;
use App\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    private $min = 3;
    private $max = 15;

    public function run()
    {
        Orders::truncate();

        Establishments::all()->each(function ($establishment) {
            $ordersAmount = random_int($this->min, $this->max);

            for ($i=0; $i<$ordersAmount; $i++)
            {
                $order = factory(Orders::class, 1)->create([
                    'establishment_id' => $establishment->id,
                    'user_id' => User::all()->random()->id,
                ])->first();

                $plate = $establishment->plates->random();
                
                $order->plates()->attach($plate->id, [
                        'plates_amount' => random_int(1, 3),
                        'price' => $plate->price,
                    ]
                );
            }
        });
    }
}

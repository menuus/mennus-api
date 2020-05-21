<?php

namespace App\Widgets;

use App\Models\CustomerProfiles;
use App\Models\EstablishmentProfiles;
use App\Models\Orders;
use Arrilot\Widgets\AbstractWidget;

class OrdersTable extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */
    public $reloadTimeout = 5; //TODO: put in .env

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $orders = [];
        switch (get_class(auth()->user()->profile))
        {
            case CustomerProfiles::class:
                $orders = Orders::where('user_id', auth()->user()->id)->orderBy('created_at')->get();
                break;

            case EstablishmentProfiles::class:
                $establishment_id = auth()->user()->profile->establishment_id;
                $orders = Orders::where('establishment_id', $establishment_id)
                    ->where('finished_at', null)
                    ->orderBy('created_at')
                    ->get();
                break;
        }

        return view('widgets.orders_table', [
            'config' => $this->config,
            'orders' => $orders
        ]);
    }
}

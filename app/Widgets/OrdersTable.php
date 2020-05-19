<?php

namespace App\Widgets;

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
        $establishment_id = auth()->user()->profile->establishment_id;
        $orders = Orders::where('establishment_id', $establishment_id)->orderBy('created_at')->get();

        return view('widgets.orders_table', [
            'config' => $this->config,
            'orders' => $orders
        ]);
    }
}

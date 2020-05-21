<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function order_delete(Request $request)
    {
        // TODO: refatorar
        return response([
            'data' => Orders::destroy($request->order_id)
        ]);
    }

    public function order_call(Request $request)
    {
        // TODO: refatorar
        return response([
            'method' => 'call',
            'user_id' => auth()->user()->id,
            'order_id' => $request->order_id,
        ]);
    }

    public function order_finish(Request $request)
    {
        // TODO: refatorar
        $order = Orders::find($request->order_id);
        $order->finished_at = \Carbon\Carbon::now();
        $order->save();
        return response([
            'data' => $order,
        ]);
    }
}

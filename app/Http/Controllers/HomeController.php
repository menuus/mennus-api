<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Services\NotificationService;
use Illuminate\Http\Request;

//FIXME: Traduções hardcoded
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
        // TODO: verificar se o pedido é dele msmo
        // TODO: verificar se o token não é null
        // FIXME: está enviando Notification Message, e não Data Message (que aciona o app mesmo em background)
        NotificationService::sendMessage(
            Orders::find($request->order_id)->user->push_token,
            'Pedido pronto!! 😁'
        );
        // TODO: verificar se o dispositivo recebeu a notificação e que o usuário leu
        // TODO: Tentar entrar mais vezes e avisar tentativas no front
        
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

<?php

namespace App\Http\Controllers;

use App\Exceptions\MennusUnauthorized;
use App\Models\Orders;
use App\Models\Plates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class OrdersController extends ResourceBaseController_CRUD
{
    protected $defaultSort = 'created_at';

    // protected $allowedFilters; // Calculated in parent

    protected $allowedSorts = [
        'updated_at',
        'created_at',
        'finished_at',
    ];

    protected $allowedIncludes = [
        'user',
        'establishment',
        'plates',
    ];

    public function __construct()
    {
        parent::__construct(Orders::class);
    }

    public function index()
    {
        //TODO: is not showing the price and plates_amount
        return $this->respondWithCollection(
            $this->ifExists($this->findByFilters(Auth::user()->id))  //TODO: implements to establishment user
        );
    }

    public function store(Request $request)
    {
        $inputData = $this->validateAndGetInputData($request, [
            'obs' => 'string|nullable',
            'establishment_id' => 'required|numeric|gt:0',
            'plates' => 'required|array',
            'plates.*.plate_id' => 'required|numeric|gt:0|distinct',
            'plates.*.amount' => 'required|numeric|gt:0|lte:20',
            'plates.*.price' => 'numeric|gt:0',
        ]);

        $order = new Orders($inputData);
        $order->user_id = Auth::user()->id;
        $order->establishment_id = $inputData['establishment_id'];
        $order->save();
        
        try
        {
            foreach ($inputData['plates'] as $plateOrder) {
                $plate = Plates::find($plateOrder['plate_id']);
                $plate->orders()->attach($order->id, [
                    'plates_amount' => $plateOrder['amount'],
                    'price' => $plateOrder['price'] ?? $plate->price,
                ]);
            }
        }
        catch(Throwable $ex)
        {
            $order->forceDelete();
            throw $ex;
        }

        // return $this->respondWithStoredData($order);
        return $this->respondWithStoredData(Orders::with('plates')->where('id', $order->id)->first());
    }

    public function show(Request $request, $id)
    {
        //TODO: is not showing the price and plates_amount

        $order = $this->ifExists($this->findById($id));
        if ($order->user_id != Auth::user()->id) //TODO: implements to establishment user
            throw new MennusUnauthorized('This order is not yours.');
        return $this->respondWithCustomData($order);
    }

    public function update(Request $request, $id)
    {
        $order = $this->ifExists($this->find($id));
        if ($order->user_id != Auth::user()->id) //TODO: implements to establishment user
            throw new MennusUnauthorized('This order is not yours.');

        $order->update($request->all());
        return $this->respondWithCustomData($order);
    }

    public function destroy($id)
    {
        $order = $this->ifExists($this->find($id));
        if ($order->user_id != Auth::user()->id) //TODO: implements to establishment user
            throw new MennusUnauthorized('This order is not yours.');

        $order->delete();
        return $this->respondWithNoContent();
    }
}

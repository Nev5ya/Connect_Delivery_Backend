<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
//        dd(User::find(3)->orders()->get());
        return OrderResource::collection(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @param User $user
     * @return AnonymousResourceCollection
     */
    public function edit(Order $order, User $user): AnonymousResourceCollection
    {
        dump($order);
        return OrderResource::collection(Order::query()->find($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $orderID
     * @param $courierID
     * @return Response
     */
    public function update($orderID, $courierID): Response
    {
        $order = Order::query()->findOrFail($orderID)->setAttribute('user_id', (int)$courierID);
        $order->setAttribute('order_status', 1);
        $order->save();
        return response(['type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

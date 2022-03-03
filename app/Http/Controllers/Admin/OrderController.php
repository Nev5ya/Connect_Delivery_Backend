<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Order $order
     * @return OrderResource
     */
    public function index(Order $order): OrderResource
    {
        return OrderResource::make($order->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return OrderResource
     */
    public function show(int $id): OrderResource
    {
        return OrderResource::make(Order::query()->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @param User $user
     * @return OrderResource
     */
    public function edit(Request $request, Order $order): OrderResource
    {
        dd($order);
        $order->fill($request->all());
        dd(Order::query()->select('orders.*', 'users.name as courier_name', 'order_status.title as status')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_status', 'orders.order_status_id', '=', 'order_status.id')
            ->get());
        return OrderResource::make(Order::query()->find($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $orderID
     * @param $courierID
     * @return Response
     */
    //нужно переписать для редактирования всех полей
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
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order): Response
    {
        $order->delete();
        return response(['type' => 'success']);
    }
}

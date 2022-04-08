<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Exception;
use Faker\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Order $order
     * @return OrderResource
     */
    public function show(Order $order): OrderResource
    {
        return OrderResource::make(
            (new Order())->find($order->getAttribute('id'))
        );
    }

    public function store(Request $request): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' =>'required|string|max:255',
            'comment' => 'string|max:255',
            'delivery_date' => 'date|date_format:Y-m-d'
        ],[], [
            'delivery_date' => 'дата доставки',
            'name' => 'Наименование заказа'
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->getMessages()
            ], Response::HTTP_FORBIDDEN);
        }

        Order::query()->insert(array_merge($request->all(), [
            'created_at' => date(now())
        ]));

        return response([
            'message' => 'Success'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * should provide by a patch method
     * @param Request $request
     * @param Order $order
     * @param OrderService $orderService
     * @return Response
     */
    public function update(Request $request, Order $order, OrderService $orderService): Response
    {
        $order
            ->fill($request->all())
            ->syncChanges();

        if ($state = $request->only('user_id', 'order_status_id')) {
            $order = $orderService->changeOrderAndUserState($order, $state);
        }

        $order->save();

        return response([
            'message' => 'Order updated',
            'updatedOrder' => $order->find($order->getAttribute('id'))
        ], Response::HTTP_OK);
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

        return response([
            'message' => 'Order deleted'
        ], Response::HTTP_OK);
    }
}

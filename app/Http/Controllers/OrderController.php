<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use DateTime;
use Response;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate();

        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function export()
    {

        $now = DateTime::createFromFormat('U.u', microtime(true));
        $fileName = $now->format('Y-m-d_His_u') . '_orders.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {
            $orders = Order::all();

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Product Title',
                'Price',
                'Quantity',
            ]);

            foreach ($orders as $order) {
                foreach ($order->orderItems as $item) {
                    fputcsv($file, [
                        $order->id,
                        $order->first_name . ' ' . $order->last_name,
                        $order->email,
                        $item->product_title,
                        $item->price,
                        $item->quantity
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

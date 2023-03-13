<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();

        return [
            'product_title' => $product->title,
            'price' => $product->price,
            'quantity' => fake()->numberBetween(1,10),
            'order_id' => $order->id,
            'product_id' => $product->id,
        ];
    }
}

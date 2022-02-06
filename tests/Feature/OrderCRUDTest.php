<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderType;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCaseWithSeed;

class OrderCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_orders_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = Order::count();

        $response = $this->getJson('api/orders');

        $response->assertStatus(200);

        $orders = $response->original['data'];

        $this->assertCount($expectedCount, $orders);
    }

    public function test_a_order_can_be_created()
    {
        $this->withoutExceptionHandling();

        $ordersCount = Order::count();
        $orderProductCount = DB::table('order_product')->count();

        $products = Product::select('id')
            ->take('2')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'quantity' => random_int(1, 50)
                ]; 
            })
            ->toArray();

        $ownerId = User::whereRelation('userClass', 'name', '!=', 'admin')
            ->value('id');
        $supplierId = Supplier::value('id');
        $orderTypeId = OrderType::value('id');

        $expectedAttributes = [
            'products' => $products,
            'owner_id' => $ownerId,
            'supplier_id' => $supplierId,
            'order_type_id' => $orderTypeId,
            'number' => '123456',
            'date' => '2022-01-26'
        ];
        
        $response = $this->postJson('api/orders', $expectedAttributes);
        
        $this->assertDatabaseCount('orders', $ordersCount + 1);
        $this->assertDatabaseCount('order_product', $orderProductCount + count($products));
        
        unset($expectedAttributes['products']);
        $this->assertDatabaseHas('orders', $expectedAttributes);
        $response->assertStatus(200);
    }

    public function test_a_order_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedOrder = Order::first();

        $response = $this->getJson('api/orders/' . $expectedOrder->id);

        $response->assertStatus(200);

        $order = $response->original['data'];

        $this->assertEquals($expectedOrder->getAttributes(), $order->getAttributes());
    }

    public function test_a_order_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $order = Order::first();

        $products = Product::select('id')
            ->orderBy('id', 'DESC')
            ->take('2')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'quantity' => random_int(1, 50)
                ]; 
            })
            ->toArray();

        $response = $this->putJson('api/orders/' . $order->id, [
            'products' => $products,
            'number' => '147258369'
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'number' => '147258369'
        ]);
        
        $expectedProductsCount = count($products);
        $existingProducts = $order->products;

        $this->assertCount($expectedProductsCount, $existingProducts);
    }

    public function test_a_order_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $order = Order::first();

        $response = $this->deleteJson('api/orders/' . $order->id);

        $response->assertStatus(200);

        $this->assertDeleted($order);
    }
}
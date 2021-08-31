<?php

namespace Bazar\Tests\Unit;

use Bazar\Models\Address;
use Bazar\Models\Cart;
use Bazar\Models\Order;
use Bazar\Models\Product;
use Bazar\Models\Transaction;
use Bazar\Tests\TestCase;

class OrderTest extends TestCase
{
    protected $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();

        Product::factory()->count(3)->create()->each(function ($product) {
            $this->order->items()->create([
                'buyable_id' => $product->id,
                'buyable_type' => Product::class,
                'quantity' => mt_rand(1, 5),
                'tax' => 0,
                'price' => $product->price,
                'name' => $product->name,
            ]);
        });
    }

    /** @test */
    public function it_can_belong_to_customer()
    {
        $this->assertNull($this->order->user);

        $this->order->user()->associate($this->user);

        $this->order->save();

        $this->assertSame($this->user->id, $this->order->user_id);
    }

    /** @test */
    public function it_has_transactions()
    {
        $transactions = $this->order->transactions()->saveMany(
            Transaction::factory()->count(3)->make()
        );

        $this->assertSame(
            $this->order->transactions->pluck('id')->all(), $transactions->pluck('id')->all()
        );
    }

    /** @test */
    public function it_can_have_cart()
    {
        $cart = $this->order->cart()->save(
            Cart::factory()->make()
        );

        $this->assertSame($cart->id, $this->order->cart->id);
    }

    /** @test */
    public function it_has_address()
    {
        $address = $this->order->address()->save(
            Address::factory()->make()
        );

        $this->assertSame($address->id, $this->order->address->id);
    }

    /** @test */
    public function it_has_total_attribute()
    {
        $total = $this->order->items->sum(function ($item) {
            return ($item->price + $item->tax) * $item->quantity;
        });

        $total -= $this->order->discount;

        $this->assertEquals($total, $this->order->total);
    }

    /** @test */
    public function it_has_net_total_attribute()
    {
        $total = $this->order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $total -= $this->order->discount;

        $this->assertEquals($total, $this->order->netTotal);
    }

    /** @test */
    public function it_has_query_scopes()
    {
        $this->assertSame(
            $this->order->newQuery()->whereHas('address', function ($q) {
                $q->where('bazar_addresses.first_name', 'like', 'test%')
                    ->orWhere('bazar_addresses.last_name', 'like', 'test%');
            })->toSql(),
            $this->order->newQuery()->search('test')->toSql()
        );

        $this->assertSame(
            $this->order->newQuery()->where('bazar_orders.status', 'pending')->toSql(),
            $this->order->newQuery()->status('pending')->toSql()
        );

        $this->assertSame(
            $this->order->newQuery()->whereHas('user', function ($q) {
                $q->where('users.id', 1);
            })->toSql(),
            $this->order->newQuery()->user(1)->toSql()
        );
    }
}

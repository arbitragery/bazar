<?php

namespace Bazar\Tests\Unit;

use Bazar\Models\Address;
use Bazar\Models\Cart;
use Bazar\Models\Order;
use Bazar\Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_has_cart()
    {
        $this->assertNull($this->user->cart);

        $cart = $this->user->cart()->save(
            Cart::factory()->make()
        );

        $this->user->refresh();

        $this->assertSame($cart->id, $this->user->cart->id);
    }

    /** @test */
    public function a_user_has_carts()
    {
        $cart = $this->user->carts()->save(
            Cart::factory()->make()
        );

        $this->user->refresh();

        $this->assertTrue($this->user->carts->pluck('id')->contains($cart->id));
    }

    /** @test */
    public function a_user_has_orders()
    {
        $orders = $this->user->orders()->saveMany(
            Order::factory()->count(3)->make()
        );

        $this->assertSame(
            $this->user->orders->pluck('id')->all(), $orders->pluck('id')->all()
        );
    }

    /** @test */
    public function a_user_has_addresses()
    {
        $addresses = $this->user->addresses()->saveMany(
            Address::factory()->count(3)->make()
        );

        $this->assertSame($this->user->addresses->pluck('id')->all(), $addresses->pluck('id')->all());

        $this->assertSame($this->user->address->id, $this->user->addresses->first()->id);

        $this->user->addresses->get(2)->default = true;
        $this->assertSame(
            $this->user->address->id,
            $this->user->addresses->firstWhere('default', true)->id
        );
    }

    /** @test */
    public function a_user_has_avatar()
    {
        $this->assertEquals(
            asset('vendor/bazar/img/avatar-placeholder.svg'),
            $this->user->avatar
        );
    }

    /** @test */
    public function a_user_can_be_admin()
    {
        $this->assertFalse($this->user->isAdmin());
        $this->assertTrue($this->admin->isAdmin());
    }

    /** @test */
    public function a_user_has_query_scopes()
    {
        $this->assertSame(
            $this->user->newQuery()->where(function ($q) {
                $q->where('users.name', 'like', 'test%')
                    ->orWhere('users.email', 'like', 'test%');
            })->toSql(),
            $this->user->newQuery()->search('test')->toSql()
        );
    }
}

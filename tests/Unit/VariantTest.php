<?php

namespace Bazar\Tests\Unit;

use Bazar\Models\Product;
use Bazar\Models\Variant;
use Bazar\Tests\TestCase;

class VariantTest extends TestCase
{
    protected $variant, $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();

        $this->variant = Variant::factory()->make();
        $this->variant->product()->associate($this->product);
        $this->variant->save();
    }

    /** @test */
    public function it_belongs_to_a_product()
    {
        $this->assertEquals($this->product->id, $this->variant->product_id);
    }

    /** @test */
    public function it_has_alias_attribute()
    {
        $variant = Variant::factory()->make(['alias' => 'Fake']);

        $this->assertSame('Fake', $variant->alias);

        $variant->alias = null;
        $variant->product()->associate($this->product);
        $variant->save();

        $this->assertSame("#{$variant->id}", $variant->alias);
    }

    /** @test */
    public function it_has_query_scopes()
    {
        $this->assertSame(
            $this->variant->newQuery()->where('bazar_variants.alias', 'like', 'test%')->toSql(),
            $this->variant->newQuery()->search('test')->toSql()
        );
    }
}

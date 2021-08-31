<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarCartsTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}carts", function (Blueprint $table): void {
            $table->id('id');
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained("{$this->prefix}orders")->cascadeOnDelete();
            $table->string('currency');
            $table->unsignedDecimal('discount')->default(0);
            $table->boolean('locked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists("{$this->prefix}carts");
    }
}

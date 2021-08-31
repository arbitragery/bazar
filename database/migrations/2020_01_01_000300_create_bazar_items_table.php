<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarItemsTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}items", function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->morphs('itemable');
            $table->nullableMorphs('buyable');
            $table->string('name');
            $table->unsignedDecimal('price');
            $table->unsignedDecimal('tax')->default(0);
            $table->unsignedDecimal('quantity');
            $table->json('properties')->nullable();
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
        Schema::dropIfExists("{$this->prefix}items");
    }
}

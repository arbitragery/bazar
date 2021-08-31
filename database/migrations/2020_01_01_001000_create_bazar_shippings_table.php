<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarShippingsTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}shippings", function (Blueprint $table): void {
            $table->id();
            $table->morphs('shippable');
            $table->string('driver');
            $table->unsignedDecimal('cost')->default(0);
            $table->unsignedDecimal('tax')->default(0);
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
        Schema::dropIfExists("{$this->prefix}shippings");
    }
}

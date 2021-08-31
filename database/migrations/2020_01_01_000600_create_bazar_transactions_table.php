<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarTransactionsTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}transactions", function (Blueprint $table): void {
            $table->id();
            $table->foreignId('order_id')->constrained("{$this->prefix}orders")->cascadeOnDelete();
            $table->string('key')->nullable()->unique();
            $table->string('driver');
            $table->string('type');
            $table->unsignedDecimal('amount');
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists("{$this->prefix}transactions");
    }
}

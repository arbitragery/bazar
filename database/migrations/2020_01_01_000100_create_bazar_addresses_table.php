<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarAddressesTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}addresses", function (Blueprint $table): void {
            $table->id();
            $table->morphs('addressable');
            $table->string('first_name', 60)->nullable();
            $table->string('last_name', 60)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('city', 60)->nullable();
            $table->string('postcode', 30)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('address_secondary', 100)->nullable();
            $table->string('company', 60)->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('alias')->nullable();
            $table->boolean('default')->default(false);
            $table->json('custom')->nullable();
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
        Schema::dropIfExists("{$this->prefix}addresses");
    }
}

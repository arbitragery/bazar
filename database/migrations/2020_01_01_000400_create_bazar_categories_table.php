<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarCategoriesTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}categories", function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("{$this->prefix}category_product", function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained("{$this->prefix}categories")->cascadeOnDelete();
            $table->foreignId('product_id')->constrained("{$this->prefix}products")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists("{$this->prefix}category_product");
        Schema::dropIfExists("{$this->prefix}categories");
    }
}

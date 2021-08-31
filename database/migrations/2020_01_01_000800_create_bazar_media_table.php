<?php

use Bazar\Support\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarMediaTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("{$this->prefix}media", function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->unsignedInteger('size');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('disk');
            $table->json('properties')->nullable();
            $table->timestamps();
        });

        Schema::create("{$this->prefix}mediables", function (Blueprint $table): void {
            $table->id();
            $table->foreignId('medium_id')->constrained("{$this->prefix}media")->cascadeOnDelete();
            $table->morphs('mediable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists("{$this->prefix}mediables");
        Schema::dropIfExists("{$this->prefix}media");
    }
}

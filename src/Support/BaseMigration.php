<?php

namespace Bazar\Support;

use Illuminate\Database\Migrations\Migration;

abstract class BaseMigration extends Migration
{
    protected string $prefix;

    public function __construct()
    {
        $this->prefix = config('bazar.database.prefix');
    }
}
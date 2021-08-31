<?php

namespace Bazar\Concerns;

use Illuminate\Support\Str;

trait HasTablePrefix
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        $table = $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));

        if ($prefix = config('bazar.database.prefix')) {
            return "${prefix}${$table}";
        }

        return $table;
    }
}
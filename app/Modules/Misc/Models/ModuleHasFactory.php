<?php

namespace App\Modules\Misc\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

trait ModuleHasFactory
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return self::resolveModularFactoryName();
    }

    /**
     * Convert a current class model to factory instance.
     *
     * File pattern: Modules/[MODULE]/Factories/[MODEL]Factory (singular).
     */
    public static function resolveModularFactoryName(): Factory
    {
        $factoryName = Str::replaceFirst('\\Models\\', '\\Factories\\', static::class).'Factory';

        return new $factoryName;
    }
}

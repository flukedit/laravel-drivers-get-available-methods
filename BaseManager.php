<?php

namespace App\Managers;

use Illuminate\Support\Manager;

abstract class BaseManager extends Manager
{
    /**
     * Get a list of all the available drivers determined by the existing methods, and the custom creator methods list.
     *
     * Drivers determined by custom methods will be returned in lowercase, while callbacks will be returned as the original driver set when the closure was defined.
     *
     * @param  bool $flattenDrivers This will specify whether the drivers should be separated via type, custom drivers and creator methods, or returned as a standard list.
     *
     * @return array<int, string>|array<string, array<int, string>>
     */
    public function getAvailableDrivers(bool $flattenDrivers = true): array
    {
        $uniqueMethods = array_diff(
            get_class_methods($this),
            get_class_methods(parent::class),
            [__FUNCTION__]
        );

        $methodDrivers = collect($uniqueMethods)
            ->filter(fn ($method) => preg_match('/^get.*Driver$/', $method))
            ->map(
                fn ($method) => strtolower(
                    preg_replace(
                        ['/^get/', '/Driver$/'],
                        '',
                        $method
                    )
                )
            )
            ->toArray();

        $callbackDrivers = $this->getCustomCreatorKeys();

        if ($flattenDrivers) {
            return array_merge($methodDrivers, $callbackDrivers);
        }

        return [
            'custom_drivers' => $methodDrivers,
            'creator_methods' => $callbackDrivers,
        ];
    }

    /** @return string[] */
    public function getCustomCreatorKeys(): array
    {
        return array_keys($this->customCreators);
    }
}

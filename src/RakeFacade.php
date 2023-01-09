<?php

namespace PhamLuann\Rake;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PhamLuann\Rake\Skeleton\SkeletonClass
 */
class RakeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rake';
    }
}

<?php

namespace Heystack\Core\Loader;

use Closure;
use DataList;
use Symfony\Component\Config\Loader\Loader;

/**
 * Used to process datalists via callback
 * @package Heystack\Core\Loader
 */
class DBClosureLoader extends Loader
{
    /**
     * @var callable
     */
    protected $handler;

    /**
     * @param callable $handler
     */
    public function __construct(Closure $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Loads a resource.
     *
     * @param  mixed                     $resource The resource
     * @param  string                    $type     The resource type
     * @throws \InvalidArgumentException
     */
    public function load($resource, $type = null)
    {
        $handler = $this->handler;
        if ($resource instanceof DataList) {
            foreach ($resource as $index => $record) {
                $handler($record, $index);
            }
        } else {
            throw new \InvalidArgumentException('Resource provided to DBClosureLoader is not a DataList');
        }
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return Boolean true if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return $resource instanceof DataList;
    }

}

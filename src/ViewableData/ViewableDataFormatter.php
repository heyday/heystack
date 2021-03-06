<?php

namespace Heystack\Core\ViewableData;

/**
 * Allows objects that implement \Heystack\Core\ViewableDataInterface
 * to be used in SS templates.
 *
 * @copyright  Heyday
 * @author Cam Spiers <cameron@heyday.co.nz>
 * @author Glenn Bautista <glenn@heyday.co.nz>
 * @package Heystack
 *
 */
class ViewableDataFormatter extends \ViewableData
{
    /**
     * @var \Heystack\Core\ViewableData\ViewableDataInterface
     */
    protected $obj;

    /**
     * @param ViewableDataInterface $obj
     */
    public function __construct(ViewableDataInterface $obj)
    {
        $this->obj = $obj;

        parent::__construct();
    }

    /**
     * @param  string $field
     * @return string|null
     */
    public function castingHelper($field)
    {
        $castings = $this->obj->getCastings();
        if (isset($castings[$field])) {
            return $castings[$field];
        } else {
            return parent::castingHelper($field);
        }
    }

    /**
     * @param  string     $method
     * @param  array      $arguments
     * @return bool|mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this->obj, 'get' . $method)) {
            $value = call_user_func_array([$this->obj, 'get' . $method], $arguments);
            if (is_object($value) && ($constructor = $this->castingHelper($method))) {
                $object = \Injector::inst()->create($constructor, $method);
                $object->setValue($value);
                return $object;
            } else {
                return $value;
            }
        } elseif (in_array($method, $this->obj->getDynamicMethods())) {
            return $this->obj->$method;
        }

        return false;
    }

    /**
     * @param  string $property
     * @return bool
     */
    public function __get($property)
    {
        if (isset($this->obj->$property)) {
            return $this->obj->$property;
        }

        return false;
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     */
    public function __set($property, $value)
    {
        $this->obj->$property = $value;
    }

    /**
     * @param  string $method
     * @return bool
     */
    public function hasMethod($method)
    {
        return method_exists($this->obj, 'get' . $method) || $this->hasDynamicMethod($method);
    }

    /**
     * @return \Heystack\Core\ViewableDataInterface
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function hasDynamicMethod($method)
    {
        $dynamicMethods = $this->obj->getDynamicMethods();
        return is_array($dynamicMethods) && in_array($method, $dynamicMethods);
    }
}

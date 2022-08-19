<?php

namespace JeanKassio\Deluge\DelugeFunctions;

/**
 * Class BaseType
 * @package NEOSoftWare\Deluge\Type
 */
abstract class BaseType
{
    /** @var BaseType[]|null */
    protected static $types;

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromData(array $data)
    {
        $r = 1;

        $self = new static();

        foreach ($data as $key => $value) {
            if (isset(static::$types[$key])) {
                if (is_array(static::$types[$key])) {
                    $class = reset(static::$types[$key]);
                    foreach ($value as $valueItem) {
                        $self->{$key}[] = $class::fromData($valueItem);
                    }
                } else {
                    $class = static::$types[$key];
                    $self->{$key} = $class::fromData($value);
                }
            } else {
                $self->{$key} = $value;
            }
        }

        return $self;
    }
}

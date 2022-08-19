<?php

namespace JeanKassio\Deluge\DelugeFunctions;

abstract class BaseType
{
    protected static $types;

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

<?php
namespace kfosoft\helpers;

/**
 * Array Helper static class.
 * @package kfosoft\helpers
 * @version 1.0.1
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */
class ArrayHelper
{
    /**
     * Returns arrays difference.
     * @see http://php.net/manual/ru/function.array-diff-assoc.php
     * @param array $array1
     * @param array $array2
     * @return array difference.
     */
    public static function rDiffAssoc($array1, $array2)
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (!isset($array2[$key]) || !is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $recursiveDiff = static::rDiffAssoc($value, $array2[$key]);
                    (!empty($recursiveDiff)) && ($difference[$key] = $recursiveDiff);
                }
            } else {
                if (!array_key_exists($key, $array2) || $array2[$key] !== $value) {
                    $difference[$key] = $value;
                }
            }
        }

        return $difference;
    }

    /**
     * Returns arrays difference.
     * @see http://stackoverflow.com/questions/3876435/recursive-array-diff
     * @param array $array1
     * @param array $array2
     * @return array difference.
     */
    public static function rDiff($array1, $array2)
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (array_key_exists($key, $array2)) {
                if (is_array($value)) {
                    $recursiveDiff = static::rDiff($value, $array2[$key]);

                    if (count($recursiveDiff)) {
                        $difference[$key] = $recursiveDiff;
                    }
                } else {
                    if (!in_array($value, $array2)) {
                        $difference[$key] = $value;
                    }
                }
            } else {
                if (!in_array($value, $array2)) {
                    $difference[$key] = $value;
                }
            }
        }

        return $difference;
    }

    /**
     * Returns nearest array key.
     * @see http://php.net/manual/en/function.array-search.php
     * @param string|int $needle needle.
     * @param array $haystack haystack.
     * @return null|int|string nearest array key.
     */
    public static function rSearch($needle, array $haystack)
    {
        foreach ($haystack as $key => $value) {
            $current_key = $key;
            if ($needle === $value || (is_array($value) && self::rSearch($needle, $value) !== null)) {
                return $current_key;
            }
        }
        return null;
    }
}

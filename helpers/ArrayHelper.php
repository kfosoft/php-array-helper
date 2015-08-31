<?php
namespace ctur\helpers;

/**
 * Array Helper static class.
 * @package ctur\helpers
 * @author Cyril Turkevich
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
}

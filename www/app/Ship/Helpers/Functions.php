<?php

if (!function_exists('listDir')) {
    function listDir($dir)
    {
        $skip = ['.', '..'];
        $files = scandir($dir);
        foreach ($files as $key => $file) {
            if (in_array($file, $skip) || !is_dir($dir . $file)) {
                unset($files[$key]);
            } else {
                $files[$key] = $file;
            }
        }
        return $files;
    }
}

if (!function_exists('isDevelop')) {
    function isDevelop(): bool
    {
        return config('app.debug');
    }
}

if (!function_exists('loadAd')) {
    function loadAd(string $id, string $idPostFix = '')
    {
        $viewData = [
            'id' => $idPostFix ? ($id . '-' . $idPostFix) : $id,
            'isDummy' => isDevelop(),
            'configurationKey' => $id,
        ];
        return view('partials.ad_dummy', $viewData)->render();
    }
}

if (!function_exists('pluralForm')) {
    function pluralForm($number, $after)
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}
if (!function_exists('pluralFormEn')) {
    function pluralFormEn(int $amount, $singular, $plural): string
    {
        if ($amount === 1) {
            return $amount . ' ' . $singular;
        }
        return $amount . ' ' . $plural;
    }
}

if (!function_exists('mbUcfirst')) {
    function mbUcfirst($string, $enc = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
            mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }
}

if (!function_exists('trimData')) {
    function trimData($data)
    {
        if ($data === null) {
            return null;
        }

        if (is_array($data)) {
            return array_map('trimData', $data);
        } else {
            return trim(cleaner($data));
        }
    }
}

if (!function_exists('deleteLongSpace')) {
    function deleteLongSpace($row = false)
    {
        if ($row) {
            return preg_replace('/ {2,}/', ' ', $row);
        }
        return $row;
    }
}

if (!function_exists('cleaner')) {
    function cleaner($row)
    {
        return deleteLongSpace($row);
    }
}

if (!function_exists('frenchQuotes')) {
    function frenchQuotes(string $row)
    {
        return '«' . $row . '»';
    }
}


if (!function_exists('groupArray')) {
    /** Группирует массив в вид
     *
     * [
     *      $formattedItem[$arrayItem[$key]] => [
     *              [$field1 => $arrayItem[$field1], $field2 => $arrayItem[$field2],
     *              [$field1 => $arrayItem[$field1], $field2 => $arrayItem[$field2],
     *      ]
     * ]
     *
     * Например, группировка рейтингов(каждый из которых является массивом) под идентификатор лиги
     * @param $array
     * @param $key
     * @param array $fields в случае пустого массива заносит весь элемент
     * @return array
     */
    function groupArray($array, $key, array $fields = []): array
    {
        $formattedArray = [];
        if ($array) {
            foreach ($array as $item) {
                if (empty($formattedArray[$item[$key]])) {
                    $formattedArray[$item[$key]] = [];
                }
                $subArray = [];
                if ($fields === []) {
                    $subArray = $item;
                } else {
                    foreach ($fields as $field) {
                        if (isset($item[$field])) {
                            $subArray[$field] = $item[$field];
                        }
                    }
                }
                if ($subArray) {
                    $formattedArray[$item[$key]][] = $subArray;
                }
            }
        }
        return $formattedArray;
    }
}

if (!function_exists('setFieldAsArrayKey')) {
    /** Устанавливает в качестве ключа массива, значения из элемента-массива по ключу
     *
     * @param array $array
     * @param string $key - новый ключ массив
     * @param array $stayFields - массив ключей, которые нужно оставить в массиве
     * @param boolean $onlyValue - добавление указанного $stayFields в массив без ключа отработает в случае,
     * если передан только один ключ
     * @return array
     */
    function setFieldAsArrayKey($array = [], $key = 'id', $stayFields = [], $onlyValue = false): array
    {
        if (is_array($array) && $array != []) {
            $formattedArray = [];
            foreach ($array as $item) {
                if ($stayFields !== []) {
                    if (count($stayFields) === 1 && $onlyValue) {
                        foreach ($stayFields as $stayField) {
                            if (isset($item[$stayField])) {
                                $formattedArray[$item[$key]] = $item[$stayField];
                            }
                        }
                    } else {
                        foreach ($stayFields as $stayField) {
                            if (isset($item[$stayField])) {
                                $formattedArray[$item[$key]][$stayField] = $item[$stayField];
                            }
                        }
                    }
                } else {
                    $formattedArray[$item[$key]] = $item;
                }
            }
            return $formattedArray;
        }
        return [];
    }
}

if (!function_exists('getFirstItemFromArray')) {
    function getFirstItemFromArray(array $baseArray)
    {
        $array = array_slice($baseArray, 0, 1);
        return array_shift($array);
    }
}

if (!function_exists('getLastItemFromArray')) {
    function getLastItemFromArray(array $baseArray)
    {
        $array = array_slice($baseArray, -1);
        return array_shift($array);
    }
}

if (!function_exists('getLangRoute')) {
    function getLangRoute(string $name): string
    {
        $locale = app()->getLocale();
        return $locale . '.' . $name;
    }
}
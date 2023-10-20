<?php

function removeLastStringOcurrence(string $haystack, string $needle)
{
    $pos = strrpos($haystack, $needle);
    if ($pos !== false) {
        $haystack = substr($haystack, 0, $pos);
    }
    return $haystack;
}

function isEmail(string $email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isValidPassword(string $password)
{
    if (!preg_match("/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=!]).{8,}$/", $password)) {
        return false;
    }
    return true;
}

function isValidEmail(string $email)
{
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        return false;
    }
    return true;
}

function transformCamelCaseToSnakeCase(array $args)
{
    foreach ($args as &$originalString) {
        $transformedString = preg_replace('/([a-z])([A-Z])/', '$1_$2', $originalString);
        $originalString = strtolower($transformedString);
    }
    return $args;
}

function formatDate($days)
{
    date_default_timezone_set('America/Sao_Paulo');
    $date = new DateTime();

    $date->modify($days);
    $formatedDate = $date->format('Y-m-d');
    return $formatedDate;
}

function formatDateTime($days, $hour, $minute, $second)
{
    date_default_timezone_set('America/Sao_Paulo');
    $dateTime = new DateTime();

    $dateTime->modify($days);
    $dateTime->setTime($hour, $minute, $second);

    $formatedDateTime = $dateTime->format('Y-m-d H:i:s');
    return $formatedDateTime;
}

function checkIsMethodsFilled($obj)
{
    $reflection = new ReflectionClass($obj);
    $isMethods = [];

    foreach ($reflection->getMethods() as $method) {
        if (strpos($method->name, 'is') === 0 && $method->getNumberOfParameters() === 0) {
            $propertyName = lcfirst(substr($method->name, 2));
            $isMethods[$propertyName] = $obj->{$method->name}();
        }
    }

    return $isMethods;
}

function checkGettersFilled($obj)
{
    $reflection = new ReflectionClass($obj);
    $getters = [];

    foreach ($reflection->getMethods() as $method) {
        if (strpos($method->name, 'get') === 0 && $method->getNumberOfParameters() === 0) {
            $propertyName = lcfirst(substr($method->name, 3));
            $getters[$propertyName] = $obj->{$method->name}();
        }
    }

    return $getters;
}

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if (str_replace("www.", "", $_SERVER['HTTP_HOST']) == "localhost") {
        if ($path) {
            return CONF_URL_TEST .
                "/" .
                ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE .
            "/" .
            ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

/**
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(string $path = null, string $theme = CONF_VIEW_THEME): string
{
    if (str_replace("www.", "", $_SERVER['HTTP_HOST']) == "localhost") {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * @param string $url
 * @return void
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit();
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit();
    }
}

/**
 * filter_type: Principais campos de consulta para os relatórios. O que não estiver
 * nessa lista será tratado como FILTER_SANITIZE_FULL_SPECIAL_CHARS pelos helpers de filtro
 * @return null|array
 */
function filter_type(): array
{
    $filterFields = [
        "route" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "product" => FILTER_SANITIZE_NUMBER_INT,
        "product_id" => FILTER_SANITIZE_NUMBER_INT,
        "country" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "device" => FILTER_SANITIZE_NUMBER_INT,
        "redirect" => FILTER_SANITIZE_ENCODED,
        "status" => FILTER_SANITIZE_NUMBER_INT,
        "upsell" => FILTER_SANITIZE_NUMBER_INT,
        "paymentMethod" => FILTER_SANITIZE_NUMBER_INT,
        "company" => FILTER_SANITIZE_NUMBER_INT,
        "affiliate" => FILTER_SANITIZE_NUMBER_INT,
        "level" => FILTER_SANITIZE_NUMBER_INT,
        "group_id" => FILTER_SANITIZE_NUMBER_INT,
        "report_id" => FILTER_SANITIZE_NUMBER_INT,
    ];
    return $filterFields;
}

/**
 * filter_array: Filtrar campos de array ou globais GET e POST
 * @param array $array
 * @return array
 */
function filter_array(array $array): array
{
    $filterFields = filter_type();

    foreach ($array as $key => $value) {
        if (in_array($key, array_keys($filterFields))) {
            $filterArr[$key] = $filterFields[$key];
        } else {
            $filterArr[$key] = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
        }
    }
    return filter_var_array($array, $filterArr);
}

/**
 * @param string $string
 * @param string $type = int, string, chars, etc
 * @return string
 */
function filter_variable(string $string, $type = null): string
{
    if (!empty($type)) {
        $type = mb_convert_case($type, MB_CASE_LOWER);

        if ($type == 'default') {
            return filter_var($string, FILTER_DEFAULT);
        } elseif ($type == 'int') {
            return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        } elseif ($type == 'string') {
            return filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } elseif ($type == 'chars') {
            return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        } elseif ($type == 'mail' || $type == 'email') {
            return filter_var($string, FILTER_VALIDATE_EMAIL);
        }
    }
    return filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

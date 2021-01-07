<?php

/**
 * 打印函数
 * @param string $data
 */
function p(...$arg)
{
    echo "<pre>";
    print_r($arg[0]);
    echo "</pre>";
    exit();
}

/**
 * [write_log 写入日志]
 * @param  [type] $data [写入的数据]
 * @return void [type]       [description]
 */
function write_log($data)
{
    //设置路径目录信息
    $url = './log/' . date('Ymd') . '_log.txt';
    $dir_name = dirname($url);
    //目录不存在就创建
    if (!file_exists($dir_name)) {
        //iconv防止中文名乱码
        $res = mkdir(iconv("UTF-8", "GBK", $dir_name), 0777, true);
    }
    $fp = fopen($url, "a");//打开文件资源通道 不存在则自动创建
    fwrite($fp, '[' . date("Y-m-d H:i:s") . ']:' . var_export($data, true) . "\r\n");//写入文件
    fclose($fp);//关闭资源通道
}

/**
 * 读取csv
 *
 * @param $fileName
 * @return array
 */
function getFileData($fileName)
{
    if (!is_file($fileName)) {
        p('没有文件');
    }
    $handle = fopen($fileName, 'r');
    if (!$handle) {
        p('读取文件失败');
    }
    $csvData = [];
    while (($data = fgetcsv($handle)) !== false) {
        // 跳过标题
        if ($data[0] == 'loan_id' || $data[1] == 'apply_no') {
            continue;
        }

        $csvData[] = $data;
    }
    fclose($handle);

    return $csvData;
}

/**
 * @param $string
 */
function error($string)
{
    echo "\033[31m$string\033[0m\n\"";
}

/**
 * @param $string
 */
function info($string)
{
    echo "\033[01;40;32m$string\033[0m\n\"";
}


/**
 * 随机字符串
 *
 * @param int $length
 * @return string
 * @throws Exception
 */
function random($length = 16)
{
    $string = '';

    while (($len = strlen($string)) < $length) {
        $size = $length - $len;

        $bytes = random_bytes($size);

        $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
    }

    return $string;
}

/**
 * 检测日期格式
 *
 * @param $data
 * @return bool
 */
function isDate($data)
{
    $date = strtotime($data);
    if ($data == (date("Ymd", $date)))
        return true;
    else
        return false;
}

function config($arg = '',$delimiter='.')
{
    if(empty($arg)) return false;
    $keys = explode($delimiter, $arg);
    $fileName = array_shift($keys);
    $arr = include ("./config/{$fileName}.php");
    if(count($keys)<1){
        return $arr;
    }
    $keys = implode($delimiter,$keys);
    return getValByKey($arr,$keys,$delimiter);
}

function getValByKey($array, $keys, $delimiter)
{
    $keys = explode($delimiter, $keys);
    $key = array_shift($keys);
    if (sizeof($keys) > 0 && isset($array[$key])) {
        return getValByKey($array[$key], implode($delimiter, $keys), $delimiter);
    } else {
        return $array[$key] ?? null;
    }
}

function env($key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return value($default);
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return;
    }

    if (strlen($value) > 1 && startsWith($value, '"') && endsWith($value, '"')) {
        return substr($value, 1, -1);
    }

    return $value;

}

/**
 * Determine if a given string ends with a given substring.
 *
 * @param string $haystack
 * @param string|array $needles
 * @return bool
 */
function endsWith($haystack, $needles)
{
    foreach ((array)$needles as $needle) {
        if (substr($haystack, -strlen($needle)) === (string)$needle) {
            return true;
        }
    }

    return false;
}

/**
 * Determine if a given string starts with a given substring.
 *
 * @param string $haystack
 * @param string|array $needles
 * @return bool
 */
function startsWith($haystack, $needles)
{
    foreach ((array)$needles as $needle) {
        if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string)$needle) {
            return true;
        }
    }

    return false;
}

/**
 * Return the default value of the given value.
 *
 * @param mixed $value
 * @return mixed
 */
function value($value)
{
    return $value instanceof Closure ? $value() : $value;
}
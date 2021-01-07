#!/usr/bin/php
<?php
include_once('init.php');
# use php run.php -f fileName

if (php_sapi_name() != 'cli') {
    die('error: currently not in cli mode!' . PHP_EOL);
}

// file
if (isset($argv[1]) && $argv[1] != '-f') {
    die('error: missing parameter -f' . PHP_EOL);
}

$source_file = $argv[2] ?? '';


$file_name = __DIR__ . '/novel_files/' . $source_file;

$path_info = explode('.', $source_file);

$create_file_path = './novel_files/' . $path_info[0];

$str = file_get_contents($file_name);

// 乱码文件请打开这个
// $str = mb_convert_encoding(file_get_contents($file_name), "UTF-8", "GBK");

$arr = [];
if (preg_match_all(
    "/(\x{7b2c})(\s*)([\x{96f6}\x{4e00}\x{4e8c}\x{4e09}\x{56db}\x{4e94}\x{516d}\x{4e03}\x{516b}\x{4e5d}\x{5341}\x{767e}\x{5343}0-9]+)(\s*)([\x{7ae0}\x{8282}]+)/u",
    $str, $matches)
) {
    $matches = array_slice($matches[0], 0, count($matches[0]));
    for ($i = 0; $i < count($matches); $i++) {
        $j = $i + 1;
        if (isset($matches[$j])) {
            $pattern = "#$matches[$i](.*)$matches[$j]#isU";
            $arr[$i] = $pattern;
        } else {
            $offset = count($arr);
            $arr[$offset] = "#$matches[$i](.*)[\w]#isU";
        }
    }
}
$arr = array_unique($arr);
foreach ($arr as $key => $value) {
    preg_match($value, $str, $arr[$key]);
    unset($arr[$key][0]);
}
static $bookContent = [];
foreach ($arr as $key => $value) {
    if (isset($value[1])) {
        $chaptername = strstr($value[1], "\n", true);
    } else {
        $chaptername = 'errors_title';
    }
    @$bookContent[$matches[$key] . $chaptername] = $value[1];
}
$i = 0;

foreach ($bookContent as $key => $value) {
    $i++;
    $file_name = $create_file_path . '/' . $i . '.txt';
    if (!is_dir($create_file_path)) {
        mkdir($create_file_path);
    }

    file_put_contents($file_name, $value);

    #['novelName'=>$path_info[0],'novelTitle'=>$key,'filePath'=>$file_name]
    #redis
    $redis->lpush($path_info[0], $key . '|' . $file_name);

    # mysql
    $rs = $dbh->exec("INSERT INTO `novel_details` (`novel_name`,`novel_title`,`file_path`) VALUES ('$path_info[0]','$key','$file_name')");
}

# redis
$redis->lpush('books', $path_info[0]);

# mysql novel_list
$rs = $dbh->exec("INSERT INTO `novel_list` (`title`) VALUES ('$path_info[0]')");



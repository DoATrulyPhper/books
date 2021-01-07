<?php
include_once('init.php');

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

$str = explode("\n", file_get_contents($file_name));
foreach ($str as $value) {
	if(!empty(trim($value))){
		echo $value.PHP_EOL;
	}
}

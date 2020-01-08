<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$list = $redis->lrange("books", 0 ,-1);

foreach ($list as $value) {
	$redis->delete($value);
}

$redis->delete('books');
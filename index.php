<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$list = $redis->lrange("books", 0 ,-1);
$list = array_reverse($list);

foreach ($list as $key => $value) {

	$url = './list.php?title='.$value;

	echo "<a href='".$url."'>".$value."</a>"."<br />";
}
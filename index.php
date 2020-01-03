<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$list = $redis->lrange("oushen", 0 ,-1);
$list = array_reverse($list);
$i = count($list);
foreach ($list as $key => $value) {
    $i--;
	$info = explode('|',$value);

	$url = './readme.php?title='.$info[0].'&path='.$info[1].'&index='.$i;

	echo "<a href='".$url."'>".$info[0]."</a>"."<br />";
}
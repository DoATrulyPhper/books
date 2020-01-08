<?php

$title = $_GET['title'];

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$list = $redis->lrange($title, 0 ,-1);
$list = array_reverse($list);
$i = count($list);
foreach ($list as $key => $value) {
    $i--;
	$info = explode('|',$value);
	$bookname = explode('/',$info[1])[3];
	$url = './readme.php?title='.$info[0].'&path='.$info[1].'&index='.$i.'&bookname='.$bookname;

	echo "<a href='".$url."'>".$info[0]."</a>"."<br />";
}
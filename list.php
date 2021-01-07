<?php
include_once ('init.php');
$bookname = $_GET['title'];

# redis
$list = $redis->lrange($bookname, 0 ,-1);

# mysql
// $list = $dbh->query("SELECT * FROM `novel_details` WHERE novel_name='$title'")
//     ->fetchAll(PDO::FETCH_ASSOC);

$i = count($list);
krsort($list);
foreach ($list as $key => $value) {
    $i--;
    # redis
	$info = explode('|',$value);
    $title = $info[0];
    $path = $info[1];

    # mysql
    // $title = $value['novel_title'];
    // $path = $value['file_path'];

	$url = './readme.php?title='.$title.'&path='.$path.'&index='.$i.'&bookname='.$bookname;
	echo "<a href='".$url."'>".$title."</a>"."<br />";
}
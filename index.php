<?php
include_once('init.php');

# redis
# $list = $redis->lrange("books", 0 ,-1);
# $list = array_unique(array_reverse($list));

# mysql
$list = $dbh->query('SELECT `title` FROM `novel_list`')
            ->fetchAll(PDO::FETCH_ASSOC);

foreach ($list as $key => $value) {
	$url = './list.php?title='.$value['title'];
	echo "<a href='".$url."'>".$value['title']."</a>"."<br />";
}
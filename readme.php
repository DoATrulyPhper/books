<?php


$info = $_GET;


$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$index = $info['index'];
$bookname = $info['bookname'];
@$next_info = explode('|',$redis->lrange($bookname,$index-1,$index-1)[0]);
@$prev_info = explode('|',$redis->lrange($bookname,$index+1,$index+1)[0]);
$next = '';
if(count($next_info) > 1){
    $next = './readme.php?title='.$next_info[0].'&path='.$next_info[1].'&index='.($index-1).'&bookname='.$bookname;
}
$prev = '';
if(count($prev_info) > 1){
    $prev = './readme.php?title='.$prev_info[0].'&path='.$prev_info[1].'&index='.($index+1).'&bookname='.$bookname;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="./static/book.css">
</head>
<body>
<main>
    <a href="./index.php">返回</a>
    <section>
        <h1><?php echo $info['title'] ?></h1>
        <?php
        foreach (file($info['path']) as $key => $item ){
            echo "<p>".$item."</p>";
        }
        ?>
    </section>
    <?php
        if(!empty($prev)){
            echo '<button><a href="'.$prev.'">上一章</a></button>';
        }
        if(!empty($next)){
            echo '<button><a href="'.$next.'">下一章</a></button>';
        }
    ?>
</main>


</body>

<script type="text/javascript" src="./static/jquery.js"></script>
<script type="text/javascript" src="./static/book.js"></script>

</html>
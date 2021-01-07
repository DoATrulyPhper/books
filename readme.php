<?php
include_once ('init.php');
$info = $_GET;

$index = $info['index'];
$bookname = $info['bookname'];
$path = $info['path'];

#redis
@$next_info = explode('|',$redis->lrange($bookname,$index-1,$index-1)[0]);
@$prev_info = explode('|',$redis->lrange($bookname,$index+1,$index+1)[0]);
// # mysql
// #string(141) "./readme.php?title=第一章 说好的反杀呢？ &path=./novel_files/全球武神/1.txt&index=496&bookname=第一章 说好的反杀呢？ " 第一章 说好的反杀呢？
// #string(129) "./readme.php?title=第二章 走火入魔？ &path=./novel_files/全球武神/2.txt&index=495&bookname=第二章 走火入魔？ " 第二章 走火入魔？
// $now = substr(explode('/', $path)[3],0,1);

// $next_info=[
//     $bookname,str_replace($now, $now + 1, $path)
// ];
// $prev_info = [
//     $bookname,str_replace($now, $now - 1, $path)
// ];

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
        <a href="/php/books/list.php?title=<?php echo $bookname ?>">返回</a>
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
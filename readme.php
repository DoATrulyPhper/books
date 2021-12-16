<?php
include_once('init.php');
$info = $_GET;

$index = $info['index'];
$bookname = $info['bookname'];
$path = $info['path'];


#redis
// @$next_info = explode('|',$redis->lrange($bookname,$index-1,$index-1)[0]);
// @$prev_info = explode('|',$redis->lrange($bookname,$index+1,$index+1)[0]);
// # mysql
// #string(141) "./readme.php?title=第一章 说好的反杀呢？ &path=./novel_files/全球武神/1.txt&index=496&bookname=第一章 说好的反杀呢？ " 第一章 说好的反杀呢？
// #string(129) "./readme.php?title=第二章 走火入魔？ &path=./novel_files/全球武神/2.txt&index=495&bookname=第二章 走火入魔？ " 第二章 走火入魔？
$now = substr(explode('/', $path)[3], 0, -4);
$next_info = [
    $bookname, str_replace($now, $now + 1, $path)
];
$prev_info = [
    $bookname, str_replace($now, $now - 1, $path)
];

$next = '';
if (count($next_info) > 1) {
    $next = './readme.php?path=' . $next_info[1] . '&index=' . ($index - 1) . '&bookname=' . $bookname;
}
$prev = '';
if (count($prev_info) > 1) {
    $prev = './readme.php?path=' . $prev_info[1] . '&index=' . ($index + 1) . '&bookname=' . $bookname;
}

$title = $dbh->query("SELECT * FROM `novel_details` WHERE file_path='$path'")
    ->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="./static/book.css">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<main>

    <section>
        <h1><?php echo $info['title'] ?? $title['novel_title'] ?></h1>
        <?php
        setcookie("history", $_SERVER['REQUEST_URI'], 2147483647);
        setcookie("bookname", $title['novel_title'], 2147483647);
        $detail = file($info['path']);
        $detail[0] = '';
        foreach ($detail as $key => $item) {
            echo "<p>" . $item . "</p>";
        }
        ?>
        <hr>
        <div style="float: right;">
            <a href="/books/list.php?title=<?= $bookname ?>">
                <button class="btn btn-default">返回</button>
            </a>
            <?php
            if (!empty($prev)) {
                echo '<a href="' . $prev . '"><button class="btn btn-info">上一章</button></a> ';
            }
            if (!empty($next)) {
                echo ' <a href="' . $next . '"><button class="btn btn-info">下一章</button></a>';
            }
            ?>
        </div>
    </section>

</main>


</body>

<script type="text/javascript" src="./static/jquery.js"></script>
<script type="text/javascript" src="./static/book.js"></script>

</html>

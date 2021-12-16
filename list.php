<?php
include_once ('init.php');
$bookname = $_GET['title'];
$title = $_POST['title'] ?? '';
# redis
// $list = $redis->lrange($bookname, 0 ,-1);

# mysql
$sql = "SELECT * FROM `novel_details` WHERE novel_name='$bookname'";

if ($title != '') {
    $sql.= " and novel_title like '%$title%';";
}

$list = $dbh->query($sql)
    ->fetchAll(PDO::FETCH_ASSOC);

$i = count($list);
sort($list);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<form name="input" action="./list.php?title=<?php echo $bookname; ?>" method="post">
    <br>
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." name="title">
        <hr>
        <button class="btn btn-success" type="submit">搜索</button>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href='./index.php'><button class="btn btn-default">返回</button></a></br></br>
      </span>
        <?php
            if(isset($_COOKIE['history']) && !empty($_COOKIE['history'])){
        ?>
                系统检测到上次浏览到 <span style="font-size: 20px;color: red;"><?php echo $_COOKIE['bookname']; ?></span> 是否 <a href="<?php echo $_COOKIE['history']; ?>">继续阅读</a>
        <?php
            }
        ?>

    </div>
</form>
<hr>
    <?php
    foreach ($list as $key => $value) {
    $i--;
    # redis
    // $info = explode('|',$value);
    //    $title = $info[0];
    //    $path = $info[1];

    # mysql
    $title = $value['novel_title'];
    $path = $value['file_path'];

    $url = './readme.php?title='.$title.'&path='.$path.'&index='.$i.'&bookname='.$bookname;
    echo "<a href='".$url."' style='font-size:18px;'>".$title."</a>"."<br />";
    }
    ?>


</body>
</html>

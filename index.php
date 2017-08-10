<?php ini_set('date.timezone', 'Asia/Shanghai'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <script type="text/javascript" src="js/lib/jquery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<?php

use com\qefee\app\model\DBInfo;

include_once "model/DBInfo.php";

$page = 1;
$post_per_page = 10;
if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);

    $page = $page >= 1 ? $page : 1;
}
$startItem = ($page - 1) * $post_per_page;
try {
$dbInfo = DBInfo::getInstance();
$pdo = new PDO($dbInfo->dsn, $dbInfo->user, $dbInfo->password); //初始化一个PDO对象

$totalCountSql = <<<str
        SELECT count(*) AS total
        FROM qefee_share.post AS p
        WHERE p.status = '0'
str;

$totalCountQuery = $pdo->query($totalCountSql);
$totalCount = intval($totalCountQuery->fetch()["total"]);
$hasNextPage = ($totalCount - $page * $post_per_page) > 0;
?>
<div class="navigation">
    <ul>
        <li><a href="index.php">index</a></li>
        <li><a href="newPost.html">new post</a></li>
        <?php
        if ($hasNextPage) {
            ?>
            <li>
                <a href="?page=<?php echo isset($_GET["page"]) && intval($_GET["page"]) >= 1 ? $_GET["page"] + 1 : 2; ?>">next
                    page</a></li>
            <?php
        }
        ?>

    </ul>
</div>
<div class="posts">
    <?php

    $strSql = <<<str
        SELECT p.id, 
                p.title, 
                p.content, 
                p.type, 
                p.ip, 
                p.author_id, 
                p.from, 
                p.create_at, 
                p.modify_at,
                (SELECT count(*) 
                FROM qefee_share.comment as c 
                WHERE c.post_id = p.id) AS comment_count
        FROM qefee_share.post as p
        WHERE p.status = '0'
        ORDER BY p.modify_at DESC
        LIMIT $startItem, $post_per_page
str;
    $result = $pdo->query($strSql);

    $rows = $result->fetchAll();

    $n = 0;
    foreach ($rows as $row) {
        $n++;
        $oddEven = $n % 2 == 0 ? "even" : "odd";
        ?>

        <div class="post <?php echo $oddEven; ?>">
            <span class="postIndex">No.<?php echo $n; ?></span>

            <?php
            if ($row["type"] == "url") {
                ?>
                <span class="title"><a href="<?php echo $row["content"]; ?>"
                                       target="_blank">【<?php echo $row["from"]; ?>
                        】&nbsp;&nbsp;<?php echo $row["title"]; ?></a></span>
                <?php
            } else {
                ?>

                <span class="title">【<?php echo $row["from"]; ?>】&nbsp;&nbsp;<?php echo $row["title"]; ?></span>
                <div class="content"><?php echo $row["content"]; ?></div>
                <?php
            }
            ?>
        </div>

        <?php
    }
    } catch (PDOException $e) {
        die ("Error!: " . $e->getMessage());
    }
    ?>
</div>

</body>
</html>
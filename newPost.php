<?php ini_set('date.timezone', 'Asia/Shanghai'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New post</title>
</head>
<body>

<ul>
    <li><a href="index.php">index</a></li>
    <li><a href="newPost.html">new post</a></li>
</ul>


<?php

use com\qefee\app\model\DBInfo;

include_once "model/DBInfo.php";
include_once "model/JsonData.php";
$msg = new \com\qefee\app\model\JsonData();
$msg->code = 0;

function clearInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function newPost($title, $content, $from, $type, $ip)
{
    try {
        $dbInfo = DBInfo::getInstance();
        $pdo = new PDO($dbInfo->dsn, $dbInfo->user, $dbInfo->password); //初始化一个PDO对象

        $strSql = <<<str
            INSERT INTO qefee_share.post
            (post.title, 
            post.content, 
            post.from,
            post.type,
            post.ip)
            VALUES
            (?,?,?,?,?);
str;
        $statement = $pdo->prepare($strSql);

        $result = $statement->execute(
            array(
                $title,
                $content,
                $from,
                $type,
                $ip
            )

        );

        return $result;
    } catch (PDOException $e) {
        $logFile = "newPost.log";
        file_put_contents($logFile, $e, FILE_APPEND);
    }

    return false;
}

$title = "";
$content = "";
$from = "";
$type = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["title"])) {
        $title = clearInput($_POST["title"]);

        if (empty($title)) {
            $msg->code = -1;
            $msg->msg = "no title";
        } else {
            if (isset($_POST["content"])) {
                $content = clearInput($_POST["content"]);

                if (empty($content)) {
                    $msg->code = -1;
                    $msg->msg = "no content";
                } else {
                    if (isset($_POST["from"])) {
                        $from = clearInput($_POST["from"]);

                        if (empty($title)) {
                            $msg->code = -1;
                            $msg->msg = "no title";
                        } else {
                            if (isset($_POST["type"])) {
                                $type = clearInput($_POST["type"]);

                                if (empty($type)) {
                                    $msg->code = -1;
                                    $msg->msg = "no type";
                                } else {
                                    $r = newPost($title, $content, $from, $type, $_SERVER["REMOTE_ADDR"]);

                                    if ($r) {
                                        $msg->code = 0;
                                        $msg->msg = "insert post success";
                                    } else {
                                        $msg->code = -1;
                                        $msg->msg = "insert post fail";
                                    }
                                }
                            } else {
                                $msg->code = -1;
                                $msg->msg = "no type";
                            }
                        }
                    } else {
                        $msg->code = -1;
                        $msg->msg = "no from";
                    }
                }
            } else {
                $msg->code = -1;
                $msg->msg = "no content";
            }
        }
    } else {
        $msg->code = -1;
        $msg->msg = "no title";
    }

} else {
    $msg->code = -1;
    $msg->msg = "not post method";
}

if ($msg->code == 0) {
    ?>
    <span>new post success</span>
    <?php
} else {
    ?>
    <span>error = <?php echo $msg->msg; ?></span>
    <?php
}
?>

</body>
</html>
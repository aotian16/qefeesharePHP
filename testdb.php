<?php
/**
 * Created by PhpStorm.
 * User: tongjin
 * Date: 2017/8/3
 * Time: 上午9:52
 */

use com\qefee\app\model\DBInfo;

include_once "model/DBInfo.php";

try {
    $dbInfo = DBInfo::getInstance();
    $pdo = new PDO($dbInfo->dsn, $dbInfo->user, $dbInfo->password); //初始化一个PDO对象

    $strSql = <<<str
        SELECT count(*) FROM qefee_share.post
str;
    $result = $pdo->query($strSql);

    $row = $result->fetch();

    print_r($row);
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() );
}



<?php
/**
 * Created by PhpStorm.
 * User: tongjin
 * Date: 2017/8/1
 * Time: 下午3:03
 */

namespace com\qefee\app;

use com\qefee\app\model\JsonData;

include_once "model/JsonData.php";

header('Content-type: application/json');

$jsonData = new JsonData();
$jsonData->code = 1;
$jsonData->msg = "message";
$jsonData->msgDev = "stack overflow";
$jsonData->data = array(1,2,3);

echo json_encode($jsonData);
<?php
/**
 * Created by PhpStorm.
 * User: tongjin
 * Date: 2017/8/3
 * Time: 上午9:47
 */

namespace com\qefee\app\model;


/**
 * 数据库信息
 * @package com\qefee\app\model
 */
class DBInfo
{
    var $ms;        // 数据库类型
    var $host;      // 主机名
    var $name;      // 数据库名
    var $user;      // 用户
    var $password;  // 密码
    var $dsn;       // 数据源

    private static $instance;

    public static function getInstance() {

        if (DBInfo::$instance == null) {
            $dbInfo = new DBInfo();

            $dbInfo->ms = "mysql";
            $dbInfo->host = "118.193.223.117";
            $dbInfo->name = "qefee_share";
            $dbInfo->user = "sa";
            $dbInfo->password = "055Js220sa";
            $dbInfo->dsn = "$dbInfo->ms:host=$dbInfo->host;dbname=$dbInfo->name";

            return $dbInfo;
        }


        return DBInfo::$instance;
    }
}
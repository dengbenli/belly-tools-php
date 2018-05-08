<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 2018/5/8
 * Time: 上午11:46
 */

require_once ('GetClassAllMethod.class.php');
use GetClass\Method\GetClassAllMethod;

$method = new GetClassAllMethod('../mysql/Mysql.class.php', 'DB\Mysql');
$method::getMethod();
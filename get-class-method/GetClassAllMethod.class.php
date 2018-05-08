<?php
/**
 * 获取一个类文件中的所有方法
 * Created by PhpStorm.
 * User: ben
 * Date: 2018/5/8
 * Time: 上午11:33
 */

namespace GetClass\Method;

class GetClassAllMethod {
  private static $fileUrl;
  private static $class;

  public function __construct($fileUrl, $className) {
    self::$fileUrl = $fileUrl;
    if (!file_exists(self::$fileUrl)) die("没有找到{$fileUrl}文件");
    require_once (self::$fileUrl);
    echo "导入 $fileUrl 文件成功\n";
    self::$class = new $className;
  }

  public static function getMethod () {
    echo "开始获取" .self::$fileUrl. "文件中的所有方法\n";
    $method  = get_class_methods(self::$class);
    echo "获取" .self::$fileUrl. "文件中的所有方法结束\n";
    print_r($method);

    return $method;
  }
}
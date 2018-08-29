<?php
/**
 * Created by PhpStorm.
 * User: benly
 * Date: 2018/7/11
 * Time: 下午11:06
 */

namespace Benly\Request;


class BenlyParam {

  private static $noParamMessage = 'not find params';

  /**
   * 获取数值类型
   * @param $key
   * @param $value
   * @return bool|float|int|string
   */
  private static function getDataType ($key, $value) {
    switch (gettype($value)) {
      case 'integer':
        return intval($key);
      case 'boolean':
        return boolval($key);
      case 'double':
        return doubleval($key);
      case 'string':
        return strval($key);
      default:
        return $key;
    }
  }

  /**
   * 空值异常处理
   * @param $msg
   * @throws BenlyParamException
   */
  private static function throwPramNotFind ($msg) {
    if ($msg === TRUE) {
      throw new BenlyParamException(static::$noParamMessage);
    }
    if (!empty($msg)) {
      throw new BenlyParamException($msg);
    }
  }

  /**
   * get 方式获取数值
   * @param $key
   * @param string $value
   * @param string $msg
   * @return bool|float|int|string
   */
  public static function getParam ($key, $value = '', $msg = '') {
    if (isset($_GET[$key])) {
      return static::getDataType($_GET[$key], $value);
    }
    static::throwPramNotFind($msg);
    return $value;
  }

  /**
   * post 方式获取数值
   * @param $key
   * @param string $value
   * @param string $msg
   * @return bool|float|int|string
   */
  public static function postParam ($key, $value = '', $msg = '') {
    if (isset($_POST[$key])) {
      return static::getDataType($_POST[$key], $value);
    }
    static::throwPramNotFind($msg);
    return $value;
  }

}
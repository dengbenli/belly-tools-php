<?php
/**
 * Created by PhpStorm.
 * User: benly
 * Date: 2018/7/12
 * Time: 下午3:13
 */

namespace Benly\Response;

class Response {

  /**
   * 响应 json 格式
   * @param $data
   * @param int $http_status
   */
  public static function JsonResponse ($data, $http_status = 200) {
    http_response_code($http_status);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);exit;
  }

}
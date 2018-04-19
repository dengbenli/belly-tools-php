<?php

namespace Code;

class Code {
  protected $content = 'QWERTYUPASDFGHKLZXCVBNMqwertyupasdfhkzxcvbnm2345678';
  protected $imagesW = 100;
  protected $imagesH = 30;
  protected $codeL = 4;
  protected $setInterfereL = 200;
  protected $fontSize = 10;
  protected $image;
  protected $bgColor;
  protected $imageString;
  protected $imageSetPixel;
  protected $setInterfereLine;

  /*public function __construct($w, $h, $l, $s_l) {
    $this->imagesW = $w;
    $this->imagesH = $h;
    $this->codeH = $l;
    $this->setInterfereL = $s_l;
    session_start();
  }*/
  public function __construct() {
    session_start();
  }

  public function createCode () {
    $this->createIMG();
    $this->createCanvas();
    $this->setInterfere();
    $this->setInterfereLine();
    $this->outPut();
  }

  public function createIMG () {
    // 创建画布
    $this->image = imagecreatetruecolor($this->imagesW, $this->imagesH);
    // 设置画布背景颜色
    $this->bgColor = imagecolorallocate($this->image, 255, 255, 255);
    // 填充颜色
    return imagefill($this->image, 0, 0, $this->bgColor);
  }

  public function createCanvas () {
    $strCode = '';
    for ($i = 0;$i <= $this->codeL;$i ++) {
      // 验证码字体颜色
      $fontColor = imagecolorallocate($this->image, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
      // 设置字体内容
      $fontContent = substr($this->content, mt_rand(0, strlen($this->content)), 1);
      $strCode .= $fontContent;
      // 显示的坐标
      $x = ($i * 100 / 4) + mt_rand(5, 10);
      $y = mt_rand(5, 10);
      // 填充内容到画布中
      $this->imageString = imagestring($this->image, $this->fontSize, $x, $y, $fontContent, $fontColor);
    }

    $_SESSION['strCode'] = $strCode;

    return $this->imageString;
  }

  public function setInterfere () {
    for ($i = 0; $i < $this->setInterfereL; $i++) {
      $pointColor = imagecolorallocate($this->image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
      $this->imageSetPixel = imagesetpixel($this->image, mt_rand(1, 99), mt_rand(1, 29), $pointColor);
    }

    return $this->imageSetPixel;
  }

  public function setInterfereLine () {
    for ($i = 0; $i < 3; $i++) {
      $lineColor = imagecolorallocate($this->image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
      imageline($this->image, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $lineColor);
    }

    return $this->setInterfereLine;
  }

  public function outPut () {
    header('content-type:image/png');
    imagepng($this->image);
    imagedestroy($this->image);

    return ;
  }

}
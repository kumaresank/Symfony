<?php
namespace File\UploadBundle\Modals;

class Dimensions
{
private $left;
private $top;
private $width;
private $height;
public function setLeft($left)
{
$this->left = $left;
}
public function setTop($top)
{
$this->top = $top;
}
public function setWidth($width)
{
$this->width = $width;
}
public function setHeight($height)
{
$this->height = $height;
}
public function getLeft()
{
return $this->left;
}
public function getTop()
{
return $this->top;
}
public function getWidth()
{
return $this->width;
}
public function getHeight()
{
return $this->height;
}
}
 
?>

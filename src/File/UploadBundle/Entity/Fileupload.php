<?php

namespace File\UploadBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;

class Fileupload
{
  protected $file;

    public function setFile(File $file = null)
    {
        $this->file = $file;
    }
    public function getFile()
    {
        return $this->file;
    }
}

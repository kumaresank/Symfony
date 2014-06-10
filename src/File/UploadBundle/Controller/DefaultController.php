<?php

namespace File\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use File\UploadBundle\Entity\Fileupload;
use File\UploadBundle\Modals\Dimensions;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FileUploadBundle:Default:index.html.html');
    }
    public function uploadAction(Request $request)
    {
    	if ($request->getMethod() == 'POST')
         {
         	$ifile = new Fileupload();
   			$ifile->setFile($request->files->get('image'));
            $dim = new Dimensions();
            $dim->setLeft(trim($request->get('x'),"px"));
            $dim->setTop(trim($request->get('y'),"px"));
            $dim->setWidth(trim($request->get('w'),"px"));
            $dim->setHeight(trim($request->get('h'),"px"));
   			$errorList = $this->get('validator')->validate($ifile);
    		$msg = "";
   			if (count($errorList) > 0)
     		{
    		foreach ($errorList as $err) {
    		$msg.= $this->get('translator')->trans($err->getMessage()) . "\n";
    		}

            $response = new Response();
            $response->setContent(json_encode($msg));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
  		    }
  		    else
    	   {
             $targ_w = $targ_h = 150; 
   
   $ext = $ifile->getFile()->guessExtension();
   if ($ext == 'jpg' || $ext == 'jpeg')
   {
      $im = imagecreatefromjpeg($ifile->getFile());
   }
   else if ($ext == 'gif')
   {
      $im = imagecreatefromgif($ifile->getFile());
   }
   else if ($ext == 'png')
   {
      $im = imagecreatefrompng($ifile->getFile());
   }
   list($width, $height) = getimagesize($ifile->getFile());

   $rsize = ImageCreateTrueColor( 300, 300);
   $cropsize = ImageCreateTrueColor( $targ_w, $targ_w);

   imagecopyresampled($rsize,$im,0,0,0,0, 300,300,$width,$height);

   if ($ext == 'jpg' || $ext == 'jpeg')
   {
         header("Content-Type: image/jpeg");
         imagejpeg($rsize,'tmp.jpeg',100);
         $cropsize_r = imagecreatefromjpeg('tmp.jpeg');
         imagecopyresampled($cropsize,$cropsize_r,0,0,$dim->getLeft(),$dim->getTop(), $targ_w,$targ_h,$dim->getWidth(),$dim->getHeight()); 
         imagejpeg($cropsize,"images/img1.jpeg",100);
   }
   else if($ext == 'gif')
   {
         header("Content-Type: image/gif");
         imagegif($rsize,'tmp.gif',100);
         $cropsize_r = imagecreatefromgif('tmp.gif');
         imagecopyresampled($cropsize,$cropsize_r,0,0,$dim->getLeft(),$dim->getTop(), $targ_w,$targ_h,$dim->getWidth(),$dim->getHeight()); 
         imagegif($cropsize,"images/img1.gif",100);
   }
   else if($ext == 'png')
   {
         header("Content-Type: image/png");
         imagepng($rsize,'temp.png');
         $cropsize_r = imagecreatefrompng('tmp.png');
         imagecopyresampled($cropsize,$cropsize_r,0,0,$dim->getLeft(),$dim->getTop(), $targ_w,$targ_h,$dim->getWidth(),$dim->getHeight()); 
         imagepng($cropsize,"images/img1.png");
   } 
    		$response = new Response();
            $response->setContent(json_encode("Uploaded Successfully"));
            $response->headers->set('Content-Type', 'application/json');
            return $response; 
    	   }
        }
         else
         {
         	return $this->render('FileUploadBundle:Default:index.html.html');
         }
    }
}

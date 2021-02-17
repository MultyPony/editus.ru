<?php

$dpi = 300;

$ihbefore = 307;
$iwbefore = 215;

$ihafter = 297;
$iwafter = 210;

$iwkor = 100;

$iwz = 200;
$ihz = 287;

$lrmargin = ($iwafter - $iwz)/2;
$tbmargin = ($ihafter - $ihz)/2;

$imagetopmargin = new Imagick();
$cih = (((($ihbefore - $ihafter)/2)+$lrmargin)*$dpi)/25.4;
$ciw = (($iwbefore)*$dpi)/25.4;
//$imagetopmargin->setResolution(300,300);


$imagetopmargin->newImage($ciw, $cih, new ImagickPixel('blue'));
//$imagetopmargin->setImageFormat('png');
//$imagetopmargin->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);

//$imagetopmargin->setImageResolution(300, 300);

$imagetopafter = new Imagick();
$cih = ((($ihbefore - $ihafter)/2)*$dpi)/25.4;
$ciw = (($iwbefore)*$dpi)/25.4;
$imagetopafter->setResolution(300,300);
$imagetopafter->newImage($ciw, $cih, new ImagickPixel('red'));

$imagebottommargin = new Imagick();
$cih = (((($ihbefore - $ihafter)/2)+$lrmargin)*$dpi)/25.4;
$ciw = (($iwbefore)*$dpi)/25.4;
$cihbm=$cih;
$imagebottommargin->setResolution(300,300);
$imagebottommargin->newImage($ciw, $cih, new ImagickPixel('blue'));

$imagebottomafter = new Imagick();
$cih = ((($ihbefore - $ihafter)/2)*$dpi)/25.4;
$ciw = (($iwbefore)*$dpi)/25.4;
$cihb=$cih;
$imagebottomafter->setResolution(300,300);

$imagebottomafter->newImage($ciw, $cih, new ImagickPixel('red'));

$imageleftmargin = new Imagick();
$cih = ($ihbefore*$dpi)/25.4;
$ciw = (($iwbefore-$iwafter+$lrmargin)*$dpi)/25.4;
$ciwlm = $ciw;
$imageleftmargin->newImage($ciw, $cih, new ImagickPixel('blue'));

$imagerightmargin = new Imagick();
$cih = ($ihbefore*$dpi)/25.4;
$ciw = (($lrmargin)*$dpi)/25.4;
$ciwrm = $ciw;
$imagerightmargin->newImage($ciw, $cih, new ImagickPixel('blue'));


$imageleftafter = new Imagick();
$cih = (($ihbefore)*$dpi)/25.4;
$ciw = (($iwbefore - $iwafter)*$dpi)/25.4;
$ciwl = $ciw;
$imageleftafter->newImage($ciw, $cih, new ImagickPixel('red'));

$ihbefore =  ($ihbefore * $dpi) / 25.4;
$iwbefore =  ($iwbefore * $dpi) / 25.4;
$iwkor =  ($iwkor * $dpi) / 25.4;
//
//$ihafter =  ($ihbefore * $dpi) / 25.4;
//$iwafter =  ($iwbefore * $dpi) / 25.4;

$image = new Imagick();
$image->newImage($iwbefore, $ihbefore, new ImagickPixel('transparent'));;

$image->compositeImage($imagetopmargin, $imagetopmargin->getImageCompose(), 0, 0);
$image->compositeImage($imageleftmargin, $imageleftmargin->getImageCompose(), 0, 0);
$image->compositeImage($imagebottommargin, $imagebottommargin->getImageCompose(), 0, ($ihbefore-$cihbm));
$image->compositeImage($imagerightmargin, $imagerightmargin->getImageCompose(), ($iwbefore-$ciwrm),0);

$image->compositeImage($imagetopafter, $imagetopafter->getImageCompose(), 0, 0);
$image->compositeImage($imageleftafter, $imageleftafter->getImageCompose(), 0, 0);
$image->compositeImage($imagebottomafter, $imagebottomafter->getImageCompose(), 0, ($ihbefore-$cihb));

$image->setImageFormat('png');

$imagelic = new Imagick();
$imagelic->setResolution(300,300);

$imagelic->newImage($iwbefore, $ihbefore, new ImagickPixel('transparent'));;

//$imagerightmargin->setResolution(300,300);
//$imageleftmargin->setResolution(300,300);
//$imagebottommargin->setResolution(300,300);
//$imagetopmargin->setResolution(300,300);
//$imageleftafter->setResolution(300,300);
//$imagetopafter->setResolution(300,300);
//$imagebottomafter->setResolution(300,300);
//$imagelic->setImageFormat('png');

$imagelic->compositeImage($imagerightmargin, $imagerightmargin->getImageCompose(), 0,0);
$imagelic->compositeImage($imageleftmargin, $imageleftmargin->getImageCompose(),($iwbefore-$ciwlm) , 0);
$imagelic->compositeImage($imagebottommargin, $imagebottommargin->getImageCompose(), 0, ($ihbefore-$cihbm));
$imagelic->compositeImage($imagetopmargin, $imagetopmargin->getImageCompose(), 0, 0);


$imagelic->compositeImage($imageleftafter, $imageleftafter->getImageCompose(), ($iwbefore-$ciwl), 0);

$imagelic->compositeImage($imagetopafter, $imagetopafter->getImageCompose(), 0, 0);
$imagelic->compositeImage($imagebottomafter, $imagebottomafter->getImageCompose(), 0, ($ihbefore-$cihb));


//$imagelic->setImageResolution(300, 300);
//$imagelic->resampleImage(300,300,imagick::FILTER_UNDEFINED,1);

//$imagelic->setImageFormat('png');


$imagefinal = new Imagick();
$imagefinal->setResolution(300,300);
$imagefinal->newImage($iwbefore*2+$iwkor, $ihbefore, new ImagickPixel('transparent'));;
$imagefinal->compositeImage($image, $image->getImageCompose(), 0, 0);
$imagefinal->compositeImage($imagelic, $imagelic->getImageCompose(), $iwbefore+$iwkor, 0);
$imagefinal->setImageFormat('png');
$imagefinal->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);

//$imagefinal->setImageResolution(300, 300);

header('Content-type: image/png');
//echo $image;
echo $imagefinal;

?>

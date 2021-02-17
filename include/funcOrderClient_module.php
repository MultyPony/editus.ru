<?php

function listprojects(&$e, &$t, &$u) {
    if (!isset($_GET['a'])) {
        if ($u->is_user()) {
            $db = new Db();
            if (isset($_GET['pj']) && is_numeric($_GET['pj'])) {
                $db->query("UPDATE UsersProjects 
                            SET userId = '" . $_SESSION['userId'] . "' 
                            WHERE projectId = '" . intval($_GET['pj']) . "' 
                              AND userId = '0' ");
                $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_GET['pj']) . "',
                                curState = 'new',
                                userId = '" . $_SESSION['userId'] . "' ");
                $actionloc = '?do=orderstep1&o='.intval($_GET['pj']);
                $e->mail(Main_config::$debugmail, 'Editus', 'Добавлен проект id проекта -  '.$row[0]."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');
                header("Location: //" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $actionloc);
                exit;
            } else if ($_GET['pj'] == 'n') {
                if (!empty ($_POST['cover']) && !empty ($_POST['paperblock']) && !empty($_POST['size']) && !empty($_POST['binding']) && !empty($_POST['volume']) && !empty($_POST['colorblock'])){
                    $data['cover'] = $_POST['cover'];
                    $data['paper'] = intval($_POST['paperblock']);
                    $data['size'] = intval($_POST['size']);
                    $data['binding'] = intval($_POST['binding']);
                    $data['volume'] = intval($_POST['volume']);
                    $data['addserviceprice'] = ceil($_POST['total']-$_POST['totalor']);
                    $data['additionalservice'] = $_POST['additionalservice'];
                    $data['bookstore'] = $_POST['bookstore'];
                    if ($_POST['colorblock']=='black'){
                        $data['colorblock'] = 11;
                    }elseif($_POST['colorblock']=='color'){
                        $data['colorblock'] = 44;
                    }
                    $db->query("INSERT INTO UsersProjects 
                                SET projectCount = '" . intval($_POST['count']) . "',
                                    projectTotal = '" . intval($_POST['total']) . "',
                                    uplFormat = 'xz',
                                    projectData = '" . serialize($data) . "',
                                    userId = '" . $_SESSION['userId'] . "' ");
                    $db->query("SELECT LAST_INSERT_ID() 
                                FROM UsersProjects LIMIT 1");
                    $row = $db->fetch_array();
                    $e->mail(Main_config::$debugmail, 'Editus', 'Добавлен проект id проекта -  '.$row[0]."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');
                    $actionloc = '?do=orderstep1&o='.$row[0];
                    $db->query("INSERT INTO OrderStateChanges 
                                SET orderId = '" . $row[0] . "',
                                    curState = 'new',
                                    userId = '" . $_SESSION['userId'] . "' ");
                    header("Location: //" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $actionloc);
                    exit;
                }
            }
            if (isset($_POST['projdel'])) {
                $db->query("DELETE
                            FROM UsersProjects
                            WHERE projectId = '" . intval($_POST['projdel']) . "' AND
                                  userId = '".$_SESSION['userId']."'");

                $userid = $_SESSION['userId'];
                $orderid = intval($_POST['projdel']);

                $pathdir = './uploads/' . $userid . '/' . $orderid;
                $path = $pathdir . '/' . $orderid . '_block.doc';
                $pathpdf = $pathdir . '/' . $orderid . '_block.pdf';
                $pathpdf_c = $pathdir . '/' . $orderid . '_block_converted.pdf';
                $pathdocx = $pathdir . '/' . $orderid . '_block.docx';

                if (file_exists($pathpdf)){
                    unlink($pathpdf);
                }
                if (file_exists($path)){
                    unlink($path);
                }
                if (file_exists($pathpdf_c)){
                    unlink($pathpdf_c);
                }
                if (file_exists($pathdocx)){
                    unlink($pathdocx);
                }
                if (file_exists($pathdir)){
                    rmdir($pathdir);
                }
                $e->messuser(_LP_PROJECTDELETED, 2);
            }
            $rows = array();

            $db->query("SELECT * 
                        FROM UsersProjects 
                        WHERE userId = '" . $_SESSION['userId'] . "' ORDER BY projectId DESC " . Engine::pagesql());
            while ($row = $db->fetch_array()) {
                $rows[] = $row;
            }
            $db->query("SELECT count(*) 
                        FROM UsersProjects
                        WHERE userId = '" . $_SESSION['userId'] . "'");
            $count = $db->fetch_array();
            $t->addjs('jquery.tablesorter.min');
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('data' => $rows, 'actiondel' => Main_config::$main_file_name . '?do=listprojects&amp;p=' . intval($_GET['p']), 'actionnext' => Main_config::$main_file_name . '?do=orderstep1&amp;o=', 'pages' => Engine::pagetpl($count['0'], Main_config::$main_file_name . '?do=listprojects')));
            $tpl->fetch('listprojects.tpl');
            return $tpl->get_tpl();
        } else {
            if (!empty ($_POST['cover']) && !empty ($_POST['paperblock']) && !empty($_POST['size']) && !empty($_POST['binding']) && !empty($_POST['volume']) && !empty($_POST['colorblock'])){
                $db = new Db();
                $data['cover'] = $_POST['cover'];
                $data['paper'] = intval($_POST['paperblock']);
                $data['size'] = intval($_POST['size']);
                $data['binding'] = intval($_POST['binding']);
                $data['volume'] = intval($_POST['volume']);
                $data['addserviceprice'] = intval($_POST['total'])-intval($_POST['totalor']);
                $data['additionalservice'] = $_POST['additionalservice'];
                $data['bookstore'] = $_POST['bookstore'];
                if ($_POST['colorblock']=='black'){
                    $data['colorblock'] = 11;
                }elseif($_POST['colorblock']=='color'){
                    $data['colorblock'] = 44;
                }
                $db->query("INSERT INTO UsersProjects 
                            SET projectCount = '" . intval($_POST['count']) . "',
                                projectTotal = '" . ceil($_POST['total']) . "',
                                projectData = '" . serialize($data) . "' ");
                $db->query("SELECT LAST_INSERT_ID() 
                            FROM UsersProjects LIMIT 1");
                $row = $db->fetch_array();
                $_GET['pj'] = $row[0];
            }
        }
    }else{
        if ($_POST['do'] == 'calc') {
            $db = new Db();

            $orderid = intval($_POST['orderid']);
            $count = intval($_POST['count']);
            $db->query("SELECT projectData, projectTotal
                        FROM UsersProjects 
                        WHERE projectId = '" . $orderid . "' AND
                              userId = '". $_SESSION['userId']."' ");
            $row = $db->fetch_array();
            $gdata = unserialize($row['projectData']);
            $gdata['projectTotal']=$row['projectTotal'];

            if (count($gdata['additionalservice'])>0){
                 $addserviceprice = $gdata['addserviceprice'];
            }else{
                 $addserviceprice = 0;
            }

            $db->query("SELECT PrintCost 
                        FROM PrintTypeCostsCover 
                        WHERE PrintType = '44' ");
            $row = $db->fetch_array();
            $pr_printtypecover = $row[0];

            $db->query("SELECT PaperTypeCost 
                                FROM PaperTypeCostsCover 
                                WHERE CoverType = '" . $gdata['cover'] . "' AND
                                      isDefault = '1'");
            $row = $db->fetch_array();
            $pr_papertypecover = $row[0];

            $db->query("SELECT formatInA3 
                        FROM PaperFormat 
                        WHERE formatId = '".intval($gdata['size'])."' ");
            $row = $db->fetch_array();
            $pr_pagesona3 = $row[0];
            $db->query("SELECT SUM(AdditionalCoverCost) 
                        FROM AdditionalCoverCosts 
                        WHERE isDefault = '1' ");
            $row = $db->fetch_array();
            $pr_additionalcover = $row[0];

            $db->query("SELECT PrintCost 
                        FROM PrintTypeCostsBlock 
                        WHERE PrintType = '".intval($gdata['colorblock'])."' ");
            $row = $db->fetch_array();
            $pr_printtypeblock = $row[0];
            $db->query("SELECT PaperTypeCost 
                        FROM PaperTypeCostsBlock 
                        WHERE PaperTypeId = '".intval($gdata['paper'])."' ");
            $row = $db->fetch_array();
            $pr_papertypeblock = $row[0];

            $db->query("SELECT OrderRate 
                        FROM OrdersRates 
                        WHERE OrderRateMin <= '".$count."' AND 
                              OrderRateMax >= '".$count."' ");
            $row = $db->fetch_array();
            $koef = $row[0];

            $db->query("SELECT BindingCosts 
                        FROM BindingTypeCosts 
                        WHERE BindingMin <= '".$gdata['volume']."' AND 
                              BindingMax >= '".$gdata['volume']."' AND 
                              BindingId = '".intval($gdata['binding'])."' AND 
                              formatId = '".intval($gdata['size'])."' ");
            $row = $db->fetch_array();
            $pr_bind = $row[0];

            $allblock = ceil((($pr_printtypeblock + $pr_papertypeblock) * $gdata['volume'] / $pr_pagesona3) * $count * $koef);
            $allcover = ceil((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $count * $koef);
            $allbind = ceil($pr_bind * $count * $koef);
            $total = $allblock+$allcover+$allbind+$addserviceprice;
            echo ceil($total).' '._LP_RUB;

            $db->query("UPDATE UsersProjects 
                        SET projectCount = '" . $count . "',
                            projectTotal = '". $total ."'
                        WHERE projectId = '" . $orderid . "' AND
                            userId = '".$_SESSION['userId']."' ");
        }
    }
}

function orderstep1(&$e, &$t) {
    if (!isset($_GET['a'])) {
        $db = new Db();
        $db->query("SELECT orderstep
                    FROM UsersOrders 
                    WHERE orderId = '" . intval($_GET['o']) . "' AND
                          userId = '" . $_SESSION['userId'] . "' LIMIT 1");
        if ($db->num_rows()==1){
            $step = 0;
            $maxstep = 4;
            $row = $db->fetch_array();
            if (($row['orderstep'])!=$step){
                if (($row['orderstep']+1)<=$maxstep) {
                    header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=orderstep".($row['orderstep']+1)."&o=".intval($_GET['o']));
                    exit();
                }else{
                    header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=listorders");
                    exit();
                }
            }
        }
        if (is_numeric($_GET['o'])) {
            $db->query("SELECT projectData, projectCount
                        FROM UsersProjects 
                        WHERE projectId = '" . intval($_GET['o']) . "' AND
                              userId = '" . $_SESSION['userId'] . "' ");
            $row = $db->fetch_array();
            $data = unserialize($row['projectData']);
            $data['projectCount'] = $row['projectCount'];
            $db->query("SELECT tbbHref, tbcsHref, tbchHref
                        FROM TemplatesBook 
                        WHERE pageFormat='" . $data['size'] . "'");
            $href = $db->fetch_array();
            if ($data['cover'] == 'soft') {
                $hrefcover = $href['tbcsHref'];
            } elseif ($data['cover'] == 'hard') {
                $hrefcover = $href['tbchHref'];
            }
            $db->query("SELECT userLastName, userFirstName 
                        FROM Users 
                        WHERE userId= '" . $_SESSION['userId'] . "'");
            $author = $db->fetch_array();

            $db->query("SELECT formatName 
                        FROM PaperFormat 
                        WHERE formatId= '" . $data['size'] . "'");
            $sizep = $db->fetch_array();

            $db->query("SELECT AdditionalServiceId, AdditionalServiceName, label, helphref
                        FROM AdditionalServiceCosts 
                        WHERE AdditionalServiceEnable = '1' ");
            $ftemplate = array();
            while ($row = $db->fetch_array()) {
                if ($data['additionalservice'] != NULL) {
                    if (in_array($row['AdditionalServiceId'], $data['additionalservice'])) {
                        $row['sel'] = 1;
                        $addedads.=', ' . strtoupper($row['AdditionalServiceName']);
                        if ($row['label'] == 'makeup') {
                            $ftemplate['makeup'] = 1;
                        }
                        if ($row['label'] == 'edit') {
                            $ftemplate['edit'] = 1;
                        }
                    }
                } else {
                    $row['sel'] = 0;
                }
                $addservice[] = $row;
            }
            $t->addjs('jquery.simplemodal.1.4.1.min');
            $e->do ='listprojects';
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('sizep'=>$sizep[0],'ftemplate' => $ftemplate, 'addedads' => $addedads, 'hrefblock' => $href['tbbHref'], 'hrefcover' => $hrefcover, 'author' => $author[0] . ' ' . $author[1], 'action' => Main_config::$main_file_name . '?do=orderstep2&amp;o=' . intval($_GET['o']), 'orderid' => intval($_GET['o']), 'addservice' => $addservice, 'userid' => $_SESSION['userId'], 'data' => $data));
            $tpl->fetch('orderstep1.tpl');
            return $tpl->get_tpl();
        }
    } else {
        if ($_POST['do'] == 'updateadditionalservice') {
            $db = new Db();
            $db->query("SELECT projectData
                        FROM UsersProjects 
                        WHERE projectId = '" . intval($_POST['o']) . "' AND
                              userId = '" . intval($_POST['userId']) . "' ");
            $row = $db->fetch_array();
            $data = unserialize($row['projectData']);
            $data['additionalservice'] = explode(':', substr($_POST['additional'], 0, -1));
            $db->query("UPDATE UsersProjects 
                        SET projectData = '" . serialize($data) . "' 
                        WHERE projectId = '" . intval($_POST['o']) . "' AND
                              userId = '" . intval($_POST['userId']) . "' ");
            $sql = str_replace(':', "' OR AdditionalServiceId = '", substr($_POST['additional'], 0, -1));
            $fdata['makeup'] = 0;
            $fdata['edit'] = 0;
            $db->query("SELECT label 
                         FROM AdditionalServiceCosts 
                         WHERE AdditionalServiceId = '" . $sql . "' ");
            while ($row = $db->fetch_array()) {
//                if ($row['label'] == 'makeup') {
//                    $fdata['makeup'] = 1;
//                }
                if ($row['label'] == 'edit') {
                    $fdata['edit'] = 1;
                }
            }
            echo json_encode($fdata);
        }
        if ($_POST['do'] == 'newbind') {
            $db = new Db();
            $db->query("SELECT projectData
                        FROM UsersProjects 
                        WHERE projectId = '" . intval($_POST['o']) . "' AND
                              userId = '" . intval($_POST['userId']) . "' ");
            $row = $db->fetch_array();
            $data = unserialize($row['projectData']);
            $db->query("SELECT BindingId, BindingName 
                        FROM BindingType 
                        WHERE CoverType = '" . $db->mres($data['cover']) . "' AND 
                              BindingMin <= '" . intval($_POST['PageCount']) . "' AND 
                              BindingMax >= '" . intval($_POST['PageCount']) . "' ");
            if ($db->num_rows() >= 1) {
                while ($row = $db->fetch_array()) {
                    $html .= '<label><input type="radio" name="binding" value="' . $row['BindingId'] . '" />' . $row['BindingName'] . '</label>';
                }
            } else {
                $html = _OS1_NOTAVAILBIND;
            }
            echo $html;
        }
    }
}
function createcovertemplate($path,$size,$pages, $papertypeid, $covertype){
    $db = new Db();
    $db->query("SELECT beforeWidth, beforeHeght, importantAreaWidth, importantAreaHeight
                FROM BindingCoverParam 
                WHERE formatId = '" . $size['formatId'] . "' ");
    $row = $db->fetch_array();
    $dpi = 300;
    $path_to_front = './img/tpl_covers/id'.$size['formatId'].'_'.$covertype.'_front.png';
    $path_to_back = './img/tpl_covers/id'.$size['formatId'].'_'.$covertype.'_back.png';
    $ihbefore = $row['beforeHeght'];
    $iwbefore = $row['beforeWidth'];
    $ihafter = $size['formatHeight'];
    $iwafter = $size['formatWidth'];
    $db->query("SELECT PaperTypeWeight
                FROM PaperTypeCostsBlock 
                WHERE PaperTypeId = '" . $papertypeid . "' ");
    $row2 = $db->fetch_array();
    $paperDensity = $row2['PaperTypeWeight'];
    $pagesinblock = $pages;
//    $iwkor = ((($pagesinblock/2)/100*$paperDensity/80)*10);
    if ($covertype == 'soft'){
	$iwkor = ($pagesinblock/20) + 1;
    } else {
	$iwkor = ($pagesinblock/20) + 4;
    }
//    $iwkor = ($pagesinblock*$paperDensity/1600 + 16)*1.1;
    $iwkor =  (($iwkor * $dpi) / 25.4);
    $iwz = $row['importantAreaWidth'];
    $ihz = $row['importantAreaHeight'];
    $lrmargin = ($iwafter - $iwz)/2;
    $tbmargin = ($ihafter - $ihz)/2;
    $imagetopmargin = new Imagick();
    $cih = ((((($ihbefore - $ihafter)/2)+$lrmargin)*$dpi)/25.4);
    $ciw = (($iwbefore)*$dpi)/25.4;
    $imagetopmargin->newImage($ciw, $cih, new ImagickPixel('blue'));
    $imagetopafter = new Imagick();
    $cih = ((($ihbefore - $ihafter)/2)*$dpi)/25.4;
    $ciw = (($iwbefore)*$dpi)/25.4;

    $imagetopafter->newImage($ciw, $cih, new ImagickPixel('red'));
    $imagebottommargin = new Imagick();
    $cih = (((($ihbefore - $ihafter)/2)+$lrmargin)*$dpi)/25.4;
    $ciw = (($iwbefore)*$dpi)/25.4;
    $cihbm=$cih;

    $imagebottommargin->newImage($ciw, $cih, new ImagickPixel('blue'));
    $imagebottomafter = new Imagick();
    $cih = ((($ihbefore - $ihafter)/2)*$dpi)/25.4;
    $ciw = (($iwbefore)*$dpi)/25.4;
    $cihb=$cih;
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
    $image = new Imagick();
    $imagerightmargin->newImage(abs($ciw), abs($cih), new ImagickPixel('blue'));
    $imageleftafter = new Imagick();
    $cih = (($ihbefore)*$dpi)/25.4;
    $ciw = (($iwbefore - $iwafter)*$dpi)/25.4;
    $ciwl = $ciw;
    $imageleftafter->newImage(abs($ciw), abs($cih), new ImagickPixel('red'));
    $ihbefore =  ($ihbefore * $dpi) / 25.4;
    $iwbefore =  ($iwbefore * $dpi) / 25.4;
    //$iwkor =  ($iwkor * $dpi) / 25.4;

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
    $imagelic->newImage($iwbefore, $ihbefore, new ImagickPixel('transparent'));;
    $imagelic->compositeImage($imagerightmargin, $imagerightmargin->getImageCompose(), 0,0);
    $imagelic->compositeImage($imageleftmargin, $imageleftmargin->getImageCompose(),($iwbefore-$ciwlm) , 0);
    $imagelic->compositeImage($imagebottommargin, $imagebottommargin->getImageCompose(), 0, ($ihbefore-$cihbm));
    $imagelic->compositeImage($imagetopmargin, $imagetopmargin->getImageCompose(), 0, 0);
    $imagelic->compositeImage($imageleftafter, $imageleftafter->getImageCompose(), ($iwbefore-$ciwl), 0);
    $imagelic->compositeImage($imagetopafter, $imagetopafter->getImageCompose(), 0, 0);
    $imagelic->compositeImage($imagebottomafter, $imagebottomafter->getImageCompose(), 0, ($ihbefore-$cihb));
    $imagelic->setImageFormat('png');
    $handlefront = fopen($path_to_front, 'rb');
    $imgfront = new Imagick();
    //$imgfront=imagecreatefrompng($path_to_front);
    $imgfront->readImageFile($handlefront);
    $handleback = fopen($path_to_back, 'rb');
    $imgback = new Imagick();
    //$imgfront=imagecreatefrompng($path_to_front);
    $imgback->readImageFile($handleback);
    $fw = $imgfront->getImageWidth();
    $bw = $imgback->getImageWidth();
    $bh = $imgback->getImageHeight();
    $iwkorimg = new Imagick();
    $iwkorimg->newImage($iwkor, $bh, new ImagickPixel('transparent'));;
    $imagefinal = new Imagick();
    $imagefinal->setResolution($dpi,$dpi);
    //$imagefinal->newImage($iwbefore*2+$iwkor, $ihbefore, new ImagickPixel('transparent'));
    $imagefinal->newImage($bw+$fw+$iwkor, $bh, new ImagickPixel('transparent'));
    //$imagefinal->compositeImage($image, $image->getImageCompose(), 0, 0);
    $imagefinal->compositeImage($imgback, $imgback->getImageCompose(), 0, 0);
    //$imagefinal->compositeImage($iwkorimg, $iwkorimg->getImageCompose(), $iwbefore, 0);
    $imagefinal->compositeImage($iwkorimg, $iwkorimg->getImageCompose(), $bw, 0);
    //$imagefinal->compositeImage($imagelic, $imagelic->getImageCompose(), $iwbefore+$iwkor, 0);
    //$imagefinal->compositeImage($imgfront, $imgfront->getImageCompose(), $iwbefore+$iwkor, 0);
    $imagefinal->compositeImage($imgfront, $imgfront->getImageCompose(), $bw+$iwkor, 0);
    $imagefinal->setImageFormat('png');
//    $imagefinal->setImageDepth(8);
    $imagefinal->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
    //header('Content-type: image/png');
    ////echo $image;
    //echo $imagefinal;
    if (file_exists($path)){
        unlink($path);
    }
    $imagefinal->writeImage($path);
}
function orderstep2(&$e) {
    $db = new Db();
    if (is_numeric($_GET['o'])) {
        if (isset($_POST['os1_newo'])) {
            $db->query("SELECT projectData, projectCount, uplFormat
                        FROM UsersProjects 
                        WHERE projectId = '" . intval($_GET['o']) . "' AND
                              userId = '" . $_SESSION['userId'] . "' ");
            $row = $db->fetch_array();
            $gdata = unserialize($row['projectData']);
            $gdata['projectCount'] = $row['projectCount'];
            $gdata['uplFormat']=$row['uplFormat'];

            $userid = $_SESSION['userId'];
            $orderid = intval($_GET['o']);

            $pathdir = './uploads/' . $userid . '/' . $orderid;
            $path = $pathdir . '/' . $orderid . '_block.doc';
            $pathpdf = $pathdir . '/' . $orderid . '_block.pdf';
            $pathpdf_c = $pathdir . '/' . $orderid . '_block_converted.pdf';
            $pathdocx = $pathdir . '/' . $orderid . '_block.docx';

            $format = $gdata['uplFormat'];

            $db->query("SELECT BindingMultiplicity 
                        FROM BindingType 
                        WHERE BindingId = '".$gdata['binding']."' ");
            $bm = $db->fetch_array();
            $db->query("SELECT formatInA3, formatName
                        FROM PaperFormat 
                        WHERE formatId = '" . $gdata['size'] . "' ");
            $row = $db->fetch_array();
            $pr_pagesona3 = $row['formatInA3'];
            $pageformatname = $row['formatName'];
            $f = 0;
            $try = 5;
            $good = 5;
            $data = array();
            $res=array();
            if ($format == 'doc'){
                do {
                    $f++;
                    exec("/usr/bin/python3 ./include/uploadblockconv.py -f ".$pageformatname." -k ".$bm['BindingMultiplicity']." -p ".$gdata['volume']." -n --pdf " . $path, $res);
                    foreach ($res as $cur) {
                        $t = explode(': ', $cur);
                        $data[$t[0]] = $t[1];
                    }
                } while (count($res) != $good && $f < $try);
            }
            if ($format == 'pdf'){
                do {
                    $f++;
                    exec("/usr/bin/python3 ./include/uploadblockconv.py -f ".$pageformatname." -k ".$bm['BindingMultiplicity']." -p ".$gdata['volume']." -n --ispdf " . $pathpdf, $res);
                    foreach ($res as $cur) {
                        $t = explode(': ', $cur);
                        $data[$t[0]] = $t[1];
                    }
                } while (count($res) != $good && $f < $try);
            }
            if ($format == 'docx'){
                do {
                    $f++;
                    exec("/usr/bin/python3 ./include/uploadblockconv.py -f ".$pageformatname." -k ".$bm['BindingMultiplicity']." -p ".$gdata['volume']." -n --pdf " . $pathdocx, $res);
                    foreach ($res as $cur) {
                        $t = explode(': ', $cur);
                        $data[$t[0]] = $t[1];
                    }
                } while (count($res) != $good && $f < $try);
            }
            if (count($res) == $good) {

                $db->query("SELECT PrintCost 
                            FROM PrintTypeCostsBlock 
                            WHERE PrintType = '" . $gdata['colorblock'] . "' ");
                $row = $db->fetch_array();
                $pr_printtypeblock = $row[0];

                $db->query("SELECT PaperTypeCost 
                            FROM PaperTypeCostsBlock 
                            WHERE PaperTypeId = '" . $gdata['paper'] . "' ");
                $row = $db->fetch_array();
                $pr_papertypeblock = $row[0];

                $db->query("SELECT OrderRate 
                            FROM OrdersRates 
                            WHERE OrderRateMin <= '" . $gdata['projectCount'] . "' AND 
                                  OrderRateMax >= '" . $gdata['projectCount'] . "' ");
                $row = $db->fetch_array();
                $koef = $row[0];
                $data['totalblock'] = 0;
                $data['totalblock'] = ((($pr_printtypeblock + $pr_papertypeblock) * $data['PageCount'] / $pr_pagesona3) * $gdata['projectCount'] * $koef);
//                if ($gdata['additionalservice'] != NULL) {
//                    $sql = implode("' OR AdditionalServiceId = '", $gdata['additionalservice']);
//                    $db->query("SELECT AdditionalServiceCost, MetricType, MetricVal
//                                FROM AdditionalServiceCosts
//                                WHERE AdditionalServiceId = '" . $sql . "' ");
//                    $pr = 0;
//                    while ($row = $db->fetch_array()) {
//                        if ($row['MetricType'] == 'char') {
//                            $pr += ( (floor($data['CharacterCount'] / $row['MetricVal']) + 1) * $row['AdditionalServiceCost']);
//                        } else if ($row['MetricType'] == 'pub') {
//                            $pr +=$row['AdditionalServiceCost'];
//                        } else if ($row['MetricType'] == 'list') {
//                            $pr += ( $data['PageCount'] * $row['AdditionalServiceCost']);
//                        }
//                    }
//                    $data['totaladds'] = $pr;
//                } else {
//                    $data['totaladds'] = 0;
//                }

                if ($gdata['additionalservice']!= NULL){
                    $oad = implode(',', $gdata['additionalservice']);
                }else{
                    $oad = '';
                }
//                $db->query("INSERT INTO UsersOrders
//                            SET orderId = '" . $orderid . "',
//                                orderName = '" . $db->mres($_POST['os1_name']) . "',
//                                orderAutor = '" . $db->mres($_POST['os1_author']) . "',
//                                orderCount = '" . $gdata['projectCount'] . "',
//                                orderPages = '" . $data['PageCount'] . "',
//                                orderSymb = '" . $data['CharacterCount'] . "',
//                                orderCover = '" . $gdata['cover'] . "',
//                                orderSize = '" . $gdata['size'] . "',
//                                orderPaperBlock = '" . $gdata['paper'] . "',
//                                orderBinding = '" . $gdata['binding'] . "',
//                                orderColorBlock = '" . $gdata['colorblock'] . "',
//                                orderAdditService = '" . $oad . "',
//                                orderPriceBlock = '" . $data['totalblock'] . "',
//                                orderPriceAdditService = '" . $data['totaladds'] . "',
//                                userId = '" . $_SESSION['userId'] . "',
//                                orderstep = '1'");
                $db->query("INSERT INTO UsersOrders
                            SET orderId = '" . $orderid . "',
                                orderName = '" . $db->mres($_POST['os1_name']) . "',
                                orderAutor = '" . $db->mres($_POST['os1_author']) . "',
                                orderCount = '" . $gdata['projectCount'] . "',
                                orderPages = '" . $data['PageCount'] . "',
                                orderSymb = '" . $data['CharacterCount'] . "',
                                orderCover = '" . $gdata['cover'] . "', 
                                orderSize = '" . $gdata['size'] . "',
                                orderPaperBlock = '" . $gdata['paper'] . "',
                                orderBinding = '" . $gdata['binding'] . "',
                                orderColorBlock = '" . $gdata['colorblock'] . "',
                                orderAdditService = '" . $oad . "',
                                orderPriceBlock = '" . $data['totalblock'] . "',
                                formatUplBlock = '". $format ."',
                                userId = '" . $_SESSION['userId'] . "',
                                bookstore = '".$gdata['bookstore']."',
                                orderstep = '1'");
                $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . $orderid . "',
                                curState = 'cover',
                                userId = '" . $_SESSION['userId'] . "' ");
                $db->query("DELETE
                            FROM UsersProjects
                            WHERE projectId = '" . intval($_GET['o']) . "' AND
                                  userId = '" . $_SESSION['userId'] . "'");
                $e->messuser(_OS2_1STEPCOMPLETE, 1);
                $e->mail(Main_config::$debugmail, 'Editus', 'Проект перешел в заказ id  -  '.intval($_GET['o'])."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');
            }
        }else{
            $db->query("SELECT orderstep
                FROM UsersOrders 
                WHERE orderId = '" . intval($_GET['o']) . "' AND
                      userId = '" . $_SESSION['userId'] . "' LIMIT 1");
            if ($db->num_rows()==1){
                $step = 1;
                $maxstep = 4;
                $row = $db->fetch_array();
                if (($row['orderstep'])!=$step){
                    if (($row['orderstep']+1)<=$maxstep) {
                        header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=orderstep".(intval($row['orderstep'])+1)."&o=".intval($_GET['o']));
                        exit();
                    }else{
                        header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=listorders");
                        exit();
                    }
                }
            }
        }
        $db->query("SELECT orderCount, orderPages, orderCover, orderSize, orderPaperBlock, orderBinding, orderColorBlock, orderAdditService
                        FROM UsersOrders 
                        WHERE orderId = '" . intval($_GET['o']) . "' AND
                              userId = '" . $_SESSION['userId'] . "' LIMIT 1");
        $dataorder = $db->fetch_array();

//        $db->query("SELECT PrintCost
//                    FROM PrintTypeCostsCover
//                    WHERE PrintType = '44'");
//        $row = $db->fetch_array();
//        $pr_printtypecover = $row[0];
//
//        $db->query("SELECT PaperTypeCost
//                    FROM PaperTypeCostsCover
//                    WHERE CoverType = '" . $dataorder['orderCover'] . "' AND
//                          isDefault = '1'");
//        $row = $db->fetch_array();
//        $pr_papertypecover = $row[0];
//
        $db->query("SELECT formatInA3, formatWidth, formatHeight
                    FROM PaperFormat 
                    WHERE formatId = '" . $dataorder['orderSize'] . "' ");
        $row = $db->fetch_array();
        $pr_pagesona3 = $row[0];
        $sizeW=$row['formatWidth'];
        $sizeH=$row['formatHeight'];
//
//        $db->query("SELECT SUM(AdditionalCoverCost) FROM AdditionalCoverCosts WHERE isDefault = '1' ");
//        $row = $db->fetch_array();
//        $pr_additionalcover = $row[0];
//
//        $db->query("SELECT OrderRate
//                    FROM OrdersRates
//                    WHERE OrderRateMin <= '" . $dataorder['orderCount'] . "' AND
//                          OrderRateMax >= '" . $dataorder['orderCount'] . "' ");
//        $row = $db->fetch_array();
//        $koef = $row[0];
//
//        $totalcover = ((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $dataorder['orderCount'] * $koef);
//
//        $db->query("SELECT BindingCosts
//                    FROM BindingTypeCosts
//                    WHERE BindingMin <= '".$dataorder['orderPages']."' AND
//                          BindingMax >= '".$dataorder['orderPages']."' AND
//                          BindingId = '".$dataorder['orderBinding']."' AND
//                          formatId = '".$dataorder['orderSize']."' ");
//        $row = $db->fetch_array();
//        $pr_bind = $row[0];
//        $totalbind = ($pr_bind * $dataorder['orderCount'] * $koef);

        $t = explode(',', $dataorder['orderAdditService']);
        $db->query("SELECT AdditionalServiceId, label
                    FROM AdditionalServiceCosts 
                    WHERE AdditionalServiceEnable = '1' ");
        $ftemplate=array();
        while ($row = $db->fetch_array()) {
            if (count($t)>0) {
                if (in_array($row['AdditionalServiceId'], $t)) {
                    if ($row['label'] == 'covdesign') {
                        $ftemplate['covdesign'] = 1;
                    }
                }
            }
        }
        if ($ftemplate['covdesign'] != 1){
            $path = './uploads/' . $_SESSION['userId'] . '/' . intval($_GET['o']).'/'.intval($_GET['o']).'_template_cover.png';
            createcovertemplate($path, array('formatId'=>$dataorder['orderSize'],'formatWidth'=>$sizeW,'formatHeight'=>$sizeH),$dataorder['orderPages'],$dataorder['orderPaperBlock'], $dataorder['orderCover']);
        }
        $hrefcovertemplate = '/include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.intval($_GET['o']).'&amp;o=covertemplate';
        $hrefcover = '/include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.intval($_GET['o']).'&amp;o=cover';
        $hrefcoverpdf = '/include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.intval($_GET['o']).'&amp;o=coverlayot';
        $e->do ='listorders';
        $tpl = new Template();
        $tpl->set_path('templates/');
        $tpl->set_vars(array('hrefcover'=>$hrefcover,'hrefcoverpdf'=>$hrefcoverpdf,'ftemplate'=>$ftemplate,'hrefcovertemplate'=>$hrefcovertemplate,'totalbind'=>$totalbind, 'totalcover'=>$totalcover,'orderid' => intval($_GET['o']), 'userid' => $_SESSION['userId'], 'action' => Main_config::$main_file_name . '?do=orderstep3&amp;o=' . intval($_GET['o'])));
        $tpl->fetch('orderstep2.tpl');
        return $tpl->get_tpl();
    }
}

function orderstep3(&$e, &$t, &$u) {
    if (!isset($_GET['a'])) {
        if (is_numeric($_GET['o'])) {
            if (isset($_POST['os2_newo'])){
                $db = new Db();
                $db->query("SELECT orderPriceBlock, orderCount, orderPages, orderSymb, orderCover, orderSize, orderPaperBlock, orderBinding, orderColorBlock, orderAdditService, formatUplImg
                            FROM UsersOrders 
                            WHERE orderId = '" . intval($_GET['o']) . "' AND
                                  userId = '" . $_SESSION['userId'] . "' LIMIT 1");
                $dataorder = $db->fetch_array();
                if (!empty($dataorder['orderAdditService'])){
                    $addservice = explode(',',$dataorder['orderAdditService']);
                }else{
                    $addservice = array();
                }

                if (isset($_POST['os2_adddesign'])){
                    $pathdir = './uploads/'.$_SESSION['userId'].'/'.intval($_GET['o']);
                    $pathdesignDB = $pathdir.'/'.intval($_GET['o']).'_design.'.$dataorder['formatUplImg'];
                    $pathcoverDB = $pathdir.'/'.intval($_GET['o']).'_cover.'.$dataorder['formatUplImg'];
                    if (file_exists($pathcoverDB)){
                        rename($pathcoverDB, $pathdesignDB);
                    }
                    $db->query("SELECT AdditionalServiceId
                                FROM AdditionalServiceCosts
                                WHERE label = 'covdesign' LIMIT 1");
                    $row = $db->fetch_array();
                    $addservice[]=$row['AdditionalServiceId'];
                }
                $db->query("SELECT AdditionalServiceId
                            FROM AdditionalServiceCosts
                            WHERE label = 'addtoisdpack' LIMIT 1");
                $addtoisdpack = $db->fetch_array();
                $addtoisdpack = $addtoisdpack['AdditionalServiceId'];
                if (in_array($addtoisdpack, $addservice)){
                   $orderid = intval($_GET['o']);
                   $db->query("SELECT isbn
                               FROM ISBNnumbers
                               WHERE (orderId = '0' OR orderId = '".$orderid."') AND 
                                     isPaid = '0' 
                               LIMIT 1 ");
                   $isbnqu = $db->fetch_array();
                   $isbnnumber = $isbnqu['isbn'];
                   $db->query("UPDATE ISBNnumbers 
                               SET orderId = '".$orderid."',
                                   orderDate = '".date("Y-m-d H:i:s")."'
                               WHERE isbn = '".$isbnnumber."'");
//                           echo "/usr/bin/perl ./createcoverpdf.pl ".$pathcover." ".$orderid." ".$isbnnumber;
                   exec("/usr/bin/perl ./createcoverpdf.pl ".$pathcoverDB." ".$isbnnumber, $res);

               }else{
                   exec("/usr/bin/perl ./createcoverpdf.pl ".$pathcoverDB, $res);
               }
                $db->query("SELECT PrintCost 
                            FROM PrintTypeCostsCover 
                            WHERE PrintType = '44'");
                $row = $db->fetch_array();
                $pr_printtypecover = $row[0];

                $db->query("SELECT PaperTypeCost 
                            FROM PaperTypeCostsCover 
                            WHERE CoverType = '" . $dataorder['orderCover'] . "' AND
                                  isDefault = '1'");
                $row = $db->fetch_array();
                $pr_papertypecover = $row[0];

                $db->query("SELECT formatInA3 
                            FROM PaperFormat 
                            WHERE formatId = '" . $dataorder['orderSize'] . "' ");
                $row = $db->fetch_array();
                $pr_pagesona3 = $row[0];

                $db->query("SELECT SUM(AdditionalCoverCost) 
                            FROM AdditionalCoverCosts 
                            WHERE isDefault = '1' ");
                $row = $db->fetch_array();
                $pr_additionalcover = $row[0];

                $db->query("SELECT OrderRate 
                            FROM OrdersRates 
                            WHERE OrderRateMin <= '" . $dataorder['orderCount'] . "' AND 
                                  OrderRateMax >= '" . $dataorder['orderCount'] . "' ");
                $row = $db->fetch_array();
                $koef = $row[0];

                $totalcover = ceil((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $dataorder['orderCount'] * $koef);

                $db->query("SELECT BindingCosts 
                            FROM BindingTypeCosts 
                            WHERE BindingMin <= '".$dataorder['orderPages']."' AND 
                                  BindingMax >= '".$dataorder['orderPages']."' AND 
                                  BindingId = '".$dataorder['orderBinding']."' AND 
                                  formatId = '".$dataorder['orderSize']."' ");
                $row = $db->fetch_array();
                $pr_bind = $row[0];
                $totalbind = ceil($pr_bind * $dataorder['orderCount'] * $koef);

                $total16=(((ceil($dataorder['orderPriceBlock'])+$totalbind+$totalcover)/$dataorder['orderCount'])*16);

                $sqlupdateaddservice ='';
                if (count($addservice)>0) {
                    $sqlupdateaddservice = implode(',', $addservice);
                    if (count($addservice)>1) {
                        $sql = implode("' OR AdditionalServiceId = '", $addservice);
                    }
                    if (count($addservice)==1){
                        $sql = $addservice[0];
                    }
                    $db->query("SELECT AdditionalServiceCost, MetricType, MetricVal, label
                                FROM AdditionalServiceCosts 
                                WHERE AdditionalServiceId = '" . $sql . "' ");

                    $pr = 0;
                    while ($row = $db->fetch_array()) {
                        if ($row['MetricType'] == 'char') {
                            $pr += ( (floor($dataorder['orderSymb'] / $row['MetricVal']) + 1) * $row['AdditionalServiceCost']);
                        } else if ($row['MetricType'] == 'pub') {
                                if ($row['label']=='addtoisdpack'){
                                    $pr += $row['AdditionalServiceCost'];
//                                    $neworderco = $dataorder['orderCount']+16;
                                    $dataorder['orderCount'] = $dataorder['orderCount'];
                                }else{
                                    $pr +=$row['AdditionalServiceCost'];
                                }
                        } else if ($row['MetricType'] == 'list') {
                            $pr += ( $dataorder['orderPages'] * $row['AdditionalServiceCost']);
                        }
                    }
                    $pr_addservice = $pr;
                } else {
                    $pr_addservice = 0;
                }

                $db->query("UPDATE UsersOrders
                            SET orderPriceCover = '".$totalcover."',
                                orderPriceBind = '".$totalbind."',
                                orderPriceAdditService = '".$pr_addservice."',
                                orderstep = '2',
                                orderAdditService = '".$sqlupdateaddservice."',
                                orderCount = '".$dataorder['orderCount']."'
                            WHERE orderId = '".intval($_GET['o'])."' AND
                                  userId = '" . $_SESSION['userId'] . "'");
                $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_GET['o']) . "',
                                curState = 'deliv',
                                userId = '" . $_SESSION['userId'] . "' ");
                $e->messuser(_OS3_2STEPCOMPLETE, 1);
            }else{
                $db = new Db();
                $db->query("SELECT orderstep
                            FROM UsersOrders 
                            WHERE orderId = '" . intval($_GET['o']) . "' AND
                                  userId = '" . $_SESSION['userId'] . "' LIMIT 1");
                if ($db->num_rows()==1){
                    $step = 2;
                    $maxstep = 4;
                    $row = $db->fetch_array();
                    if (($row['orderstep'])!=$step){
                        if (($row['orderstep']+1)<=$maxstep) {
                            header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=orderstep".(intval($row['orderstep'])+1)."&o=".intval($_GET['o']));
                            exit();
                        }else{
                            header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=listorders");
                            exit();
                        }
                    }
                }
            }
            $db->query("SELECT CEILING(UsersOrders.orderPriceBlock+UsersOrders.orderPriceCover+UsersOrders.orderPriceBind) AS totalPrice,
                               CEILING(UsersOrders.orderPriceAdditService) AS orderPriceAdditService,
                               PaperFormat.formatName AS formatName,
                               PaperFormat.formatWidth AS formatWidth,
                               PaperFormat.formatHeight AS formatHeight,
                               UsersOrders.orderPages AS orderPages,
                               BindingType.BindingName AS BindingName,
                               PrintTypeCostsBlock.PrintTypeName AS PrintTypeName,
                               PaperTypeCostsBlock.PaperTypeName AS PaperTypeName,
                               PaperTypeCostsBlock.PaperTypeWeight AS PaperTypeWeight,
                               UsersOrders.orderCount AS orderCount,
                               UsersOrders.orderBinding AS orderBinding,
                               UsersOrders.orderCover AS orderCover
                        FROM UsersOrders, PaperFormat, BindingType, PrintTypeCostsBlock, PaperTypeCostsBlock
                        WHERE UsersOrders.orderSize = PaperFormat.formatId AND
                              PaperTypeCostsBlock.PaperTypeId = UsersOrders.orderPaperBlock AND 
                              PrintTypeCostsBlock.PrintType = UsersOrders.orderColorBlock AND
                              BindingType.BindingId = UsersOrders.orderBinding AND
                              UsersOrders.orderId = '" . intval($_GET['o']) . "' AND
                              UsersOrders.userId = '" . $_SESSION['userId'] . "' LIMIT 1");
            $dataorder = $db->fetch_array();
            $covers = array('soft'=>_OS3_SOFTCOVER,'hard'=>_OS3_HARDCOVER);
            $dataorder['cover'] =  $covers[$dataorder['orderCover']];
            $db->query("SELECT addressId, addressIndex, addressCity, addressStr, addressHouse, addressApt
                        FROM UsersDeliveryAddreses 
                        WHERE userId = '" . $_SESSION['userId'] . "'  AND 
                              isdel = '0' ");
            while ($row = $db->fetch_array()) {
                $addreses[] = $row;
            }
            $db->query("SELECT CountryId, CountryName
                        FROM DeliveryCountries");
            while ($row = $db->fetch_array()) {
                $countrys[] = $row;
            }
            $db->query("SELECT isOrg
                        FROM Users 
                        WHERE userId = '". $_SESSION['userId'] ."' LIMIT 1");
            $row = $db->fetch_array();
            $isOrg = $row['isOrg'];
            unset ($row);
            //Попытка получить массу
            $db->query("SELECT PaperTypeCostsBlock.PaperTypeWeight,
                               PaperFormat.formatWidth,
                               PaperFormat.formatHeight,
                               UsersOrders.orderCount,
                               UsersOrders.orderPages
                        FROM PaperTypeCostsBlock, PaperFormat, UsersOrders
                        WHERE UsersOrders.orderPaperBlock = PaperTypeCostsBlock.PaperTypeId AND
                              UsersOrders.orderSize = PaperFormat.formatId AND
                              UsersOrders.orderId = '".intval($_GET['o'])."'");
            $row = $db->fetch_array();
            $massa = ($row['PaperTypeWeight']*(($row['formatWidth']*$row['formatHeight'])/1000000000)*$row['orderCount']*($row['orderPages']/2+10))*1000;

            $t->addjs('jquery.simplemodal.1.4.1.min');
            $e->do ='listorders';
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('isorg'=>$isOrg, 'massa'=>$massa, 'mode'=>1,'countrys'=>$countrys,'dataorder'=>$dataorder,'addreses'=>$addreses, 'action' => Main_config::$main_file_name . '?do=orderstep4&amp;o=' . intval($_GET['o'])));
            $tpl->fetch('orderstep3.tpl');
            return $tpl->get_tpl();
        }
    }else{
        if ($_POST['do']=='getregion'){
            $db = new Db();
            $db->query("SELECT RegionId, RegionName, iscity
                        FROM DeliveryRegions
                        WHERE CountryId = '".  intval($_POST['countryid'])."' AND
                              RegionParentId ='0' ORDER BY `RegionName`  ASC");
            while ($row = $db->fetch_array()) {
                $regions[] = $row;
            }
            $e->do ='listorders';
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('mode'=>2,'regions'=>$regions));
            $tpl->fetch('orderstep3.tpl');
            $tpl->display();
        }
        if ($_POST['do']=='savenewaddress'){
            $db = new Db();
            $db->query("INSERT INTO UsersDeliveryAddreses 
                        SET userId = '" . $_SESSION['userId'] . "',
                            addressContact = '" . $db->mres($_POST['os3_addresscontact']) . "', 
                            addressTelephone = '" . $db->mres($_POST['os3_addresstelephone']) . "',
                            addressCountry = '" . intval($_POST['os3_addresscountry']) . "',
                            addressRegion = '" . intval($_POST['os3_addressregion']) . "',
                            addressIndex = '" . intval($_POST['os3_addressindex']) . "',
                            addressCity = '" . $db->mres($_POST['os3_addresscity']) . "',
                            addressStr = '" . $db->mres($_POST['os3_addressstr']) . "',
                            addressHouse = '" . intval($_POST['os3_addresshouse']) . "',
                            addressBuild = '" . intval($_POST['os3_addressbuild']) . "',
                            addressApt = '" . intval($_POST['os3_addressapt']) . "',
                            addressComment = '" . $db->mres($_POST['os3_addresscomment']) . "' ");
            $db->query("SELECT LAST_INSERT_ID()");
            $sel = $db->fetch_array();
            $db->query("SELECT addressId, addressIndex, addressCity, addressStr, addressHouse, addressApt
                        FROM UsersDeliveryAddreses 
                        WHERE userId = '" . $_SESSION['userId'] . "' AND 
                              isdel = '0' ");
            while ($row = $db->fetch_array()) {
                $addreses[] = $row;
            }

            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('mode'=>3,'addreses'=>$addreses,'sel'=>$sel[0]));
            $tpl->fetch('orderstep3.tpl');
            $tpl->display();
        }
        if ($_POST['do']=='getproviders'){
            $db = new Db();

            $db->query("SELECT PaperTypeCostsBlock.PaperTypeWeight,
                               PaperFormat.formatWidth,
                               PaperFormat.formatHeight,
                               UsersOrders.orderCount,
                               UsersOrders.orderPages
                        FROM PaperTypeCostsBlock, PaperFormat, UsersOrders
                        WHERE UsersOrders.orderPaperBlock = PaperTypeCostsBlock.PaperTypeId AND
                              UsersOrders.orderSize = PaperFormat.formatId AND
                              UsersOrders.orderId = '".intval($_POST['orderid'])."'");
            $row = $db->fetch_array();
            $massa = ($row['PaperTypeWeight']*(($row['formatWidth']*$row['formatHeight'])/1000000000)*$row['orderCount']*($row['orderPages']/2+10))*1000;

            if ($massa<1000){
                $db->query("SELECT DeliveryProviders.DeliveryProviderName AS DeliveryProviderName, 
                               DeliveryProvidersCosts.DeliveryProvidersCostsId AS DeliveryProvidersCostsId,
                               DeliveryProvidersCosts.DeliveryProviderCosts AS DeliveryProvidersCosts,
                               DeliveryProvidersCosts.OverQuote AS OverQuote
                        FROM DeliveryProviders, DeliveryProvidersCosts, UsersDeliveryAddreses
                        WHERE UsersDeliveryAddreses.addressId = '".intval($_POST['addressid'])."' AND
                              UsersDeliveryAddreses.addressCountry = DeliveryProvidersCosts.CountryId AND
                              UsersDeliveryAddreses.addressRegion = DeliveryProvidersCosts.RegionId AND
                              DeliveryProvidersCosts.DeliveryProviderId = DeliveryProviders.DeliveryProviderId AND
                              DeliveryProvidersCosts.minWeight < '".$massa."' AND
                              DeliveryProvidersCosts.maxWeight > '".$massa."' ");
                while ($row = $db->fetch_array()) {
                    $providers[] = $row;
                }
            }else{
                $db->query("SELECT DeliveryProviders.DeliveryProviderName AS DeliveryProviderName, 
                               DeliveryProvidersCosts.DeliveryProvidersCostsId AS DeliveryProvidersCostsId,
                               DeliveryProvidersCosts.DeliveryProviderCosts AS DeliveryProvidersCosts,
                               DeliveryProvidersCosts.OverQuote AS OverQuote
                        FROM DeliveryProviders, DeliveryProvidersCosts, UsersDeliveryAddreses
                        WHERE UsersDeliveryAddreses.addressId = '".intval($_POST['addressid'])."' AND
                              UsersDeliveryAddreses.addressCountry = DeliveryProvidersCosts.CountryId AND
                              UsersDeliveryAddreses.addressRegion = DeliveryProvidersCosts.RegionId AND
                              DeliveryProvidersCosts.DeliveryProviderId = DeliveryProviders.DeliveryProviderId AND
                              DeliveryProvidersCosts.minWeight < '".$massa."' AND
                              DeliveryProvidersCosts.maxWeight > '".$massa."' ");
                while ($row = $db->fetch_array()) {
                    $row['DeliveryProvidersCosts']= $row['DeliveryProvidersCosts']+$row['OverQuote']*ceil(($massa/1000)-1);
                    $providers[] = $row;
                }
            }

            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('massa'=>$massa,'mode'=>4,'providers'=>$providers));
            $tpl->fetch('orderstep3.tpl');
            $tpl->display();
        }
        if ($_POST['do']=='calc'){
            if ($_POST['idprovid']!=-1){
                echo $_POST['totalcosts']+$_POST['delivcosts'];
            }else{
                echo $_POST['totalcosts'];
            }
        }
    }
}

function listorders(&$e, &$t, &$u) {
    $db = new Db();
    if (is_numeric($_GET['o'])) {
            if (isset($_POST['os3_newo'])){
                $db->query("SELECT orderPriceBlock, orderPriceAdditService, orderPriceCover, orderPriceBind
                            FROM UsersOrders
                            WHERE orderId = '" . intval($_GET['o']) . "' AND
                                  userId = '" . $_SESSION['userId'] . "' LIMIT 1");
                $dataorder = $db->fetch_array();
                if ($_POST['typedeliv']!='pickup'){
                    $db->query("SELECT DeliveryProviderCosts, DeliveryProviderId
                                FROM DeliveryProvidersCosts
                                WHERE DeliveryProvidersCostsId = '".intval($_POST['os3_providers'])."'");
                    $row = $db->fetch_array();
                    $delivcost = $row['DeliveryProviderCosts'];
                    $delivprovid = $row['DeliveryProviderId'];
                }else{
                    $delivcost = 0;
                    $delivprovid = 0;
                }
                $db->query("UPDATE UsersOrders
                            SET orderPriceDeliver = '".$delivcost."',
                                addressId = '".intval($_POST['os3_addreses'])."',
                                DeliveryProviderId = '".$delivprovid."',
                                stateId = '1',                                    
                                orderstep = '3',
                                isOrg = '".intval($_POST['isorg'])."'
                            WHERE orderId = '".intval($_GET['o'])."' AND
                                  userId = '" . $_SESSION['userId'] . "'");
                $e->messuser(_LO_3STEPCOMPLETE, 1);
            }
    }
    if (isset($_POST['SignatureValue'])){
        $e->messuser(_LO_PAYCOMPLETE, 1);
    }
    if (isset($_POST['orderdel'])) {
//        $db->query("DELETE
//                    FROM UsersOrders
//                    WHERE orderId = '" . intval($_POST['orderdel']) . "' AND
//                          userId = '".$_SESSION['userId']."' ");
        $db->query("UPDATE UsersOrders
                    SET stateId = '11'
                    WHERE orderId = '" . intval($_POST['orderdel']) . "' AND
                          userId = '".$_SESSION['userId']."' ");
        $e->messuser(_LO_ORDERDELETED, 2);
    }
    $CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'psrRTxAmxTgLKDejsZSU', 'WnSCcRAQCGVTpqjbuYfu');
    $card_pay_orderid = 'pub' . intval($_GET['o']);
    $cardres = $CardPay->getOrderRegInfo($card_pay_orderid);
    $db = new Db();
    if (isset($cardres['status']) && $cardres['noty'] == 0){
        $db->query( "UPDATE `CardPayAvangard`
                     SET `noty` = 1, `order_id` = '-" . $db->mres($card_pay_orderid) . "'
                     WHERE `order_id` = '" . $db->mres($card_pay_orderid) . "'" );
        if ($cardres['status'] != 0) {
            if ($cardres['status'] == 5){
                if ($cardres['status_code'] == -1){
                    $e->messuser("Оплата обрабатывается", 1);
                } else if ($cardres['status_code'] == 3){
                    $e->messuser("Оплата прошла успешно", 1);
                } else {
                    $e->messuser("Оплата не проведена:<br>Отказ банка – эмитента карты.<br>Ошибка в процессе оплаты, указаны неверные данные карты.", 0);
                }
            }
        }
    }
    $db->query("SELECT orderId, orderName, orderAutor, orderCount, orderDate, orderstep, stateId
                FROM UsersOrders 
                WHERE userId = '".$_SESSION['userId']."' AND 
                      stateId <> '11' AND 
                      stateId <> '9'  ORDER BY orderId DESC ". Engine::pagesql());
    $orders = array();
    while ($row = $db->fetch_array()) {
        $orders[] = $row;
    }
    $db->query("SELECT count(*)
                FROM UsersOrders 
                WHERE userId = '".$_SESSION['userId']."' AND
                      stateId <> '11' AND 
                      stateId <> '9' ");
    $count = $db->fetch_array();
    $db->query("SELECT stateId, stateName
                FROM OrdersStates");
    while ($row = $db->fetch_array()) {
        $status[$row['stateId']] = $row['stateName'];
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('templates/');
    $tpl->set_vars(array('actionview'=>Main_config::$main_file_name . '?do=vieworder&amp;o=','pages' => Engine::pagetpl($count['0'], Main_config::$main_file_name . '?do=listorders'),'actiondel' => Main_config::$main_file_name . '?do=listorders&amp;p=' . intval($_GET['p']),'status'=>$status,'orders' => $orders,'hrefcont'=> Main_config::$main_file_name . '?do=orderstep1&amp;o='));
    $tpl->fetch('listorders.tpl');
    return $tpl->get_tpl();
}
function vieworder(&$e){
    if (is_numeric($_GET['o'])){
        $db = new Db();
        $db->query("SELECT UsersOrders.orderId AS orderId, 
                           UsersOrders.orderName AS orderName, 
                           UsersOrders.orderAutor AS orderAutor, 
                           UsersOrders.orderCount AS orderCount, 
                           UsersOrders.orderPages AS orderPages, 
                           UsersOrders.orderSymb AS orderSymb, 
                           UsersOrders.orderCover AS orderCover,
                           UsersOrders.orderstep AS orderstep,
                           PaperFormat.formatName AS formatName,
                           UsersOrders.stateId AS stateId,
                           PaperTypeCostsBlock.PaperTypeName AS PaperTypeName,
                           PaperTypeCostsBlock.PaperTypeWeight AS PaperTypeWeight,
                           BindingType.BindingName AS BindingName,
                           UsersOrders.orderAdditService AS orderAdditService,
                           CEILING(UsersOrders.orderPriceBlock) AS orderPriceBlock,
                           CEILING(UsersOrders.orderPriceAdditService) AS orderPriceAdditService,
                           CEILING(UsersOrders.orderPriceCover) AS orderPriceCover,
                           CEILING(UsersOrders.orderPriceBind) AS orderPriceBind,
                           PrintTypeCostsBlock.PrintTypeName AS PrintTypeName,
                           UsersOrders.DeliveryProviderId AS DeliveryProviderId,
                           UsersOrders.orderPriceDeliver AS orderPriceDeliver,
                           UsersOrders.addressId AS addressId,
                           UsersOrders.formatUplBlock AS formatUplBlock
                    FROM UsersOrders, PaperFormat, PaperTypeCostsBlock, BindingType, PrintTypeCostsBlock
                    WHERE userId = '".$_SESSION['userId']."' AND
                          orderId = '".intval($_GET['o'])."' AND
                          PaperFormat.formatId = UsersOrders.orderSize AND
                          PaperTypeCostsBlock.PaperTypeId = UsersOrders.orderPaperBlock AND
                          BindingType.BindingId = UsersOrders.orderBinding AND
                          PrintTypeCostsBlock.PrintType = UsersOrders.orderColorBlock
                            LIMIT 1");
        $data = $db->fetch_array();
        $t = explode(',', $data['orderAdditService']);
        $db->query("SELECT AdditionalServiceId, AdditionalServiceName
                    FROM AdditionalServiceCosts 
                    WHERE AdditionalServiceEnable = '1' ");
        $addedads='';
        while ($row = $db->fetch_array()) {
            if (count($t)>0) {
                if (in_array($row['AdditionalServiceId'], $t)) {
                    $addedads.=', ' . $row['AdditionalServiceName'];
                }
            }
        }
        if ($data['DeliveryProviderId']!=0){
            $db->query("SELECT DeliveryProviderName
                        FROM DeliveryProviders 
                        WHERE DeliveryProviderId = '". $data['DeliveryProviderId'] ."' ");
            $row = $db->fetch_array();
            $namedeliv = $row[0];
            $db->query("SELECT DeliveryCountries.CountryName AS CountryName,
                               DeliveryRegions.RegionName AS RegionName,
                               UsersDeliveryAddreses.addressIndex AS addressIndex,
                               UsersDeliveryAddreses.addressCity AS addressCity,
                               UsersDeliveryAddreses.addressStr AS addressStr,
                               UsersDeliveryAddreses.addressHouse AS addressHouse,
                               UsersDeliveryAddreses.addressBuild AS addressBuild,
                               UsersDeliveryAddreses.addressApt AS addressApt,
                               UsersDeliveryAddreses.addressContact AS addressContact,
                               UsersDeliveryAddreses.addressTelephone AS addressTelephone
                        FROM UsersDeliveryAddreses, DeliveryCountries, DeliveryRegions
                        WHERE UsersDeliveryAddreses.addressId = '". $data['addressId'] ."' AND
                              DeliveryCountries.CountryId = UsersDeliveryAddreses.addressCountry AND 
                              DeliveryRegions.RegionId = UsersDeliveryAddreses.addressRegion ");
            $dataadres = $db->fetch_array();
        }
        if ($data['stateId']==5){
            $db->query("SELECT OrdersDeny.cause 
                        FROM OrdersDeny
                        WHERE OrdersDeny.orderId = '".intval($_GET['o'])."' ");
            $denycause = $db->fetch_array();
        }
        $dhref[0]='./include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.$data['orderId'].'&amp;o=block'.$data['formatUplBlock'];
        $dhref[1]='./include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.$data['orderId'].'&amp;o=blocklayot';
        if (file_exists('./uploads/'.$_SESSION['userId'].'/'.$data['orderId'].'/'.$data['orderId'].'_cover.jpg') || file_exists('./uploads/'.$_SESSION['userId'].'/'.$data['orderId'].'/'.$data['orderId'].'_cover.png')){
            $dhref[2]='./include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.$data['orderId'].'&amp;o=cover';
            $dhref[3]='./include/get.php?uid='.$_SESSION['userId'].'&amp;oid='.$data['orderId'].'&amp;o=coverlayot';
        }

        $covers = array('soft'=>_VO_SOFTCOVER,'hard'=>_VO_HARDCOVER);
        $e->do = 'listorders';
        $tpl = new Template();
        $tpl->set_path('templates/');
        $tpl->set_vars(array('denycause'=>$denycause[0], 'dhref'=>$dhref,'hrefcont'=> Main_config::$main_file_name . '?do=orderstep1&amp;o=','data'=>$data,'covers'=>$covers, 'addedads'=>substr($addedads,2),'namedeliv'=>$namedeliv, 'dataadres'=>$dataadres));
        $tpl->fetch('vieworder.tpl');
        return $tpl->get_tpl();
    }

}
function listarchive(&$e, &$t, &$u) {
    $db = new Db();

    $db->query("SELECT orderId, orderName, orderAutor, orderCount, orderDate, orderPriceDeliver, 
                CEILING((orderPriceBind+orderPriceCover+orderPriceAdditService+orderPriceBlock)) AS total
                FROM UsersOrders 
                WHERE userId = '".$_SESSION['userId']."' AND stateId = '9' ORDER BY orderId DESC ". Engine::pagesql());
    $orders = array();
    while ($row = $db->fetch_array()) {
        $orders[] = $row;
    }
    $db->query("SELECT count(*)
                FROM UsersOrders 
                WHERE userId = '".$_SESSION['userId']."' AND
                      stateId = '9'");
    $count = $db->fetch_array();

    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('templates/');
    $tpl->set_vars(array('orders'=>$orders,'actionview'=>Main_config::$main_file_name . '?do=vieworder&amp;o=','pages' => Engine::pagetpl($count['0'], Main_config::$main_file_name . '?do=listarchive')));
    $tpl->fetch('listarchive.tpl');
    return $tpl->get_tpl();
}

function orderstep4(&$e, &$t, &$u) {
    if (!isset($_GET['a'])) {
        if (is_numeric($_GET['o'])) {
           if (isset($_POST['os3_newo'])){
                $db = new Db();
                $db->query("SELECT orderPriceBlock, orderPriceAdditService, orderPriceCover, orderPriceBind
                            FROM UsersOrders
                            WHERE orderId = '" . intval($_GET['o']) . "' AND
                                  userId = '" . $_SESSION['userId'] . "' LIMIT 1");
                $dataorder = $db->fetch_array();
                if ($_POST['typedeliv']!='pickup') {
                    $db->query("SELECT PaperTypeCostsBlock.PaperTypeWeight,
                                       PaperFormat.formatWidth,
                                       PaperFormat.formatHeight,
                                       UsersOrders.orderCount,
                                       UsersOrders.orderPages
                                FROM PaperTypeCostsBlock, PaperFormat, UsersOrders
                                WHERE UsersOrders.orderPaperBlock = PaperTypeCostsBlock.PaperTypeId AND
                                      UsersOrders.orderSize = PaperFormat.formatId AND
                                      UsersOrders.orderId = '".intval($_GET['o'])."'");
                    $row = $db->fetch_array();
                    $massa = ($row['PaperTypeWeight']*(($row['formatWidth']*$row['formatHeight'])/1000000000)*$row['orderCount']*($row['orderPages']/2+10))*1000;
                    unset ($row);
                    $db->query("SELECT DeliveryProviderCosts, DeliveryProviderId, OverQuote
                                FROM DeliveryProvidersCosts
                                WHERE DeliveryProvidersCostsId = '".intval($_POST['os3_providers'])."'");
                    $row = $db->fetch_array();

                    if ($massa<1000){
                        $delivcost = $row['DeliveryProviderCosts'];
                    }else{
                        $delivcost = $row['DeliveryProviderCosts']+$row['OverQuote']*ceil(($massa/1000)-1);
                    }
                    $delivprovid = $row['DeliveryProviderId'];
                } else {
                    $delivcost = 0;
                    $delivprovid = 0;
                }

                $db->query("UPDATE UsersOrders
                            SET orderPriceDeliver = '".$delivcost."',
                                addressId = '".intval($_POST['os3_addreses'])."',
                                DeliveryProviderId = '".$delivprovid."',
                                stateId = '1',                                    
                                orderstep = '3',
                                isOrg = '".intval($_POST['isorg'])."'
                            WHERE orderId = '".intval($_GET['o'])."' AND
                                  userId = '" . $_SESSION['userId'] . "'");
                $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_GET['o']) . "',
                                curState = '1',
                                userId = '" . $_SESSION['userId'] . "' ");
                $db->query("SELECT userFirstName, userLastName
                            FROM Users
                            WHERE Users.userId = '" . $_SESSION['userId'] . "' ");
                $userdata = $db->fetch_array();
                $ar_search = array('_USERNAME','_NUMORDER','_USERLASTNAME');
                $ar_replace = array($userdata['userFirstName'],intval($_GET['o']),$userdata['userLastName']);
                $db->query("SELECT userEmail
                            FROM Users
                            WHERE Users.userGroupId = '" .Settings::$v['managegroup'] . "' ");
                while ($row = $db->fetch_array()) {
                    $mails[] = $row['userEmail'];
                }
                $mails[] = $_SESSION['userEmail'];
                $e->mail($mails,str_replace($ar_search, $ar_replace, Settings::getsetting('mailgetorder','mailgetorder_subj')), str_replace($ar_search,$ar_replace, Settings::getsetting('mailgetorder','mailgetorder_text')));
                $e->messuser(_LO_3STEPCOMPLETE, 1);
            }else{

                $db = new Db();
                $db->query("SELECT orderstep
                            FROM UsersOrders 
                            WHERE orderId = '" . intval($_GET['o']) . "' AND
                                  userId = '" . $_SESSION['userId'] . "' LIMIT 1");
                if ($db->num_rows()==1){
                    $step = 3;
                    $maxstep = 4;
                    $row = $db->fetch_array();
                    if (($row['orderstep'])!=$step){
                        if (($row['orderstep']+1)<=$maxstep) {
                            header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=orderstep".(intval($row['orderstep'])+1)."&o=".intval($_GET['o']));
                            exit();
                        }else{
                            header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=listorders&o=".intval($_GET['o']));
                            exit();
                        }
                    }
                }
            }
            $CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'psrRTxAmxTgLKDejsZSU', 'WnSCcRAQCGVTpqjbuYfu');
            $card_pay_orderid = 'pub' . intval($_GET['o']);
            $cardres = $CardPay->getOrderRegInfo($card_pay_orderid);
            $db = new Db();
            if (isset($cardres['status']) && $cardres['noty'] == 0){
                $db->query( "UPDATE `CardPayAvangard`
                                   SET `noty` = 1, `order_id` = '-" . $db->mres($card_pay_orderid) . "'
                                   WHERE `order_id` = '" . $db->mres($card_pay_orderid) . "'" );
                if ($cardres['status'] != 0) {
                    if ($cardres['status'] == 5){
                        if ($cardres['status_code'] == -1){
                            $e->messuser("Оплата обрабатывается", 1);
                        } else if ($cardres['status_code'] == 3){
                            $e->messuser("Оплата прошла успешно", 1);
                        } else {
                            $e->messuser("Оплата не проведена:<br>Отказ банка – эмитента карты.<br>Ошибка в процессе оплаты, указаны неверные данные карты.", 0);
                        }
                    }
                }
            }
            $db->query("SELECT CEILING((UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver)) AS orderPriceTotal
                        FROM UsersOrders
                        WHERE UsersOrders.orderId = '".intval($_GET['o'])."' ");
            $row = $db->fetch_array();
            $tprice =$row['orderPriceTotal'];
            if ($tprice>=15000){
                $qiwi = 1;
            }
            $hrefkvit = '/include/excelorder.php?o='.intval($_GET['o']);
            $hrefkvit2 = '/include/excelorder.php?o='.intval($_GET['o']).'&clean';
            //qiwi
            if ($qiwi != 1){
                $db->query("SELECT paysysId 
                            FROM OrderBills
                            WHERE ispay <> 1 AND
                                  orderId = '".intval($_GET['o'])."' ");
                if (($db->num_rows()) < 1 ){
                    $qiwi = 2;
                }elseif (($db->num_rows()) == 1){
                    require_once "bill/IShopServerWSService.php";
                    $row = $db->fetch_array();
                    $service = new IShopServerWSService('bill/IShopServerWS.wsdl', array('location'      => 'https://ishop.qiwi.ru/services/ishop', 'trace' => 1));
                    $params = new checkBill();
                    $params->login = 12456;
                    $params->password = 'gpvqmlu12456';
                    $params->txn = $row['paysysId'];
                    $res = $service->checkBill($params);
                    if ($res->status== 50){
                        $qiwi = 3;
                    }elseif ($res->status >= 100 || $res->status <0) {
                        $qiwi = 4;
                    }
                }
            }
            //robokassa
            $mrh_login = "ysuccuba";
            $mrh_pass1 = "gpvqmlu12456";
            $inv_id = intval($_GET['o']);
            $inv_desc = 'Счет на оплату № '.intval($_GET['o']).' от '.date("d.m.y");
            $out_summ = $tprice;
//            $in_curr = "PCR";
            $culture = "ru";
            $receipt = json_encode(array(
                sno => "usn_income_outcome",
                items => array(
                    array(
                        name => "Название товара 1",
                        quantity => 1,
                        sum => $out_summ,
                        payment_method => "full_payment",
                        payment_object => "payment",
                        tax => "none"
                    )
                )
            ));
            $receiptEncoded = urlencode($receipt);
            $crc = md5($mrh_login.':'.$out_summ.':'.$inv_id.':'. $receiptEncoded . ':' .$mrh_pass1);
            $robokassa = "<form action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
                "<input type=hidden name=MrchLogin value=$mrh_login>".
                "<input type=hidden name=OutSum value=$out_summ>".
                "<input type=hidden name=InvId value=$inv_id>".
                "<input type=hidden name=Desc value='$inv_desc'>".
                "<input type=hidden name=SignatureValue value=$crc>".
                "<input type=hidden name=Culture value=$culture>".
                "<input type=hidden name=Receipt value='$receiptEncoded'>".
                "<label>Стоимость:  ".$out_summ." руб. <input class='button red' type=submit value='Оплатить'></label>". "</form>";
            //
            $e->do ='listorders';
            $tpl = new Template();
            $tpl->set_path('templates/');
            $desc = 'Счет на оплату № '.intval($_GET['o']).' от '.date("d.m.y");
            $tpl->set_vars(array(
                'hrefkvit2'=>$hrefkvit2,
                'orderNr'=> intval($_GET['o']),
                'amount'=> $out_summ,
                'qiwi'=>$qiwi,
                'robokassa'=>$robokassa,
                'hrefkvit'=>$hrefkvit,
                'desc'=> $desc,
                'hmacRaiff' => hash_hmac( 'sha256' , '000001788571001;88571001;'.$desc.';'.$out_summ , 'zHkm6+ESnb9C6KTr6X1ZOP7j2bS3cDgVf+r9gAF7uZ8='),
                'action' => Main_config::$main_file_name . '?do=orderstep4&o='.intval($_GET['o']),
            ));
            $tpl->fetch('orderstep4.tpl');
            return $tpl->get_tpl();
        }
    }else{
        if ($_POST['do']=='createbill'){
            $db = new Db();
            $db->query("SELECT CEILING((UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver)) AS orderPriceTotal
                        FROM UsersOrders
                        WHERE UsersOrders.orderId = '".intval($_POST['o'])."' ");
            $row = $db->fetch_array();
            $price = $row['orderPriceTotal'];
            require_once "bill/IShopServerWSService.php";
            $service = new IShopServerWSService('bill/IShopServerWS.wsdl', array('location'      => 'https://ishop.qiwi.ru/services/ishop', 'trace' => 1));
            $txn = intval($_POST['o']).'-'.date("ymdhi");
            $params_newpay = new createBill();
            $params_newpay->login = 12456;
            $params_newpay->password = 'gpvqmlu12456';
            $params_newpay->user = intval($_POST['phone']);
            $params_newpay->amount = $price;
            $params_newpay->comment = 'Счет на оплату № '.intval($_POST['o']).' от '.date("d.m.y");
            $params_newpay->txn = $txn;
            $params_newpay->lifetime = date("d.m.y H:i:s", mktime(0, 0, 0, date("m"), date("d")+7, date("y")));
            $params_newpay->alarm = 0;
            $params_newpay->create = true;
            $res = $service->createBill($params_newpay);
            if ($res->createBillResult==0){
                $db = new Db();
                $db->query("SELECT paysysId 
                FROM OrderBills
                WHERE ispay <> 1 AND
                      orderId = '".intval($_POST['o'])."' AND
                      paysys = 'qiwi' ");
                if (($db->num_rows()) < 1){
                    $db->query("INSERT INTO OrderBills
                                SET orderId = '".intval($_POST['o'])."',
                                    userId = '".$_SESSION['userId']."',
                                    paysys = 'qiwi',
                                    paysysId = '".$txn."' ");
                    echo _OS4_TEXTQIWI2;
                }else{
                    $db->query("UPDATE OrderBills
                                SET paysysId = '".$txn."' 
                                WHERE orderId = '".intval($_POST['o'])."' AND
                                      paysys = 'qiwi' ");
                    echo _OS4_TEXTQIWI2;
                }
            }
        }
        if ($_POST['do']=='resetbillqiwi'){
            $db = new Db();
            $db->query("SELECT paysysId 
                        FROM OrderBills
                        WHERE ispay <> 1 AND
                              orderId = '".intval($_POST['o'])."' ");
            $row = $db->fetch_array();
            require_once "bill/IShopServerWSService.php";
            $service = new IShopServerWSService('bill/IShopServerWS.wsdl', array('location'      => 'https://ishop.qiwi.ru/services/ishop', 'trace' => 1));
            $params2 = new cancelBill();
            $params2->login = 12456;
            $params2->password = 'gpvqmlu12456';
            $params2->txn = $row['paysysId'];
            $res = $service->cancelBill($params2);
            if ($res->cancelBillResult==0){
                echo '<input type="hidden" name="orderid" id="os4_orderid" value="'.$_POST['o'].'" />
                <label>'._OS4_TYPEPHONE.'<input name="qiwiphone" id="os4_qiwiphone" type="text" maxlength="10" style="width: 100px;" /></label>
                <br><input class="button" type="button" id="os4_send" value="'._OS4_CHECKOUT.'"/>';
            }
        }
    }
}
?>

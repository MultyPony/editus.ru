<?php session_start();
require_once './config.inc.php';
require_once './include/db_class.php';
if (Main_config::$serviceoff !=1 || isset($_SESSION['admin'])){
        $db_books = new Db();
        $onpage = 10;

        if (!isset($_GET['p'])){
            $_GET['p']=1;
        }
        $l1 = (intval($_GET['p'])-1) * ($onpage);
        $l2 = $onpage;
        $pagesql = "LIMIT ".$l1.", ".$l2;

        $filt = '';
        if (isset($_POST['filt']) && intval($_POST['filt'])!='-1' ){
            $filt = " ShopItems.classificateId = '".  intval($_POST['filt'])."' AND ";
        }
        if (isset($_POST['search']) && !empty($_POST['search']) && $_POST['search']!='Поиск'){
            $filt .= " ( ShopItems.itemName LIKE '%".$db_books->mres($_POST['search'])."%' OR ShopItems.itemAuthor LIKE '%".$db_books->mres($_POST['search'])."%' ) AND ";
        }

        
        $db_books->query("SELECT count(*)
                    FROM ShopItems, ShopItemClassificate, PaperFormat, PrintTypeCostsBlock
                    WHERE ShopItems.classificateId = ShopItemClassificate.classificateId AND
                          ShopItems.PrintTypeId = PrintTypeCostsBlock.PrintTypeId AND
                          ShopItems.isEnable = 1 AND ".$filt."
                          ShopItems.formatId = PaperFormat.formatId ORDER BY ShopItems.itemAuthor");
        $count = $db_books->fetch_array();
        $count = $count[0];
        $db_books->query("SELECT ShopItems.itemId, ShopItems.itemName, ShopItems.itemAuthor, ShopItems.itemAnnotation, ShopItemClassificate.classificateName, 
                           ShopItems.itemISBN, ShopItems.itemPublish, ShopItems.itemPages, ShopItems.itemTypeCover, PrintTypeCostsBlock.PrintTypeName,
                           PaperFormat.formatName, ShopItems.itemPrice, ShopItems.itemAuthorUrl
                    FROM ShopItems, ShopItemClassificate, PaperFormat, PrintTypeCostsBlock
                    WHERE ShopItems.classificateId = ShopItemClassificate.classificateId AND
                          ShopItems.PrintTypeId = PrintTypeCostsBlock.PrintTypeId AND
                          ShopItems.isEnable = 1 AND ".$filt."
                          ShopItems.formatId = PaperFormat.formatId ORDER BY ShopItems.itemAuthor ".$pagesql." ");
        $cover['soft']= 'Мягкий переплет';
        $cover['hard']= 'Твердый переплет';
        if ($db_books->num_rows()==1 && isset($_POST['filt'])){
            $row = $db_books->fetch_array();
            header("Location: //".$_SERVER['HTTP_HOST'].'/more.php?itemid='.$row['itemId']);
            exit;
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="//www.w3.org/1999/xhtml"> 
    <head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <meta name="description" content="Публикация книги в интернет-магазине. Купить книги наших авторов">
    <meta name="keywords" content="печать книги, печать книг от одного экземпляра, печать книг малыми тиражами, издать книгу, напечатать книгу">
    <meta name="author" content="Editus Publishing">
        <title>Интернет-магазин в Издательстве - печать книг по требованию</title>
 
     <?php include 'links.php';?>
    <!-- SCRIPTS -->
    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
        <?php echo $headscripts; ?>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/bookstore.js"></script>
    <script>$(function() { $('#site-navigation > ul > li').removeClass('current-menu-item').eq(5).addClass('current-menu-item') });</script>

    
    </head>


    <body>
       
       <!-- #PAGE -->
    <div id="page" class="hfeed site"> 
 
                             <?php include 'top.php';?>


 <!-- #main -->

      <section id="main" class="middle wrapper">
        <div class="row row-fluid">
        <!-- #primary -->
                <div id="primary" class="site-content">
                    
                    <!-- #content -->
                    <div id="content" role="main">

                        
                        
						<!-- .entry-header -->
                              <header class="entry-header">
                                <h1 class="entry-title">Бумажные издания</h1>
                              </header>
                              <!-- .entry-header -->
                                    <?php include 'topmenu.php';?>

                   
                    <div class="textindex">
                        <div style="padding-bottom:30px; padding-top: 30px;">
                            <form id="filt" action="bookstore.php" method="post">Выбрать
                                <select name="filt">
                                    <option value="-1">Все жанры</option>
                                <?php   
                                $db = new Db();
                                $db->query("SELECT classificateId, classificateName
                                            FROM ShopItemClassificate");
                                while ($row = $db->fetch_array()) {
                                    if (intval($_POST['filt'])==$row['classificateId']){
                                        $sel='selected="selected" ';
                                    }
                                    ?><option <?php echo $sel;$sel='';?> value="<?php echo $row['classificateId'];?>"><?php echo $row['classificateName'];?></option><?php
                                }?> 
                                </select>

                                <input type="text" name="search" value="<?php echo $_POST['search'];?>" />
                                <input type="submit" value="Искать" class="button-s" />
                            </form> 
                           
            </div>   
           
                     
                    <?php 
                    
                        while ($row = $db_books->fetch_array()) {
                            $row['itemTypeCover'] = $cover[$row['itemTypeCover']];

                    ?>
                        <h2><?php echo $row['itemName']; ?></h2>
                        <!-- .row-fluid -->
                                   
                                   
                                   
                                    <!-- .row-fluid -->
                        <div class="row-fluid show-grid">
                            <div class="span4">
                                    <a href="<?php echo 'more.php?itemid='.$row['itemId'];?>"><img src="<?php echo '/items/'.$row['itemId'].'/'.$row['itemId'].'_cover.png'; ?>" width="60%"></a>
                                </div>
                                <div class="span8">
<!--                                    <br />Название: <strong><?php echo $row['itemName']; ?> </strong>-->
                                    <h3 style="padding-top:0; margin-top:0;">Автор:<strong> <?php echo $row['itemAuthor']; ?></strong></h3>
                                    <p><?php if (!empty($row['itemAnnotation'])){echo '<br />';} echo $row['itemAnnotation'].'...<br/><a class="head" href="more.php?itemid='.$row['itemId'].'"><em>Подробнее &rarr;</em></a>'; ?></p>
                                    <h3>Стоимость: <span id="vpr"><?php echo $row['itemPrice']; ?></span> руб.</h3>
                                    <?php if (!empty($dataitem['itemAuthorUrl'])){?>
                                    <a class="button red" target="_blank" href="<?php echo $dataitem['itemAuthorUrl']; ?>">Скачать книгу</a>&nbsp;&nbsp;
                                    <?php }?>
									<?php if (isset($_SESSION['userId'])){ ?>
                                    <a class="button addtocart" href="<?php echo $row['itemId'];?>" ><span> Добавить в корзину </span></a>
                                    <?php }else{ ?>
                                    <a class="button" href="editus.php?do=login" ><span> Добавить в корзину </span></a>
                                    <?php } ?>
                                </div> 
                                
                        </div>
                        <hr />
                        
                        
                    <?php }
                            if ($count > $onpage){
                                $pages = intval($count/$onpage);
                                if ($count%$onpage > 0){
                                    $pages+=1;
                                }
                                if (!isset($_GET['p'])){
                                    $_GET['p']=1;
                                }
                                $curpage=intval($_GET['p']);
                                $action='bookstore.php';
                                ?>
                                
                            <!-- post pagination -->
                            <nav class="post-pagination">
                                <ul class="pagination">
                                  <li class="pagination-first">
									<a href="<?php echo $action."?p=1";?>">«</a></li>
                                    
									<?php
                                    for($i=($curpage-2);$i<=$curpage+2;$i++){
                                        if ($i>0 && $i<=$pages){
                                            if ($i!=$curpage){?>    
                                                <li class="pagination-num"><a href="<?php echo $action."?p=".$i; ?>"><?php echo $i;?></a></li>  
                                            <?php }else{?>
                                                <li class="pagination-num" style="padding: .3em .9em; border-bottom: 2px solid #555;"><?php echo $i;
                                            }
                                        }
                                    } ?></li>
                                    <li class="pagination-last">
                                	<a href="<?php echo $action."?p=".$pages; ?>">»</a>
									</li>
                                </ul>
                                </nav>
                                <?php
                    }
                    ?>
                    </div>
                    </div>
                    </div>
                    </section>
                        <?php include 'footer.php';?> 
                        <?php include 'scripts_read.php';?>

    </body>
</html>
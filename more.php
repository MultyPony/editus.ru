<?php session_start();
require_once './config.inc.php';
require_once './include/db_class.php';
$id = intval($_GET['itemid']);
$db = new Db();
$db->query("SELECT ShopItems.itemId, ShopItems.itemName, ShopItems.itemAuthor, ShopItems.itemAnnotation, ShopItemClassificate.classificateName, 
                   ShopItems.itemISBN, ShopItems.itemPublish, ShopItems.itemPages, ShopItems.itemTypeCover, PrintTypeCostsBlock.PrintTypeName,
                   PaperFormat.formatName, ShopItems.itemPrice, ShopItems.itemAuthorUrl, BindingType.BindingName, PaperTypeCostsBlock.PaperTypeName,
                   PaperTypeCostsBlock.PaperTypeWeight
            FROM ShopItems, ShopItemClassificate, PaperFormat, PrintTypeCostsBlock, BindingType, PaperTypeCostsBlock
            WHERE ShopItems.itemId = '".$id."' AND
                  PaperTypeCostsBlock.PaperTypeId = ShopItems.papertTypeId AND
                  BindingType.BindingId = ShopItems.bindingId AND
                  ShopItems.classificateId = ShopItemClassificate.classificateId AND
                  ShopItems.PrintTypeId = PrintTypeCostsBlock.PrintTypeId AND
                  ShopItems.isEnable = 1 AND
                  ShopItems.formatId = PaperFormat.formatId LIMIT 1");
$dataitem = $db->fetch_array();
$cover['soft']= 'Мягкий переплет';
$cover['hard']= 'Твердый переплет';
$dataitem['itemTypeCover'] = $cover[$dataitem['itemTypeCover']];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="//www.w3.org/1999/xhtml"> 
    <head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <meta name="description" content="Подробное описание книги <?php echo $dataitem['itemName']; ?>.">
    <meta name="keywords" content="печать книги, печать книг от одного экземпляра, печать книг малыми тиражами, издать книгу, напечатать книгу">
    <meta name="author" content="Editus Publishing">
        <title><?php echo $dataitem['itemName']; ?></title>
 
    <?php include 'links.php';?>
    
    <!-- SCRIPTS -->
    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/bookstore.js"></script>
    <script>$(function() { $('#site-navigation > ul > li').removeClass('current-menu-item').eq(3).addClass('current-menu-item') });</script>
<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//userapi.com/js/api/openapi.js?52"></script>

<script type="text/javascript">
  VK.init({apiId: 3092006, onlyWidgets: true});
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    
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



                    <header class="entry-header">
                                <h1 class="entry-title">Купить книгу</h1>
                              </header>
                              <!-- .entry-header -->
                                    <?php include 'topmenu.php';?>
                                    
                    <div class="textindex">
                        <h2><?php echo $dataitem['itemName']; ?></h2>
                        <div class="row-fluid show-grid">
                            <div class="span4">
                                    <img src="<?php echo '/items/'.$dataitem['itemId'].'/'.$dataitem['itemId'].'_cover.png'; ?>" border="0" />
                                    
                                    
                                <noindex>  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<p>
<div class="fb-like" data-href="//editus.ru/more.php?itemid=<?php echo $id ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="true" data-action="recommend"></div> 
</p>
<p>
<!-- Put this div tag to the place, where the Like block will be -->
<div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "button", height: 18});
</script>
</noindex>
</p>
<br />
<p><a href="bookstore.php"><em>&larr; Вернуться к списку</em></a></p>
									</div>
									<div class="span8">
                                    <h2 style="padding-top:0; margin-top:0;">Автор:<strong> <?php echo $dataitem['itemAuthor']; ?></strong></h2>
                                    <br />Классификация: <?php echo $dataitem['classificateName']; ?>
                                    <br />ISBN: <?php echo $dataitem['itemISBN']; ?>
                                    <br />Издательство: <?php echo $dataitem['itemPublish']; ?>
                                    <br />Кол-во страниц: <?php echo $dataitem['itemPages']; ?>
                                    <br />Переплет: <?php echo $dataitem['itemTypeCover']; ?>
                                    <br />Красочность печати: <?php echo $dataitem['PrintTypeName']; ?>
                                    <br />Формат: <?php echo $dataitem['formatName']; ?>
                                    <br />Тип бумаги: <?php echo $dataitem['PaperTypeName'].' '.$dataitem['PaperTypeWeight']; ?>
                                    <br />Крепление: <?php echo $dataitem['BindingName']; ?>
                                    <?php if ( file_exists('./items/'.$dataitem['itemId'].'/'.$dataitem['itemId'].'_preview.pdf')) { ?>
                                    <br /><a href="./include/shopget.php?itemid=<?php echo $dataitem['itemId'];?>&amp;o=preview" >Скачать книгу</a>
                                    <?php  } ?>
                                    
                                    
                                    <p><?php echo $dataitem['itemAnnotation']; ?></p>
                                    <h2>Стоимость: <font color="#FF0000"><b><span id="vpr"><?php echo $dataitem['itemPrice']; ?></span></b></font> руб.</h2>
                                    <br />
									<?php if (!empty($dataitem['itemAuthorUrl'])){?>
                                    <br /><a class="button red" target="_blank" href="<?php echo $dataitem['itemAuthorUrl']; ?>">Скачать книгу</a>&nbsp;&nbsp;
                                    <?php }?>
									<?php if (isset($_SESSION['userId'])){ ?>
                                    <a class="button addtocart" href="<?php echo $dataitem['itemId'];?>" ><span>Купить книгу</span></a>
                                    <?php }else{ ?>
                                    <a class="button" href="editus.php?do=shoporderstep1" ><span>Добавить в корзину</span></a>
                                    <?php } ?>
                                </div>
                        </div>
                    </div> 
</div></div></div></section>
                        <?php include 'footer.php';?> 
                        <?php include 'scripts_read.php';?>

    </body>
</html>
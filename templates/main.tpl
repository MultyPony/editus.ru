<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="//www.w3.org/1999/xhtml"> 
    <head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <meta name="description" content="Издательство Эдитус. Издание книг на заказ: от 1 экземпляра, мягкая и твердая обложка с шитьем. Собственная типография, короткие сроки, качественная печать, приемлемые цены. Сервис онлайн печати.">
    <meta name="keywords" content="печать книги, печать книг от одного экземпляра, печать книг малыми тиражами, издать книгу, напечатать книгу">
    <meta name="author" content="Editus Publishing">
        <title>Издательство Эдитус - заказать печать книги онлайн</title>
 
    <?php include 'links.php';?>
            
    <!-- SCRIPTS -->
    <?php echo $headscripts; ?>
    <script>$(function() { $('#site-navigation > ul > li').removeClass('current-menu-item').eq(6).addClass('current-menu-item') });</script>
    <script type="text/javascript" src="cdek/widjet.js" charset="utf-8" id="ISDEKscript" ></script>
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
                    
                    <!-- .blog-single -->
                          <div class="blog-single readable-content">
                            
                            
                            <!-- .hentry -->
                            <article class="post type-post format-standard hentry">
                            
                            		<header class="entry-header">
                                         <h1 class="entry-title">Личный кабинет</h1>
                                    </header>
									
                                    <?php include 'topmenu.php';?>

                    			<div class="entry-content">
                        			<!--<?php echo $usermenu; ?>-->
                        			<?php echo $mess; ?>
                        			<?php echo $auth; ?>
                        				<div id="content">
                        					<?php echo $content; ?>
                        				</div>
                                        
                                       
                    			</div>
                    		</article>
                       </div>
                    </div>
                 </div>
               </div>
              </section>
                              
                             <?php include 'footer.php';?> 


    </body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="//www.w3.org/1999/xhtml"> 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>Издание книг, типография - книги  на заказ</title>
    <meta name="description" content="Издательство Эдитус. Оставить отзыв." />
    <link rel="shortcut icon" href="img/favicon.ico" />
<!-- FONTS -->
<link href='//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>    <link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,700,100,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<!-- STYLES -->
    <link rel="stylesheet" type="text/css" media="print" href="../css/print.css">
    <link rel="stylesheet" type="text/css" href="../new/css/grid.css">
    <link rel="stylesheet" type="text/css" href="../new/css/style.css">
    <link rel="stylesheet" type="text/css" href="../new/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../new/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../new/js/google-code-prettify/prettify.css">
    <link rel="stylesheet" type="text/css" href="../new/css/uniform.default.css">
    <link rel="stylesheet" type="text/css" href="../new/css/main.css">
    <link rel="stylesheet" type="text/css" href="../new/css/flexslider.css">    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript">
        <!--
        $(function(){
            $('.close').click(function(){
                window.parent.$.modal.close();
            });
        });
        //-->
    </script>
</head>
    <body style="margin: auto; padding: 0; width:500px;">

        <?php
        $f = false;
        if (isset($_POST['name'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
                ?><p style="font-weight: bold; color: #ff0000;">Пожалуйста, заполните все поля</p><?php
            }else{
                if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email'])){
                    ?><p style="font-weight: bold; color: #ff0000;">Некорректный email</p><?php
                }else{
                    if (!empty ($_FILES['mailfile']['name'])){
                        $path = 'emailfiles';
                        $expans = end(explode(".", $_FILES['mailfile']['name']));
                        do {
                            $date = date("is");
                            $newname = md5($_FILES['mailfile']['name']+$date);
                        } while (file_exists($path.'/'.$newname.'.'.$expans));
                        if (move_uploaded_file($_FILES['mailfile']['tmp_name'], $path.'/'.$newname.'.'.$expans)){
                           $filestr = 'С письмом был загружен файл '."\n".'//'.$_SERVER['SERVER_NAME'].'/emailfiles/'.$newname.'.'.$expans;
                        }
                    }
                    require_once './config.inc.php';
                    require_once './include/engine_class.php';
                    require_once './include/db_class.php';
                    $z = new Engine();
                    $z->set_path_to_root('./');
                    $z->load_class('settings');
                    new Settings();
                    $mess = $_POST['message'];
                    if (!empty($filestr)){
                        $mess .= "\n\n".$filestr;
                    }
					if (empty($bezspama)) /* Оценка поля bezspama - должно быть пустым*/
{
                    $z->mail(array('review@editus.ru'), 'Отзыв от '.$_POST['name'].' книга '.$_POST['subject'], $mess, $_POST['email']);
                    $f = TRUE;
}
                }
            }
        }
        if ($f == false){
        ?>
        <h2 >Оставить отзыв</h2>
        
        <form method="post" enctype="multipart/form-data" action="contactmail.php">
            <label style="font-weight: bold;">Автор:<div class="form"><input type="text" name="name" value="<?php echo $_POST['name'];?>" /></div></label><br />
            <label style="font-weight: bold;">Email:<div class="form"><input type="text" name="email" value="<?php echo $_POST['email'];?>"/></div></label><br />
            <label style="font-weight: bold;">Книга:<div class="form"><input type="text" name="subject" value="<?php echo $_POST['subject'];?>" /></div></label><br />
            <label style="font-weight: bold;">Сообщение:<div class="form"><textarea name="message"><?php echo $_POST['message'];?></textarea></div></label><br />
            <input class="button" type="submit" value="Отправить" />
        </form>
        <?php }else{ ?>
        <h1>Спасибо за Ваш отзыв, Вы помогаете нам стать лучше!</h1><br /><br />
                <input class="button close" type="button" value="Закрыть" />

        <?php } ?>
    </body>
</html>


        <?php
        
        if (isset($_POST['name'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
                ?>
        <div class="dm-overlay2">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="<?=$_SERVER['PHP_SELF']?>" class="close"></a>
                <h3>Пожалуйста, заполните все поля</h3>
                <a href="#win1" class="button">Попытаться еще</a>
                
</div>
        </div>
    </div>
</div>
        <?php
            }else{
                if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email'])){
                    ?><div class="dm-overlay2">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="<?=$_SERVER['PHP_SELF']?>" class="close"></a>
                <h3>Некорректный email</h3>
                <a href="#win1" class="button">Попытаться еще</a>
</div>
        </div>
    </div>
</div>
<?php
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
                    $z->mail(array('zakaz@prepages.com'), 'Отзыв от '.$_POST['name'].' книга '.$_POST['subject'], $mess, $_POST['email']);
                    $f = TRUE;
}
                }
            }
        }
        if ($f == false){
        ?>
        <div class="dm-overlay" id="win1">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="#close" class="close"></a>
                <h3>Оставить отзыв</h3>
                <form method="post" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>">
            <div class="form"><label>Имя: </label><input type="text" name="name" value="<?php echo $_POST['name'];?>" /></div>
            <div class="form"><label >Email:</label> <input type="text" name="email" value="<?php echo $_POST['email'];?>"/></div>
            <div class="form"><label>Книга:</label><input type="text" name="subject" value="<?php echo $_POST['subject'];?>" /></div>
            <div class="form"><label>Сообщение:</label><div class="form"><textarea name="message"><?php echo $_POST['message'];?></textarea></div><br />
            <input type="submit" value="Отправить" />
        </form>
            </div>
        </div>
    </div>
</div>
        <?php }else{ ?>
        <div class="dm-overlay2">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="<?=$_SERVER['PHP_SELF']?>" class="close"></a>
                <h3>Спасибо, Вы делаете нашу работу лучше!</h3>
</div>
        </div>
    </div>
</div>
        <?php } ?>
        
   
<?php
require_once './../config.inc.php';
require_once '../include/db_class.php';
require_once '../include/lang/errors_lang.php';

if (isset($_POST['name']) && isset($_POST['recipients']) && isset($_POST['subject']) && isset($_POST['message'])){

    $Date = DateTime::createFromFormat('d.m.Y H:i:s', $_POST['send_date'] . ' 00:00:00', new DateTimeZone('UTC'));

    $errors = array(
        'name' => empty($_POST['name']),
        'recipients' => !filter_var($_POST['recipients'], FILTER_VALIDATE_EMAIL),
        'subject' => empty($_POST['subject']),
        'message' => empty($_POST['message']),
        'send_date' => $Date instanceof DateTime ? false : true
    );
    $res = true;
    foreach($errors as $val){
        $res = $res && !$val;
    }
    $send = false;
    if ($res) {
        $Db = new Db();

        $sql = "INSERT INTO `DeferredMailer` (`subj`, `body`, `sendDate`, `name`, `recipients`)
                VALUES ( '".$_POST['subject']."', '".$_POST['message']."', '".$Date->getTimestamp()."', '".$_POST['name']."', '".$_POST['recipients']."') ";
        $Db->query($sql);
        $send = true;
    }

}

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.css">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<?php if($send){ ?>
    <div>Message save</div>
<?php } ?>
    <form method="post" action="index.php">
        <div class="form-control<?php if ($errors['name']) echo ' error'; ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $_POST['name']; ?>">
        </div>
        <div class="form-control<?php if ($errors['recipients']) echo ' error'; ?>">
            <label>Recipients:</label>
            <input type="text" name="recipients" value="<?php echo $_POST['recipients']; ?>">
        </div>
        <div class="form-control<?php if ($errors['subject']) echo ' error'; ?>">
            <label>Subject:</label>
            <input type="text" name="subject" value="<?php echo $_POST['subject']; ?>">
        </div>
        <div class="form-control<?php if ($errors['message']) echo ' error'; ?>">
            <label>Message:</label>
            <textarea name="message" rows="5" cols="40"><?php echo $_POST['message']; ?></textarea>
        </div>
        <div class="form-control<?php if ($errors['send_date']) echo ' error'; ?>">
            <label>Send date:</label>
            <input class="date-picker" type="text" name="send_date" value="<?php echo $_POST['send_date']; ?>">
        </div>
        <div class="form-control">
            <input type="submit" value="send">
        </div>
    </form>
</body>
</html>
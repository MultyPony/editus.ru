<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="//www.w3.org/1999/xhtml"> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Эдитус. Издательство и печать</title>
        <meta name="keywords" content="издание книги печать верстка издательство напечатать" />
        <meta name="description" content="Издать или напечатать книгу." />
        <link rel="stylesheet" type="text/css" href="../css/styles_admin.css" media="all" /> 
        <link rel="shortcut icon" href="../img/favicon.ico" />
        <?php echo $headscripts; ?>
    </head>

    <body>
        <table style="width: 1000px;">
            <tr>
                <td align="right" valign="top" style="width: 115px;">
                    <a href="index.php"><img alt=""  src="../img/logo_admin.gif"  border="0" /></a>
                </td>
                <td style="padding-top: 50px; padding-left: 20px;">
                    <?php echo $adminmenu; ?>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding-left: 50px; min-width: 700px;">
                    <p id="content">
                        <?php echo $mess; ?>
                        <br />
                        <?php echo $content, $auth; ?>
                    </p>
                </td>
            </tr><!--
            <tr>
                <td valign="top"></td>
            </tr>
            <tr>
                <td width="280"></td>
                <td valign="bottom"><div id="copyright">© 2010. Сайт разработан компанией
                        &quot;Эдитус&quot;. Все права защищены.</div></td>
            </tr>-->
        </table>
    </body>
</html>
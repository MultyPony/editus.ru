<fieldset id="os4" style="min-height: 280px;">
    <legend class="orderstepname"><?php echo _OS4_ORDERSTEP4; ?></legend>
    <p style="text-align: center;"><?php echo _OS4_SELECTPAY;?></p>
    <div class="tooltip" id="tooltiprobo" style="display: none; position: absolute; top: 246.133px; left: 610.517px;">ROBOKASSA - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone.</div>
    <div class="tooltip" id="tooltipqiwi" style="display: none; position: absolute; top: 291.133px; left: 434.283px;">QIWI - Оплата через терминалы QIWI, интернет портал w.qiwi.ru, приложение для любых современных моделей мобильных телефонов «QIWI в мобильном».</div>
    <div class="tooltip" id="tooltipsber" style="display: none; position: absolute; top: 261.133px; left: 241.667px;">БАНК - Оплата по квитанции в любом банке, который принимает платежи от физических лиц, в т.ч. через интернет-банк. Обратите внимание, что платежи через Сбербанк поступят на наш расчетный счет не ранее чем через 3 рабочих дня.</div>
    <table style="width: 100%; margin-bottom: 30px;">
        <tr style="height: 79px;">
            <td><img src="img/sber.jpg" id="sberbimg" class="methpay" title="БАНК - Оплата по квитанции в любом банке, который принимает платежи от физических лиц, в т.ч. через интернет-банк. Обратите внимание, что платежи через Сбербанк поступят на наш расчетный счет не ранее чем через 3 рабочих дня." ></td>
            <td><img src="img/qiwi.jpg" id="qiwiimg" class="methpay" title="QIWI - Оплата через терминалы QIWI, интернет портал w.qiwi.ru, приложение для любых современных моделей мобильных телефонов «QIWI в мобильном»." ></td>
            <td><img src="img/robokassa.jpg" id="robokassaimg" class="methpay" title="ROBOKASSA - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone." ></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="3"><img src="img/avangard.png" id="avangard-visa-mastercard-img" class="methpay" title="Visa/MasterCard." ></td>
        </tr>

    </table>
    
    <div id="sverb" style="text-align: center; display: none;" class="meth">
        <a href="<?php echo $hrefkvit; ?>"><?php echo _OS4_DOWNLOADBILL; ?></a><br><br><br>
        <a href="<?php echo $hrefkvit2; ?>"><?php echo _OS4_DOWNLOADBILL2; ?></a>
    </div>
    <div id="qiwi" style="text-align: center; display: none;" class="meth">
        <?php if ($qiwi==6){?>
        <form action="<?php echo $action;?>" method="post">
            <input type="hidden" name="qiwi" />
            <input type="hidden" name="newqiwi" />
            <label><?php echo _OS4_TYPEPHONE; ?><input name="qiwiphone" type="text" maxlength="10" style="width: 100px;" /></label>
            <br><br><input class="button" type="submit" value="<?php echo _OS4_CHECKOUT; ?>"/>
        </form>
        <?php }else if ($qiwi==1){
                    echo _OS4_NOTQIWI;
              }else if ($qiwi==3){ ?>
                <p><?php echo _OS4_TEXTQIWI1;?></p>
                <input type="hidden" name="orderid" id="os4_orderid" value="<?php echo $_GET['o'];?>" />

        <?php }else if ($qiwi==4 || $qiwi==2){ ?>
                <input type="hidden" name="orderid" id="os4_orderid" value="<?php echo $_GET['o'];?>" />
                <label><?php echo _OS4_TYPEPHONE; ?><input name="qiwiphone" id="os4_qiwiphone" type="text" maxlength="10" style="width: 100px;" /></label>
                <br><br><input class="button" type="button" id="os4_send" value="<?php echo _OS4_CHECKOUT; ?>"/>
        <?php } ?>
    </div>    
    <div id="robokassa" style="text-align: center; display: none;" class="meth">
        <?php echo $robokassa;?>
    </div>
    <div id="avangard-visa-mastercard" style="text-align: center; display: none;" class="meth">
        <?php
            echo '<a target="_blank" href="//<?php echo $_SERVER['SERVER_NAME'];?>/bill/cardpay/redirect.php?o=' . $_GET['o'] . '&type=pub" >Перейти к оплате</a>';
        ?>
    </div>
<div style="text-align: center; margin-top: 50px;">
<a href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/credit.html" class="head" target="_blank"><span>или узнайте как напечатать книгу в кредит &rarr;</span></a>

</div>
</fieldset>
<!-- Google Code for order Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 949028215;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "rMILCLGR9wcQ94rExAM";
var google_conversion_value = 0;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/949028215/?value=0&amp;label=rMILCLGR9wcQ94rExAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
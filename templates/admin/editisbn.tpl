<h2 id="editisbn"><?php echo _EISBN_TITLE;?></h2>
    <p style="margin: 0;"><span style="border-bottom: 1px solid #000;">
        <input type="hidden" id="activetab" value="<?php echo $activtab;?>"/>
        <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="freenum" class="but" value="<?php echo _EISBN_FREENUM;?>" />
        <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="usednotpaynum" class="but" value="<?php echo _EISBN_USEDNOTPAYNUM;?>"/>
        <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="usednum" class="but" value="<?php echo _EISBN_USEDNUM;?>" />
        </span>
    </p>
    <div id="freenum-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
        <table class="dataview">
            <thead><tr><td><?php echo _EISBN_NUM; ?></td><td><?php echo _EISBN_ADDDATE; ?></td><td></td></tr></thead>
            <tbody>
                <?php foreach ($isbnsfree as $cur) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $cur['isbn'] ?>
                            </td>
                            <td>
                                <?php echo date("H:i d.m.Y", strtotime($cur['isbnAddDate']));?>
                            </td>
                            <td>
                                <form action="<?php echo $action; ?>" method="post">
                                    <input name="isbndel" type="hidden" value="<?php echo $cur['isbn']; ?>" />
                                    <input type="submit" value="<?php echo _EISBN_DEL; ?>" />
                                </form>
                            </td>
                        </tr>
        <?php } ?>
            </tbody>
        </table>
        <form method="post" action="<?php echo $action; ?>" >
            <table><tbody>
                    <tr>
                        <td>
                            <input name="newisbn" style="width: 300px;" type="text" />
                        </td>
                        <td>
                            <input type="submit" value="<?php echo _EISBN_ADD; ?>"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div  id="usednotpaynum-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
        <table class="dataview">
            <thead><tr><td><?php echo _EISBN_NUM; ?></td><td><?php echo _EISBN_ORDERID; ?></td><td><?php echo _EISBN_FREEZEDATE; ?></td><td></td></tr></thead>
            <tbody>
                <?php foreach ($isbnnotpayused as $cur) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $cur['isbn'] ?>
                            </td>
                            <td>
                                <?php echo $cur['orderId'] ?>
                            </td>
                            <td>
                                <?php echo date("H:i d.m.Y", strtotime($cur['orderDate']));?>
                            </td>
                            <td>    
                                <form action="<?php echo $action; ?>" method="post">
                                    <input name="isbnfree" type="hidden" value="<?php echo $cur['isbn']; ?>" />
                                    <input type="submit" value="<?php echo _EISBN_GETFREE; ?>" />
                                </form>
                                <form action="<?php echo $action; ?>" method="post">
                                    <input name="isbnpay" type="hidden" value="<?php echo $cur['isbn']; ?>" />
                                    <input type="submit" value="<?php echo _EISBN_ITSPAY; ?>" />
                                </form>
                            </td>
                        </tr>
        <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="usednum-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
        <table class="dataview">
            <thead><tr><td><?php echo _EISBN_NUM; ?></td><td><?php echo _EISBN_ORDERID; ?></td><td><?php echo _EISBN_FREEZEDATE; ?></td></tr></thead>
            <tbody>
                <?php foreach ($isbnused as $cur) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $cur['isbn'] ?>
                            </td>
                            <td>
                                <?php echo $cur['orderId'] ?>
                            </td>
                            <td>
                                <?php echo date("H:i d.m.Y", strtotime($cur['orderDate']));?>
                            </td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php echo $pages;?>
    </div>

<h2><?php echo _OWU_TITLE; ?></h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _OWU_NUM; ?></td>
            <td><?php echo _OWU_DATE; ?></td>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
                <td>' . $cur['orderId'] .'</td>
                <td>' . date("d.m.Y", strtotime($cur['orderDate'])). '</td>
            </tr>';
    }
    ?>
</table>
<form action="index.php?do=orderswaitupload" method="post">
    <input type="hidden" value="1" name="uplcur" />
    <input type="submit" value="<?php echo _OWU_UPLOAD; ?>"/>
</form>
<h2><?php echo _SOWU_TITLE; ?></h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _SOWU_NUM; ?></td>
            <td><?php echo _SOWU_DATE; ?></td>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
                <td>K' . $cur['orderId'] .'</td>
                <td>' . date("d.m.Y", strtotime($cur['orderDate'])). '</td>
            </tr>';
    }
    ?>
</table>
<form action="index.php?do=shoporderswaitupload" method="post">
    <input type="hidden" value="1" name="uplcur" />
    <input type="submit" value="<?php echo _SOWU_UPLOAD; ?>"/>
</form>
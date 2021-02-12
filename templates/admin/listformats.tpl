<h2>Форматы</h2>
<table>
    <thead>
        <tr>
            <td><?php echo _FORMATNAME ?></td>
            <td><?php echo _FORMATWIDTH ?></td>
            <td><?php echo _FORMATHEIGHT ?></td>

            <td><?php echo _FORMATINA3 ?></td>
            
        </tr>
    </thead>
    <?php
    foreach ($data as $cur)
        echo '
            <tr>
            <td>' . $cur[0] .'</td>
            <td>' . $cur[1] . '</td>
            <td>' . $cur[2] . '</td>
            <td>' . $cur[3] . '</td>
            <td> ' . $cur[4] . '</td>
            </tr>';
    echo '
        <tr>
        <td><input type="text"></input></td>
        <td><input type="text"></input></td>
        <td><input type="text"></input></td>
        <td><input type="text"></input></td>
        </tr>';
    ?>

</table>
<input type="button" value="Add"></input>
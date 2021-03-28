<?php
    // require_once '/xampp/htdocs/editus/cdek/scripts/service.php';
    require_once dirname(__FILE__) . '/cdek/scripts/service.php';

    // $data = array();
    // $data['shipment'] = array();
    // $data['shipment']['cityToId'] = '506';
    // $data['shipment']['cityFromId'] = '44';
    // $data['shipment']['type'] = 'pickup';
    // $data['shipment']['goods'] = array(
    //     array('weight' => 0.4,
    //     'length' => 25,
    //     'width'  => 17,
    //     'height' => 7
    //     )
    // );

    $data = array();
    $data['shipment'] = array(
        'cityToId' => '506',
        'cityFromId' => '44',
        'type' => 'pickup',
        'goods' => array(
            array('weight' => 0.4,
            'length' => 25,
            'width'  => 17,
            'height' => 7
            )
        ),
    );
    

    // $data['shipment']['ref'] = 'NSK41';
    // $data['shipment']['cityTo'] = 'Прокопьевск';

    $res = ISDEKservice::calc($data, false);
    // $res2 = json_decode($res, true);
    // $res3 = $res2['result']['price'];
    echo $res['result']['price'];
?>
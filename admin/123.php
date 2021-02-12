<!--<form action="" method="post">
  Golosov dobavit': <input type="text" name="gl" value="5" />
    <input type="submit" value="dobavit'"/>
</form>-->
<?php
function get_random_user_agent()
{
     $uas = array(
       'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98)',
       'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0; .NET CLR 1.0.3705)',
       'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Maxthon)',
       'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; bgft)',
       'Mozilla/4.5b1 [en] (X11; I; Linux 2.0.35 i586)',
       'Mozilla/5.0 (compatible; Konqueror/2.2.2; Linux 2.4.14-xfs; X11; i686)',
       'Mozilla/5.0 (Macintosh; U; PPC; en-US; rv:0.9.2) Gecko/20010726 Netscape6/6.1',
       'Mozilla/5.0 (Windows; U; Win98; en-US; rv:0.9.2) Gecko/20010726 Netscape6/6.1',
       'Mozilla/5.0 (X11; U; Linux 2.4.2-2 i586; en-US; m18) Gecko/20010131 Netscape6/6.01',
       'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:0.9.3) Gecko/20010801',
       'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.7) Gecko/20060909 Firefox/1.5.0.7',
       'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.6) Gecko/20040413 Epiphany/1.2.1',
       'Mozilla/5.0 (Linux; U; Android 1.6; en-us; eeepc Build/Donut) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
       'Mozilla/5.0 (Linux; U; Android 2.1-update1; ru-ru; GT-I9000 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
       'Mozilla/5.0 (Linux; U; Android 2.2; ru-ru; GT-I9000 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
       'Mozilla/5.0 (Windows NT 6.1; rv:2.0) Gecko/20100101 Firefox/4.0',
       'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.205 Safari/534.16) ',
       'Opera/9.0 (Windows NT 5.1; U; en)',
       'Opera/8.51 (Windows NT 5.1; U; en)',
       'Opera/7.21 (Windows NT 5.1; U)',
       'Opera/9.80 (Windows NT 6.1; U; ru) Presto/2.8.131 Version/11.10',
       'Opera/9.80 (S60; SymbOS; Opera Mobi/499; U; ru) Presto/2.4.18 Version/10.00',
       'Mozilla/4.0 (compatible; MSIE 6.0; Symbian OS; Nokia 6600/5.27.0; 9424) Opera 8.65 [ru]',
       'Mozilla/5.0 (PLAYSTATION 3; 1.00)',
       'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-us) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
       'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT)',
       'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
       'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.0.6) Gecko/20060928 Firefox/1.5.0.6',
       'Opera/9.02 (Windows NT 5.1; U; en)',
       'Opera/8.54 (Windows NT 5.1; U; en)'
     );
 
     return $uas[rand(0, count($uas)-1)];
}

//if (isset($_POST['gl'])){
//    for ($i=0;$i<3;$i++){
//    
        //инициализируем сеанс
        while(true){
        $curl = curl_init();
        //уcтанавливаем урл, к которому обратимся
        curl_setopt($curl, CURLOPT_URL, 
        'http://missmo.ru/20102.php');
        //включаем вывод заголовков
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //передаем данные по методу post
        curl_setopt($curl, CURLOPT_POST, 1);
        //теперь curl вернет нам ответ, а не выведет
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        /*переменные, которые будут переданные по методу post
        Перед именем файла ставится @
        */
        curl_setopt($curl, CURLOPT_POSTFIELDS, array( 'gl'=>urlencode(6) ));
        //я не скрипт, я браузер опера
        curl_setopt($curl, CURLOPT_USERAGENT, get_random_user_agent());
        $res = curl_exec($curl);
        //проверяем, если ошибка, то получаем номер и сообщение
        if(!$res){
        $error = curl_error($curl).'('.curl_errno($curl).')';
        echo $error;
        }
        //если не ошибка, то выводим результат
        else{
        //echo $res;
//           echo 'Dobavlen golos: '.($i+1).'...<br>';

        }
        curl_close($curl);
//        echo 'Zadergka 4 sek...<br>';
        sleep(2);
    }
//}
?>
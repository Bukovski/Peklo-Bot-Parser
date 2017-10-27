<?php
//sudo gedit /etc/crontab
//*/5 * * * * alessa /usr/bin/wget -t 1 -O - 'http://testsite.dev/phpQuery-parser/pekloBotGit/startWrap.php';
//service cron restart

$uidCreateNew = 8304102; //Тут вашь ID 9304105
$auth_keyCreateNew = '48cb111688ca8ee9eccc20432e762e72'; //Тут ваш ключь от игры в виде строки '50cb122688ca8ee1eccc28437e762e72'

function authPeklo($uid = null, $auth_key = null) {
    $url = 'http://game-r02vk.rjgplay.com/auth/';

    if (!($uid && $auth_key)) {
        return 'Пустой uid или auth_key в authPeklo';
    }

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //обрыв если зависло
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '<auth uid="'.$uid.'" auth_key="'.$auth_key.'"/>');

    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2914.3 Safari/537.36 OPR/43.0.2431.0 (Edition developer)'); //эмитация браузера
    curl_setopt ($ch , CURLOPT_RETURNTRANSFER , true); //нам нужно вывести загруженную страницу в переменную

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //отключает проверки сайта (Используйте 1 для проверки существования общего имени в сертификате SSL. Используйте 2 для проверки существования общего имени и также его совпадения с указанным хостом. В боевом окружении значение этого параметра должно быть 2 )
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //отключает проверки сайта (проверки сертификата узла сети)

    $html = curl_exec($ch); //сохраняем результаты запроса
    curl_close($ch); //закрыли дескриптор

    return $html;
}

function collectContract($dataUser = null, $contractsId = null) { //сбор боеприпасов с производства
    return request(
        '<collect_contract'.$dataUser.'>
          <id>' . $contractsId . '</id>
        </collect_contract>'
    );
}

function decodeXMLtoArr($items){
    $xmlAll = simplexml_load_string($items); //из XML в обьект
    $jsonXML = json_decode(json_encode($xmlAll), 1); //из обьекта в массив
    return $jsonXML;
}

function executeAction($dataUser = null, $type = null) {
    return request(
        '<execute_action' . $dataUser . '>
          <type>'.$type.'_on_submit</type>
        </execute_action>'
    );
}

function request($postdata = null){
    $url = 'http://game-r02vk.rjgplay.com/command/';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //обрыв если зависло
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch , CURLOPT_RETURNTRANSFER , true); //нам нужно вывести загруженную страницу в переменную

    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2914.3 Safari/537.36 OPR/43.0.2431.0 (Edition developer)'); //эмитация браузера

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //отключает проверки сайта (Используйте 1 для проверки существования общего имени в сертификате SSL. Используйте 2 для проверки существования общего имени и также его совпадения с указанным хостом. В боевом окружении значение этого параметра должно быть 2 )
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //отключает проверки сайта (проверки сертификата узла сети)

    if($postdata){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); //принимает POST данные(обязательный параметр для приема данных)
    }
    $html = curl_exec($ch); //сохраняем результаты запроса
    curl_close($ch); //закрыли дескриптор
    return $html; //вернули результаты для дальнейших действий (вывода, обработки)
}

function sidArrExplode ($arr) { //выдираем из массива хеш авторизации и превращаем его в строку
    preg_match('~<sid>(.*?)</sid>~ims', $arr, $gameArr);
    unset($gameArr[0]);
    return implode("", $gameArr);
}

function sortArrKeys ($arr){ //сортируем массив по ключу и делаем его нумерованым из ассоциативного
    $deleteEmpty = array_diff($arr, array('')); //удаляем пустые эллементы из массива
    asort($deleteEmpty); //сортируем массив по значению, по количеству боеприпасов на складе
    $numericArr = array_keys($deleteEmpty); //из асоциативного массива делаем нумерованный
    return $numericArr;
}

function startContract($dataUser = null, $type = null, $buildingId = null){ //запрос на производство беоприпасов
    return request(
        '<start_contract'.$dataUser.'>
          <type>produce_'.$type.'</type>
          <building_id>'.$buildingId.'</building_id>
        </start_contract>'
    );
}

function startResources($dataUser = null, $type = null, $buildingId = null, $timer = 2){ //запрос на производство беоприпасов
    //$timer = $timer;  //$timer число в этом поле указывает время производства 1-10мин 2-1час 3-6часов 4-12часов
    if(date('H:i') >= '20:00') { //если время сейчас 22 часа или больше то ставим сбор ресурсов на 12 часов
        $timer = 4;
    }
    return request(
        '<start_contract'.$dataUser.'>
          <type>'.$type.'_'.$timer.'</type>
          <building_id>'.$buildingId.'</building_id>
        </start_contract>'
    );
}

function startResourcesTech($dataUser = null, $type = null, $buildingId = null, $timer = 2){ //запрос на удвоеное производство беоприпасов при наличии технологии Слейв-Эри
    if(date('H:i') >= '20:00') { //если время сейчас 22 часа или больше то ставим сбор ресурсов на 12 часов
        $timer = 4;
    }
    return request(
        '<start_contract'.$dataUser.'>
          <type>'.$type.'_'.$timer.'_tech</type>
          <building_id>'.$buildingId.'</building_id>
        </start_contract>'
    );
}

function sendMap($dataUser = null, $type = null, $userId = null) { //отправка чертежей по ссылке
    return request(
        '<interact'.$dataUser.'>
            <uid>'.$userId.'</uid>
            <type>'.$type.'</type>
        </interact>'
    );
}

//Создать БД peklo а затем запускать бот. Он сам создась таблицу с параметрами
//Ctrl+Shift+Enter
$db=mysqli_connect("localhost","root", "root", "peklo");
mysqli_query("SET NAMES utf8");//Кодировка
$sql = mysqli_query($db, "SELECT * FROM `pekloGame`") or mysqli_query($db, "CREATE TABLE `pekloGame` (`ammunition` tinyint(1) NOT NULL,
  `collectionResources` tinyint(1) NOT NULL,`resourceCreate` tinyint(1) NOT NULL,
  `shopAssassin` tinyint(1) NOT NULL,`spaceExpedition` tinyint(1) NOT NULL,
  `start` tinyint(1) NOT NULL,`corditLimit` int(11) NOT NULL,
  `cristalLimit` int(11) NOT NULL,`uid` int(11) NOT NULL,
  `auth_key` varchar(40) NOT NULL,`id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") && mysqli_query($db, "INSERT INTO `pekloGame` (`ammunition`, `collectionResources`, `resourceCreate`, `shopAssassin`, `spaceExpedition`, `start`, `corditLimit`, `cristalLimit`, `uid`, `auth_key`, `id`) VALUES
(1, 1, 1, 1, 0, 1, 2000, 55000, ". $uidCreateNew .", '". $auth_keyCreateNew ."', 1)");
$result = mysqli_fetch_array($sql);

$ammunition = $result['ammunition']; //запуск производства БП
$collectionResources = $result['collectionResources']; //запуск сбора с колонистов
$resourceCreate = $result['resourceCreate']; //запуск сбора с шахт ресурсов
$shopAssassin = $result['shopAssassin']; //покупка наемников
$spaceExpedition = $result['spaceExpedition']; //экспедиции в космос
$start = $result['start']; //запуск выполнения парсера

$corditLimit = $result['corditLimit']; //предел расхода кордита на БП
$cristalLimit = $result['cristalLimit']; //предел кристалов на БП
$uid = $result['uid']; 
$auth_key = $result['auth_key'];


$sendMaps = $_POST['sendMaps']; //отправка чертежей

if (isset($_POST['startBot'])){
    echo 'Button';
    $ammunition = ($_POST['ammunition']) ? 1 : 0;
    $collectionResources = ($_POST['collectionResources']) ? 1 : 0;
    $resourceCreate = ($_POST['resourceCreate']) ? 1 : 0;
    $shopAssassin = ($_POST['shopAssassin']) ? 1 : 0;
    $spaceExpedition = ($_POST['spaceExpedition']) ? 1 : 0;
    $start = ($_POST['start']) ? 1 : 0;

    $corditLimit = addslashes(htmlspecialchars($_POST['corditLimit'])); //предел расхода кордита на БП
    $cristalLimit = addslashes(htmlspecialchars($_POST['cristalLimit'])); //предел кристалов на БП

    $uid = $uidCreateNew;
    $auth_key = $auth_keyCreateNew;

    mysqli_query($db, "UPDATE `pekloGame` SET `ammunition` = '".$ammunition."',`collectionResources` = '".$collectionResources."',`resourceCreate` = '".$resourceCreate."',`shopAssassin` = '".$shopAssassin."',`spaceExpedition` = '".$spaceExpedition."',`start` = '".$start."',`corditLimit` = '".$corditLimit."',`cristalLimit` = '".$cristalLimit."'WHERE `id` = 1");
    if (!$sendMaps) {
        header('location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); //обнуляем POST данные от повторной отпраки
    }
}

if ($start) {
    $start = microtime(true); //начало замера времени выполнения скрипта

    $sidGameArr = authPeklo($uid, $auth_key); //авторизируемся
    $sidGame = sidArrExplode($sidGameArr); //получаем хэш авторизации для подставки его в запросы

    if (strlen($sidGame) === 32) { //Авторизовался
        $dataUser = ' uid="'.$uid.'" auth_key="'.$auth_key.'" sid="'.$sidGame.'"'; //упрощенная системма вставки в форму
        $items = request('<get_game_info'.$dataUser.'/>'); //вся информация о колонии и ресурсах
        //xprint($items); //вся информация об игре

        request('<update'.$dataUser.'/>'); //обновление информации об игре
        //request('<get_auction_info'.$dataUser.'/>');
        $jsonXML = decodeXMLtoArr($items);
        $userUser = $jsonXML['init_game']['user'];
        $userItems = $userUser['items'];
        $userTimer = $userUser['timings']['timer'];
        $userLastEnter = $userUser['last_enter']['@attributes']['time'];
        $userContracts = $userUser['contracts']['contract']; //производтство на заводах, нужен ID от них
        $userBuildings = $userUser['buildings']['building'];
        $timeAssassin = htmlentities(file_get_contents("timeAssassin.txt")); //чтение файла с временем сбора наемников

        foreach ($userBuildings as $buildings) { //получаем номер и название зданий
            $buildingsAll = $buildings['@attributes'];
            $build [$buildingsAll['id']] = $buildingsAll['type']; //создаем асоц массив [10]=>'factory', [160]=>'space_engineering'
            $buildLvl [$buildingsAll['id']] = $buildingsAll['level']; //массив с уровнем зданий которые подставляем в производство ресурсов
        }

        foreach ($userTimer as $timer) {
            $timeGather[] = $timer['@attributes']['type'];
        }
        sort($timeGather); //сортируем по ключу по буквам массив
        $itemsTimer = array_flip($timeGather); //меняем местами ключ и значение

        if ($ammunition) { //сбор БП с колонии и космоса
            //массив боеприпасов на земле и в космосе
            $ammo = ['air_strike'=>$userItems['air_strike'], 'medicaments'=>$userItems['medicaments'],
                'gravibomb'=>$userItems['gravibomb'], 'shields'=>$userItems['shields']];
            $ammoSpace = ['repair_drones'=>$userItems['repair_drones'], 'space_mines'=>$userItems['space_mines'],
                'adaptive_shield'=>$userItems['adaptive_shield'], 'ecm'=>$userItems['ecm']];

            //определеляем лимит ресурсов для производства БП
            $corditMax = $userItems['cordite'] >= $corditLimit;
            $cristalMax = $userItems['crystal'] >= $cristalLimit;

            if (!$corditMax) { //если лимит достигнут
                unset($ammo['gravibomb']); //удаляем из массива все чему нужен кордит
                unset($ammo['shields']);
            }

            foreach ($userContracts as $contracts) { //производство БП в космосе и на земле
                $contractsAll = $contracts['@attributes'];
                if ($corditMax && array_search('space_engineering', $build)) { //если лимит кордита не достигнут
                    collectContract($dataUser, $contractsAll['id']); //сбор БП
                    startContract($dataUser, sortArrKeys($ammoSpace)[0], array_search('space_engineering', $build)); //заказ БП
                }
                if ($cristalMax && array_search('factory', $build)) { //если лимит кристалов не достигнут
                    collectContract($dataUser, $contractsAll['id']); //сбор БП
                    startContract($dataUser, sortArrKeys($ammo)[0], array_search('factory', $build)); //заказ БП
                }
            }
        }

        if ($resourceCreate) {
            //сбор с производства шахт - ресурсов
            foreach ($userContracts as $contracts) {
                $contractsAll = $contracts['@attributes'];
                $zeroContract [$contractsAll['building_id']] = $contractsAll['production_timing_id']; //номер здания => таймер
                $collectContract [$contractsAll['building_id']] = $contractsAll['id']; //номер здания => номер контракта
            }
            if ($zeroContract[array_search('plant_metal', $build)] == (0 || null)) {
                collectContract($dataUser, $collectContract[array_search('plant_metal', $build)]);
                startResourcesTech($dataUser, 'produce_metal_'.$buildLvl[array_search('plant_metal', $build)],  array_search('plant_metal', $build), ($userItems['metal'] >= 4000) ? 4 : 2);
            }
            if ($zeroContract[array_search('plant_crystal', $build)] == (0 || null)) {
                collectContract($dataUser, $collectContract[array_search('plant_crystal', $build)]);
                startResources($dataUser, 'produce_crystal_'.$buildLvl[array_search('plant_crystal', $build)],  array_search('plant_crystal', $build), ($userItems['crystal'] >= 3500) ? 4 : 2);
            }
            if ($zeroContract[array_search('plant_fuel', $build)] == (0 || null)) {
                collectContract($dataUser, $collectContract[array_search('plant_fuel', $build)]);
                startResources($dataUser, 'produce_fuel_'.$buildLvl[array_search('plant_fuel', $build)],  array_search('plant_fuel', $build), ($userItems['fuel'] >= 2300) ? 4 : 2);
            }
            if(array_search('space_mine_platform', $build)) { //если платформы кордита существуют
                if ($zeroContract[array_search('space_mine_platform', $build)] == (0 || null)) {
                    collectContract($dataUser,$collectContract[array_search('space_mine_platform', $build)]);
                    startResources($dataUser,'produce_cordite_' . $buildLvl[array_search('space_mine_platform', $build)],array_search('space_mine_platform', $build), ($userItems['cordite'] >= 9200) ? 4 : 2);
                }
                if ($zeroContract[array_search('space_mine_platform_2', $build)] == (0 || null)) {
                    collectContract($dataUser,$collectContract[array_search('space_mine_platform_2', $build)]);
                    startResources($dataUser,'produce_cordite_second_' . $buildLvl[array_search('space_mine_platform_2', $build)],array_search('space_mine_platform_2', $build), ($userItems['cordite'] >= 9200) ? 4 : 2);
                }
            }
        }

        if ($spaceExpedition) {
            foreach ($userItems as $vall => $key) { //сбор с экспедиций в космосе
                if (preg_match('~star_(.*?)_activeted~ims', $vall)) { //если найдена не активированная экспедиция
                    executeAction($dataUser, substr($vall, 0, -10) . '_starter_quest');
                }
            }
        }


        if ($collectionResources) {
            $allCollect = [
                'colonist_female_1_1', 'colonist_female_1_2', 'colonist_female_1_3', 'colonist_female_1_4', 'colonist_female_1_5',
                'colonist_female_2_1', 'colonist_female_2_2', 'colonist_female_2_3', 'colonist_female_2_4', 'colonist_female_2_5',
                'colonist_female_3_1', 'colonist_female_3_2', 'colonist_female_3_3', 'colonist_female_3_4', 'colonist_female_3_5',
                'colonist_male_1_1', 'colonist_male_1_2', 'colonist_male_1_3', 'colonist_male_1_4', 'colonist_male_1_5',
                'colonist_male_2_1', 'colonist_male_2_2', 'colonist_male_2_3', 'colonist_male_2_4', 'colonist_male_2_5',
                'colonist_male_3_1', 'colonist_male_3_2', 'colonist_male_3_3', 'colonist_male_3_4', 'colonist_male_3_5',
                'citizen_luckycaptain_1',
                'officer_1_1', 'officer_1_2', 'officer_1_3',
                'officer_2_1', 'officer_2_2', 'officer_2_3',
                'xenobiologist_1_1','xenobiologist_2_1', 'xenobiologist_3_1','xenobiologist_4_1',
                'offer_tax_robo_1_1', 'offer_tax_robo_2_1', 'offer_tax_robo_3_1',
                'robo_officer_1', 'robot_loader_1', 'citizen_robot_war_1', 'citizen_robot_war_2_1',
                'scarlett_ney_citizen_1', 'eric_claymore_citizen_double_1', 'pig_1',
                'scientist_1_1', 'scientist_2_1', 'scientist_3_1', 'scientist_4_1',
                'tax_robo_2_1', 'tax_robo_2_2',
                'trash_robo_1_1', 'trash_robo_1_2', 'trash_robo_1_3',
                'trash_robo_2_1', 'trash_robo_2_2', 'trash_robo_2_3',
                'trash_robo_3_1', 'trash_robo_3_2', 'trash_robo_3_3'
            ]; //запросы для сбора с колонистов
            $allGroupGift = [
                'group_gift_friday', 'group_gift_monday', 'group_gift_saturday', 'group_gift_sunday', 'group_gift_thursday', 'group_gift_tuesday', 'group_gift_wednesday'
            ]; //запросы сбора подарков с офф группы
            $rjGift = [
                "space_scheme","space_expendable","credit","space_recruits","ground_expendable","cordite","merc_lite", "merc_lite_5","merc_heavy","merc_heavy_5"
            ]; //сбор подарков с RJ
            sort($allCollect);
            sort($allGroupGift);
            sort($rjGift);

            foreach ($allCollect as $key => $vall) {
                if (!$itemsTimer[$vall . '_produce_timing'] && $userItems[$vall]) { //если нет такого таймера но есть значение в items то собрать ресурсы с колонистов
                    executeAction($dataUser, $vall.'_producer');
                }
            }

            foreach ($allGroupGift as $key => $vall) {
                if (!$itemsTimer[$vall . '_timer']) {
                    executeAction($dataUser, $vall); //подарок из группы ежедневный
                    foreach ($rjGift as $rj) {
                        if (!$itemsTimer['rj_play_gift_' . $rj . '_timer']) {
                            executeAction($dataUser, 'rj_play_gift_' . $rj);
                        }
                    }
                }
                if (!$itemsTimer['citizen_thief_1_produce_timing']) { //сбор с воровки если таймер вышел
                    executeAction($dataUser, 'citizen_thief_1_producer'); //сбор с воровки
                    executeAction($dataUser, 'thief_thing_randomizer'); //рандомный выбор доп подарка от воровки
                    executeAction($dataUser, 'thief_sharing_reward_'.(1+$key)); //забираем подарок 1+ чтобы цикл начался не с 0, а с 1 до 7
                    executeAction($dataUser, 'thief_sharing_reward_'.(1+$key).'_sharing_quest'); //типа рассказал друзьям о подарке
                }
                if (!$itemsTimer['space_pvp_daily_4_quest_timing']) { //космические бои, сбор и зщапуск квеста
                    executeAction($dataUser, 'space_pvp_daily_4_starter');
                    executeAction($dataUser, 'space_pvp_daily_4');
                    executeAction($dataUser, 'space_pvp_daily_reset');
                }
            }

            if ($itemsTimer['taxes_production_timing']) {//сбор кредитов с базы
                executeAction($dataUser, 'tax1_quest');
                executeAction($dataUser, 'tax2_quest');
                executeAction($dataUser, 'tax3_quest');
                executeAction($dataUser, 'tax4_quest');
                executeAction($dataUser, 'tax5_quest');
                executeAction($dataUser, 'tax6_quest');
                executeAction($dataUser, 'tax7_quest');
                executeAction($dataUser, 'tax8_quest');
                executeAction($dataUser, 'tax9_quest');
            }
        }

        if ($shopAssassin && array_search('mercenary_camp', $build) &&
            (!$itemsTimer['mercenary_camp_global_timing'] || !$userItems['mercenary_camp_pack_1_purchased'])) { //если таймер наемников отсутствует и ни один наемник не куплен
            executeAction($dataUser, 'mercenary_camp_reset'); //обновление наемников для покупки

            executeAction($dataUser, 'mercenary_camp_pack_1_item_7_buy'); //++ 5
            executeAction($dataUser, 'mercenary_camp_pack_1_item_8_buy'); //++ 53

            executeAction($dataUser, 'mercenary_camp_pack_3_item_7_buy'); //+  37
            executeAction($dataUser, 'mercenary_camp_pack_3_item_8_buy'); //+++ 63

            executeAction($dataUser, 'mercenary_camp_pack_5_item_9_buy'); //+++ 24
            executeAction($dataUser, 'mercenary_camp_pack_5_item_10_buy'); //+  61

            executeAction($dataUser, 'mercenary_camp_pack_6_item_7_buy'); //+   3 38
            executeAction($dataUser, 'mercenary_camp_pack_6_item_8_buy'); //+++

            executeAction($dataUser, 'mercenary_camp_pack_7_item_7_buy'); //++
            executeAction($dataUser, 'mercenary_camp_pack_7_item_8_buy'); //++  67

            executeAction($dataUser, 'mercenary_camp_pack_9_item_10_buy'); //++
            executeAction($dataUser, 'mercenary_camp_pack_9_item_11_buy'); //++ 90 88

            executeAction($dataUser, 'mercenary_camp_pack_12_item_7_buy'); //++++ 12
            executeAction($dataUser, 'mercenary_camp_pack_12_item_8_buy'); //     53

            executeAction($dataUser, 'mercenary_camp_pack_14_item_9_buy'); //
            executeAction($dataUser, 'mercenary_camp_pack_14_item_10_buy'); //     49
        }

        if ($sendMaps) {
            if (preg_match("~request_key=interaction~is", $sendMaps) != 'interaction') {
                preg_match("~interaction%3A(.*?)-in_~Uis", $sendMaps, $sendMapsType);
                preg_match("~app3558212_(.*?)\?~Uis", $sendMaps, $sendMapsIdUser);
            } else {
                preg_match("~interaction%3A(.*?)~Uis", $sendMaps, $sendMapsType);
                preg_match("~app3558212_(.*?)\?~Uis", $sendMaps, $sendMapsIdUser);
            }
            //sendMap($dataUser, $sendMapsType[1], $sendMapsIdUser[1]);
            $find200 = sendMap($dataUser, $sendMapsType[1], $sendMapsIdUser[1]);
            if (preg_match("~200~Uis", $find200)) {
                $btnColor = 'btn-danger';
            } else {
                $btnColor = 'btn-success';
            }
        }
    }
    $timeWorkScript = microtime(true) - $start;
}
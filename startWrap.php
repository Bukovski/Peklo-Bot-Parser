<?php include_once './parser.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/gif" href="files/ea0e997x.gif">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="lib/bootstrap.min.css">
    <link rel="stylesheet" href="lib/bootstrap-theme.min.css">
    <link rel="stylesheet" href="font/comfortaa.css">
    <title>Бот Пекло</title>
</head>
<style>
    body {
        background-color: black !important;
        font-family: 'Comfortaa', cursive;
    }
    body span {
        font-family: 'Arial';
    }

    #c {
        opacity:.8;
        z-index: 1;
    }
    canvas {
        position: fixed;
        top:0;
        left:0;
    }
    #main-block {
        z-index: 2;
    }

    .list-group-item {
        background-color: #DFE2DB !important;
    }

    .progress_width{
        width: 73%;
        height: 16px;
        margin: 0 auto;
        border: 1px solid #000;
        border-radius: 10px;
        text-align:  center;
        background-color: #919191;
        display: inline-block;
        float:right;
    }
    .progressBar{
        width: 0;
        height: 14px;
        border-radius: 10px;
    }
    .progressItem {
        color: white;
        position: absolute;
        margin: -2px 0 0 22%;
    }

    #buttonUp{
        color: #919191;
        position: fixed; /* Фиксированное положение */
        right: 10px; /* Расстояние от правого края окна браузера */
        top: 90%; /* Расстояние сверху */
        padding: 10px; /* Поля вокруг текста */
        /*transform: rotate(90deg);*/
        font-size: 60px;
        cursor: pointer;
        z-index: 2
    }
</style>
<body>

<img id="zombie" height="210" width="159" style="margin: -200px">

<div class="container">
<div class="row">
    <div class="col-md-12" role="main" id="main-block">
        <div class="bs-callout bs-callout-info" id="about-block">
            <div class="row">
                <div class="col-md-offset-1 col-md-10 text-center">
                    <h4 class="timers-title" style="font-size: 30px;margin: 30px 0 20px 86px; color: #DFE2DB"><strong>Информация</strong></h4>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>Основные данные</strong></li>
                        <li class="list-group-item">Кредиты <span class="badge"><?php print_r($userItems['credit']); ?></span></li>
                        <li class="list-group-item">Жетоны <span class="badge"><?php print_r($userItems['jetton']); ?></span></li>
                        <li class="list-group-item">Медали <span class="badge"><?php print_r($userItems['contest_medal']); ?></span></li>
                        <li class="list-group-item">Рейтинг <span class="badge"><?php print_r($userItems['rating']); ?></span></li>
                        <li class="list-group-item">Инфопланшет <span class="badge"><?php print_r($userItems['event_grind_token']); ?></span></li>
                        <li class="list-group-item">Уровень <span class="badge"><?php print_r($userItems['level_up']); ?></span></li>
                        <li class="list-group-item">Опыт <span class="badge"><?php print_r($userItems['experience']); ?></span></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>Ресурсы</strong></li>
                        <li class="list-group-item">Металл
                            <div class="progress_width">
                                <div class="progressBar">
                                    <div class="progressItem"></div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">Кристалы
                            <div class="progress_width">
                                <div class="progressBar">
                                    <div class="progressItem"></div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">Кордит
                            <div class="progress_width">
                                <div class="progressBar">
                                    <div class="progressItem"></div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">Топливо
                            <div class="progress_width">
                                <div class="progressBar">
                                    <div class="progressItem"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>Рекруты</strong></li>
                        <li class="list-group-item">Космопехота <span class="badge"><?php print_r($userItems['recruit_praetorian']); ?></span></li>
                        <li class="list-group-item">Культ машин <span class="badge"><?php print_r($userItems['recruit_knights']); ?></span></li>
                        <li class="list-group-item">Высшие <span class="badge"><?php print_r($userItems['recruit_superior']); ?></span></li>
                        <li class="list-group-item">Космические пилоты <span class="badge"><?php print_r($userItems['recruit_space']); ?></span></li>
                    </ul>
                </div>

                <div class="col-md-5">
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>Боеприпасы колония</strong></li>
                        <li class="list-group-item">Авиаудар <span class="badge"><?php print_r($userItems['air_strike']); ?></span></li>
                        <li class="list-group-item">Медикаменты <span class="badge"><?php print_r($userItems['medicaments']); ?></span></li>
                        <li class="list-group-item">Гравибомба <span class="badge"><?php print_r($userItems['gravibomb']); ?></span></li>
                        <li class="list-group-item">Энергетический щит <span class="badge"><?php print_r($userItems['shields']); ?></span></li>
                        <li class="list-group-item">Боевые дроиды <span class="badge"><?php print_r($userItems['droids']); ?></span></li>
                        <li class="list-group-item">Орбитальный удар <span class="badge"><?php print_r($userItems['orbital_hit']); ?></span></li>
                        <li class="list-group-item">Боевые стимуляторы <span class="badge"><?php print_r($userItems['stimulators']); ?></span></li>
                        <li class="list-group-item">Мина "Циклоп" <span class="badge"><?php print_r($userItems['cyclops_mine']); ?></span></li>
                        <li class="list-group-item">Орбитальная бомбардировка <span class="badge"><?php print_r($userItems['orbital_bombardment']); ?></span></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>Боеприпасы космос</strong></li>
                        <li class="list-group-item">Минное заграждение <span class="badge"><?php print_r($userItems['space_mines']); ?></span></li>
                        <li class="list-group-item">Ремонтный дрон <span class="badge"><?php print_r($userItems['repair_drones']); ?></span></li>
                        <li class="list-group-item">Адаптивное покрытие <span class="badge"><?php print_r($userItems['adaptive_shield']); ?></span></li>
                        <li class="list-group-item">Радарная ловушка <span class="badge"><?php print_r($userItems['ecm']); ?></span></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>PvP</strong></li>
                        <li class="list-group-item">pvp_stage <span class="badge"><?php print_r($userItems['pvp_stage']); ?></span></li>
                        <li class="list-group-item">event_stage <span class="badge"><?php print_r($userItems['event_stage']); ?></span></li>
                        <li class="list-group-item">league_stage <span class="badge"><?php print_r($userItems['league_stage']); ?></span></li>
                        <li class="list-group-item">space_event_stage <span class="badge"><?php print_r($userItems['space_event_stage']); ?></span></li>
                        <li class="list-group-item">space_league_stage <span class="badge"><?php print_r($userItems['space_league_stage']); ?></span></li>
                    </ul>
                </div>

                <div class="col-md-3 profile" role="profile" id="profile-block">
                    <div class="about-me clearfix">
                        <ul class="list-group">

                            <li class="list-group-item text-info">
                                <a href="https://vk.com/app3558212_82476850" target="_blank" id="enter-game" class="btn btn-success btn-block">Войти в игру</a>

                                <form method="post">
                                    Предел кристалов<input type="number" name="cristalLimit" value="<?php echo $cristalLimit ?>" class="form-control">
                                    Предел кордита<input type="number" name="corditLimit" value="<?php echo $corditLimit ?>" class="form-control">
                                    <label>
                                        <input type="checkbox"  name="resourceCreate" <?php echo ($resourceCreate == true) ? 'checked="checked"' : NULL; ?>> Сбор с шахт ресурсов
                                    </label>
                                    <label>
                                        <input type="checkbox"  name="collectionResources" <?php echo ($collectionResources == true) ? 'checked="checked"' : NULL; ?>> Сбор с колонистов
                                    </label>
                                    <label>
                                        <input type="checkbox"  name="shopAssassin" <?php echo ($shopAssassin == true) ? 'checked="checked"' : NULL; ?>> Покупка наемников
                                    </label>
                                    <label>
                                        <input type="checkbox"  name="ammunition" <?php echo ($ammunition == true) ? 'checked="checked"' : NULL; ?>> Производство БП
                                    </label>
                                    <label>
                                        <input type="checkbox"  name="spaceExpedition" <?php echo ($spaceExpedition == true) ? 'checked="checked"' : NULL; ?>> Экспедиции в космос
                                    </label>
                                    <label>
                                        <input type="checkbox"  name="start" <?php echo ($start == true) ? 'checked="checked"' : NULL; ?>> Запуск бота
                                    </label>
                                    <br>
                                    Отправка чертежей<input type="text" name="sendMaps" placeholder="Ссылка для отправки" class="form-control">
                                    <input type="submit" name="startBot" value="Отправить" class="btn btn-block <?php print_r((isset ($btnColor)) ? $btnColor : 'btn-info') ?>">
                                </form>
                            </li>


                            <li class="list-group-item text-info text-center">
                                Аккаунт #8304102
                            </li>
                            <li class="list-group-item clearfix" style="position: relative">
                                <img src="https://pp.userapi.com/c626124/v626124102/5c929/3XYLqE9GT6U.jpg" class="img-thumbnail">
                                <div class="name">
                                    <strong>Кирилл Буковски</strong>
                                </div>
                            </li>

                        </ul>
                        <hr>

                    </div>

                    <div class="game-info" id="game-info-block">
                        <div class="stats-all visible-md visible-lg">
                            <ul class="list-group">
                                <li class="list-group-item text-info text-center">
                                    Server Info
                                </li>
                                <li class="list-group-item">
                                    <span class="badge badge-info"><?= sprintf('%.3f', $timeWorkScript).'.сек'; ?></span>
                                    Время выполнения кода
                                </li>
                                <li class="list-group-item">
                                    <span class="badge badge-info"><?php print_r(date('Y-m-d H:i:s', $userLastEnter)); ?></span>
                                    Входил в игру
                                </li>
                                <li class="list-group-item">
                                    <span class="badge badge-info"><?php print_r(date('H:i:s')); ?></span>
                                    Обновлял информацию
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-md-9 col-md-offset-2">
                    <ul class="list-group">
                        <li class="list-group-item text-center text-info"><strong>Таймеры событий</strong></li>
                        <?php foreach ($userTimer as $timer) {
                            $timerEventAll = $timer['@attributes'];
                            echo '<li class="list-group-item">'.$timerEventAll['type']. '<span class="badge">F: '
                                .date('m.d H:i:s', $timerEventAll['finish_time']) .'</span><span class="badge">S: '
                                .date('m.d H:i:s', $timerEventAll['start_time']) .'</span><span class="badge">'
                                .date('H:i:s', $timerEventAll['start_time']-$timerEventAll['finish_time']).'</span></li>';
                        }?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<div onclick="up()" style="display: none;" id="buttonUp"><img src="files/top.png" alt="Up"></div>

<canvas id=c></canvas>

<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="lib/vanilla-tilt.js"></script>
<script>

    function progress(items, itemsMax, countDiv) {
        var doc = document,
            itemsFuel = items || 0,
            itemsFuelMax = itemsMax,
            progressItem = doc.getElementsByClassName('progressItem')[countDiv],
            progress_width = doc.getElementsByClassName('progress_width')[countDiv],
            progressBar = doc.getElementsByClassName('progressBar')[countDiv],
            width = progress_width.offsetWidth - 2; //получаем ширину полосы -2 отнимаем оконтовку
        (function () {
            var procent = Math.round(width - (width - ( itemsFuel / (itemsFuelMax / 100) ))); //получаем проценты от ресурсов для шкалы прогресса
            progressItem.innerHTML = itemsFuel + ' / ' + itemsFuelMax;
            if( itemsFuelMax >= itemsFuel) {
                progressBar.setAttribute("style","width: " + procent + "%;background-color: #479e47;");
            } else {
                progressBar.setAttribute("style","width: 100%;background-color: red;");
            }
        })();
        progressItem.style.margin = "-2px 0 0 " + (( progress_width.clientWidth - (progressItem.clientWidth) ) / 2) + "px";
    }
    progress('<?php print_r($userItems['metal']); ?>', 4220, 0); //количество ресурсов, предел ресурсов, номер в разметке блока
    progress('<?php print_r($userItems['crystal']); ?>', 3720, 1);
    progress('<?php print_r($userItems['cordite']); ?>', 10000, 2);
    progress('<?php print_r($userItems['fuel']); ?>', 2500, 3);

    var imgZombi = document.getElementById('zombie'); //Создание обьекта изображения
    imgZombi.src = "files/DancingQueen-Zombie.png"; //ссфлка на изображение
    imgZombi.style.zIndex = 5;
    imgZombi.style.position = "fixed";
    var coordinateX = 10; //координаты изображения
    var back = true;
    var itemsZombie = 0;
    var maxItemsZombi = 4;
    var minItemsZombi = 1;

    var scrollHide =  document.documentElement.clientHeight / 100 * 50;
    function move() { //функция для вызыва таймера
        //появление кнопки прокрутки
        var windowH = window.pageYOffset; //прокрутка по высоте
        document.getElementById('buttonUp').style.display = (windowH <= scrollHide)  ? 'none' : 'block';
    }
    setInterval(move, 30);
    
    //сама прокрутка
    var timerScroll;
    function up() {
        var scrollPage = document.body.scrollTop || document.documentElement.scrollTop; //получаем прокрутку кросбраузерно
        if(scrollPage > 0) {
            window.scrollBy(0,-100); //отнимаем от текущей позиции 100 (прокручивая страницу)
            timerScroll = setTimeout('up()',20); //вызываем прокрутку 20 мск
        } else {
            clearTimeout(timerScroll); //удаляем таймер когда страница прокручена до верха
        }
        return false;
    }

    //Rainbow Rain
    //initial
    var w = c.width = window.innerWidth,
        h = c.height = window.innerHeight,
        ctx = c.getContext('2d'),

        //parameters
        total = w,
        accelleration = .05,

        //afterinitial calculations
        size = w/total,
        occupation = w/total,
        repaintColor = 'rgba(0, 0, 0, .04)',
        colors = [],
        dots = [], //точки
        dotsVel = [];

    //setting the colors' hue
    //and y level for all dots
    var portion = 360/total;
    for(var i = 0; i < total; ++i){
        colors[i] = portion * i;

        dots[i] = h;
        dotsVel[i] = 10;
    }

    function anim(){
        window.requestAnimationFrame(anim);

        ctx.fillStyle = repaintColor;
        ctx.fillRect(0, 0, w, h);

        for(var i = 0; i < total; ++i){
            var currentY = dots[i] - 1;
            dots[i] += dotsVel[i] += accelleration;

            ctx.fillStyle = 'hsl('+ colors[i] + ', 80%, 50%)';
            ctx.fillRect(occupation * i, currentY, size, dotsVel[i] + 1);

            if(dots[i] > h && Math.random() < .01){
                dots[i] = dotsVel[i] = 0;
            }
        }
    }
    anim();
</script>
</body>
</html>

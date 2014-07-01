<?php
require_once 'auth.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Карта - FiberMS</title>
        <link rel="stylesheet" type="text/css" href="style_popup.css" />
        <link rel="stylesheet" type="text/css" href="style_popup2.css">
        <style type="text/css">
            #controlToggle li {
                list-style: none;
            }
        </style>
        <script type="text/javascript" src="js/jquery.min-1.9.1.js"></script>
        <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
        <script type="text/javascript" src="js/menu.js"></script>
        <script src="js/OpenLayers.js"></script>
        <!--script type="text/javascript" src="js/MarkerGrid.js"></script>
        <script type="text/javascript" src="js/MarkerTile.js"></script>
        <script type="text/javascript" src="js/bounds.js"></script-->
        <script type="text/javascript" src="js/js_xml.js"></script>
        <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
        <script type="text/javascript" src="js/map.js"></script>
        <link rel="stylesheet" type="text/css" href="style/map-menu-v.css" />
        <link rel="stylesheet" type="text/css" href="style/map-menu.css" />
        <link rel="stylesheet" href="js/theme/default/google.css" type="text/css">
        <script type="text/javascript">
        <?php
        print "var lat = ".$config['lat'].";
        var lon = ".$config['lon'].";
        var zoom = ".$config['zoom'].";\n"
        ?>
        </script>
    </head>
    <body>
        <div id="container">
            <div id="map"></div>            
        </div>  
        <div id="slideout">
            <div id="slidecontent">
                <div id="smoothmenu1" class="ddsmoothmenu-v">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="#">Ящики</a>
                            <ul>
                                <li><a href="NetworkBox.php">Все ящики</a></li>
                                <li><a href="NetworkBox.php?mode=add">Добавить ящик</a></li>
                                <li><a href="NetworkBoxType.php">Типы ящиков</a></li>
                                <li><a href="NetworkBoxType.php?mode=add">Добавить тип ящика</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Узлы</a>
                            <ul>
                                <li><a href="NetworkNodes.php">Все узлы</a></li>
                                <li><a href="NetworkNodes.php?mode=add">Добавить узел</a></li>
                            </ul>
                        </li>
                        <li id="li4"><a href="#">Линии</a>
                            <ul>
                                <li id="li4"><a href="CableLine.php">Список линий</a></li>
                                <li id="li4"><a href="CableLine.php?mode=add">Добавить линию</a></li>
                                <li id="li4"><a href="CableType.php">Список типов кабелей</a></li>
                                <li id="li4"><a href="CableType.php?mode=add">Добавить тип кабеля</a></li>
                            </ul>
                        </li>
                        <li id="li4"><a href="#">Кассеты</a>
                            <ul>
                                <li id="li4"><a href="FSO.php">Список кассет</a></li>
                                <li id="li4"><a href="FSO.php?mode=add">Добавить кассету</a></li>
                                <li id="li4"><a href="FSOT.php">Список типов кассет</a></li>
                                <li id="li4"><a href="FSOT.php?mode=add">Добавить тип кассеты</a></li>			  
                            </ul>
                        </li>
                        <li id="li4"><a href="#">Карта</a>
                            <ul>
                                <li id="li4"><a href="map.php">Карта (просмотр)</a></li>
                                <li id="li4"><a href="map_edt.php">Карта (редактирование)</a></li>
                            </ul>
                        </li>
                        <li><a href="LoggingIs.php">Журнал</a></li>
                        <li><a href="Users.php">Пользователи</a></li>
                        <li><a href="logout.php">Выйти</a></li>
                    </ul>
                    <br style="clear: left" />
                </div>
            </div>
            <img src="pic/menu.png" id="menuBtn" title="Меню" />
        </div>
    </body>
</html>
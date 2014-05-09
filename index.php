<!-- includes -->
<?php
session_start();
require './includes.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="/jeremieferreira/view/commons/jf.css">
        <link type="image/png" rel="icon" href="/jeremieferreira/resources/icon.png">

        <!-- jquery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

        <!-- prettify syntax highlighter -->
        <link rel="stylesheet" href="/jeremieferreira/libs/prettify/sunburst.css" />
        <script src="/jeremieferreira/libs/prettify/prettify.js"></script>

        <title>Jérémie Ferreira</title>
    </head>
    <body>

        <div id="top_menu">
            <div class="left_menu">
                <ul>
                    <li><a id="main_menu_button" class="menu_button">JF</a></li>
                    <?php
                    $class = "menu_button large_menu_button";
                    require './view/commons/header.php';
                    ?>
                </ul>
            </div>
        </div>

        <div id="lateral_menu">
            <ul>
                <li id="lateral_title">Navigation</li>
                
                <?php
                $class = "menu_button";
                require './view/commons/header.php';
                ?>
            </ul>
        </div>

        <div id="content">
            <?php
            Dispatcher::dispatch();
            ?>
        </div>

        <!-- lateral menu jquery -->
        <script src="/jeremieferreira/view/commons/lateralMenu.js"></script>

        <!-- footer -->
        <?php require SERVER_BASE . '/view/commons/footer.html'; ?>

        <!-- syntax highlighting -->
        <script> prettyPrint();</script>
    </body>
</html>

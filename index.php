<!-- php-dokumentet för webbsidans "homepage" -->
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Baseplate</title>
        <link rel="icon" href="images/logoIcon.ico"/>
        <link rel="stylesheet" href="style.css">
        <script src="script.js" defer></script>
    </head>

    <body>
        <!-- Bakgrundsbilder -->
        <img id="brick_left" src="images/bricksideLeft.png" alt="bricks left">
        <img id="brick_right" src="images/bricksideRight.png" alt="bricks right">

        <!-- header -->
        <header> 
            <a href="index.php"><img id="logo_header" src="images/logoHeader.png" alt="logo"></a>

            <div class="popup" onclick="popupFunction(howToUsePopup)"> 
                <button id="how_to_use_btn">How to Use</button>
                <button id="how_to_use_btn_min">?</button>
            </div>

            <article class="popuptext" id="howToUsePopup">
                <button onclick="closePopup(howToUsePopup)" class="closeBtn">+</button>
                <?php include("howToUse.txt"); ?>
            </article>
            <article class="popuptext" id="aboutUsPopup">
                <button onclick="closePopup(aboutUsPopup)" class="closeBtn">+</button>
                <?php include("aboutUs.txt"); ?>
            </article>

            <article class="popuptext" id="cookiesPopup">
                <button onclick="closePopup(cookiesPopup)" class="closeBtn">+</button>
                <?php include("cookies.txt"); ?>
            </article>
        </header>

        <?php
        session_start();
        ?>

        <div class="search_section">
            <img id="search_image" src="images/logoHomepage.png" alt="logo">

            <form action="search.php" method="get" >
                <input type="text" name="searchResult" id="search_bar" placeholder="Find your inner piece...">

                <input type="image" id="searchBtn" onmouseover="this.src='images/magnifyingGlassHover.png'" 
                alt="magnifying glass" onmouseout="this.src='images/magnifyingGlass.png'" src="images/magnifyingGlass.png">
            </form> 
        </div>
    
    <button id="topBtn" title="go to top">➜</button>

        <footer>
            <div class="popup" onclick="popupFunction(aboutUsPopup)"> 
                <button id="about" >About us</button>
            
            </div>
            <div class="popup" onclick="popupFunction(cookiesPopup)"> 
                <button id="cookies" >Cookies</button>
                    
            </div>    
        </footer>
    </body>
</html>

<?php
    session_unset();
?>
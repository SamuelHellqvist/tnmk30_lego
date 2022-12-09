<!-- php-dokumentet för webbsidans "homepage" -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huvudsida</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <!-- header -->
    <header> 
        <img id="logo_header" src="images/image.jpg" alt="logo">
        
        <div class="popup" onclick="popupFunction(howToUsePopup)"> 
        <button>How to Use</button>
        </div>
        <span class="popuptext" id="howToUsePopup">
            <button onclick="closePopup(howToUsePopup)" id="closeBtn">Close</button>
            <?php include("howToUse.txt"); ?>
        </span>

        <span class="popuptext" id="aboutUsPopup">
            <button onclick="closePopup(aboutUsPopup)" id="closeBtn">Close</button>
            <?php include("aboutUs.txt"); ?>
        </span>

        <span class="popuptext" id="cookiesPopup">
            <button onclick="closePopup(cookiesPopup)" id="closeBtn">Close</button>
            <?php include("cookies.txt"); ?>
        </span>

    </header>

    <?php
    session_start();
    $search
    ?>

    <div class="search_section">
        <img id="search_image" src="images/image.jpg" alt="logo">
        <form action="search.php" method="get" >
            <input type="text" id="search_bar" placeholder="Find your inner piece...">
        </form> 

    </div>
    
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
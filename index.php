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
            <h1>How to use</h1><button>Close</button>
            <p> 
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Suspendisse a orci consequat, euismod lacus eget, imperdiet 
            enim. Ut maximus malesuada arcu vel tempor. Proin finibus 
            ultricies iaculis. Donec sit amet metus et justo blandit 
            luctus sed id urna. Nulla cursus sem quis mi lacinia iaculis. 
            Sed eu aliquam libero. Pellentesque nisl odio, ullamcorper 
            eu nunc ac, semper hendrerit lacus. Donec sed mauris posuere, 
            posuere nisi eget, vulputate quam.
            </p>
            <img src="images/image.jpg">
            <br>
            <p>
            Nam lacinia, ante at suscipit aliquet, urna lacus consectetur 
            velit, id vulputate ipsum arcu eu ligula. Nulla facilisi. Proin 
            iaculis nisl tellus, ut bibendum lectus ultricies vitae. Nullam 
            scelerisque mauris neque, eget viverra mi gravida sed. 
            Pellentesque nec mi cursus, suscipit ante non, rutrum augue. 
            Vestibulum id euismod leo. Suspendisse nec ligula a dolor faucibus iaculis. Cras luctus lectus in neque placerat, non laoreet risus eleifend. Integer et volutpat diam. Aenean ornare porttitor augue, eu bibendum dui posuere volutpat.
            </p>
            </span>

            <span class="popuptext" id="aboutUsPopup">
            <h1>About us</h1>
            <p>TEXtasdfghjkl</p>
            <br>
            <p>
            Nam lacinia, ante at suscipit aliquet, urna lacus consectetur 
            velit, id vulputate ipsum arcu eu ligula. Nulla facilisi. Proin 
            iaculis nisl tellus, ut bibendum lectus ultricies vitae. Nullam 
            scelerisque mauris neque, eget viverra mi gravida sed. 
            Pellentesque nec mi cursus, suscipit ante non, rutrum augue. 
            Vestibulum id euismod leo. Suspendisse nec ligula a dolor faucibus iaculis. Cras luctus lectus in neque placerat, non laoreet risus eleifend. Integer et volutpat diam. Aenean ornare porttitor augue, eu bibendum dui posuere volutpat.
            </p>
            </span>

            <span class="popuptext" id="cookiesPopup">
            <h1>Cookies</h1>
            <br>
            <p>
            Yeet
            </p>
            </span>
    </header>

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
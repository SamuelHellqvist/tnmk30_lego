<?php 
//inkluderar header
include 'head.txt';

//Hämtar sökt term från url
if(isset($_GET["search"])){
    $searchResult = $_GET["search"];
}

//Hämtar partID från url
if(isset($_GET["part"])){
    $parts = $_GET["part"];
}

//Hämtar colorID från url
if(isset($_GET["color"])){
    $color = $_GET["color"];
}

//Hämtar page nummer från url
if(isset($_GET["page"])){
    $page = $_GET["page"];
}

//sammankopplar med data basen
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

//om sammankopplingen inte funkar så får användaren reda på det
if (!$connection){
    die('MySQL connection error');
}

//om inget colorID har angetts kommer inte färg att användas och behöver därför inte skrivas ut
if($color === '-1'){
    $findName = "SELECT Partname FROM parts WHERE PartID = '$parts'";
    $nameContent = mysqli_query($connection, $findName);

    $nameRow = mysqli_fetch_array($nameContent);

    $brickName = $nameRow['Partname'];

    print("
    <div class='breadCrumbs'>
    <a href='index.php'>Start</a> / <a href='search.php?searchResult=$searchResult&page=1'>$searchResult</a> / $brickName 
    
    </div>
    ");

    //skriver ut för vilken bit som vi visar resultat för så att det blir lätt att veta det för användaren
    print("<h1 class='titleText'>'$brickName' can be found in these sets:</h1>");
}

//om en färg har angetss
else{
    $findName = "SELECT parts.Partname, colors.Colorname FROM parts, colors WHERE parts.PartID = $parts AND colors.ColorID = $color";
    $nameContent = mysqli_query($connection, $findName);

    $nameRow = mysqli_fetch_array($nameContent);

    $brickName = $nameRow['Partname'];
    $colorName = $nameRow['Colorname'];

    print("
    <div class='breadCrumbs'>
    <a href='index.php'>Start</a> / <a href='search.php?searchResult=$searchResult'>$searchResult</a> / <a href='chosenBrick.php?search=$searchResult&part=$parts&page=1'>$brickName</a> / $colorName 
    
    </div>
    ");

    print("<h1 class='titleText'>'$colorName $brickName' can be found in these sets:</h1>");
}

$pagePlus = $page+1;
$pageMinus = $page-1;
$pageCounter = 0;
$moreBricks = 0;

if($page === '1'){
    print("
    <div class='pageDisplay pageBtns' id='first'>
        <p>Currenty displaying page: $page </p>
    </div>");
}
else{
    print("
    <div class='pageDisplay pageBtns'>
        <p>Currenty displaying page: $page </p>
        <a href='setList.php?part=$parts&color=$color&page=1'>Go to page 1</a>
    </div>");
}

$pagePlus = $page+1;
$pageMinus = $page-1;
$pageCounter = 0;

$top = ($page)*10;
$min = ($page-1)*10;
$minCounter = 0;
$moreBricks = 0;

if($color === '-1'){
    
    $searchKey = "SELECT inventory.SetID, inventory.Quantity, sets.Setname, sets.SetID, sets.Year, images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg 
    FROM inventory, sets, images WHERE inventory.ItemID='$parts' 
    AND sets.SetID = inventory.SetID 
    AND images.ColorID=inventory.ColorID
    AND images.ItemtypeID=inventory.ItemtypeID
    AND images.ItemID=inventory.ItemID";


    $contents = mysqli_query($connection, $searchKey);

    //skapar en loop som skriver ut alla sets som hittas, tills det inte finns några kvar att visa
    while($row = mysqli_fetch_array($contents)){

        $alt = '"images/image.jpg"';
        $setName = $row['Setname'];
        $year = $row['Year'];
        $quantity = $row['Quantity'];

        $gif = $row['has_gif'];
        $jpg = $row['has_jpg'];

        $largegif = $row['has_largegif'];

        $largejpg = $row['has_largejpg'];

        $setID = $row['SetID'];

        if($largejpg){
            $filename = 'SL' . '/' . $setID . '.jpg';
        }
        else if($largegif){
            $filename = 'SL' . '/' . $setID . '.gif';
        }
        else if($jpg){
            $filename = 'S' . '/' . $setID . '.jpg';
        }
        else if($gif){
            $filename = 'S' . '/' . $setID . '.gif';
        }

        //en ruta med information om setet
        if($pageCounter >= 10){
            $moreBricks++;
        }
    
        if($minCounter >= $min){
        if($pageCounter < 10){
        
        $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

            print(
                "<div class='brickinfo'>
                    <section>
                        <h2>$setName</h2>
                        <p>SetID: $setID</p>
                        <p>Year: $year</p>
                        <p>Quantity of part in set: $quantity</p>
                    </section>
                    <div class='imgbox'>
                    <a><img src=$imglink onerror='this.onerror=null; this.src=$alt' alt='$setID'></a>
                    </div>
                </div>
                \n
                "
        
            );
        $pageCounter++;
        }
        }
        else{
            $minCounter++;
        }
    }

}
else{

    $searchKey ="SELECT sets.SetID, sets.Setname, sets.Year, inventory.ItemID, inventory.ItemtypeID, inventory.Quantity, images.has_gif, images.has_jpg, images.has_largejpg, images.has_largegif, images.ItemID
    FROM sets, inventory, images 
    WHERE sets.SetID = inventory.SetID 
    AND inventory.ItemID = $parts 
    AND inventory.ColorID = $color
    AND sets.SetID = images.ItemID 
    AND images.ItemtypeID = 'S'";

    $contents = mysqli_query($connection, $searchKey);
    
    //skapar en loop som skriver ut alla sets som hittas, tills det inte finns några kvar att visa
    while($row = mysqli_fetch_array($contents)){

        $alt = '"images/image.jpg"';
        $setName = $row['Setname'];
        $setID = $row['SetID'];
        $year = $row['Year'];
        $quantity = $row['Quantity'];

        $gif = $row['has_gif'];

        $jpg = $row['has_jpg'];

        $largegif = $row['has_largegif'];

        $largejpg = $row['has_largejpg'];

        
        //hittar rätt bild beroende på vad som finns
        //här är det skillnad på stor och liten bild
        if($largejpg){
            $filename = 'SL' . '/' . $setID . '.jpg';
        }
        else if($largegif){
            $filename = 'SL' . '/' . $setID . '.gif';
        }
        else if($jpg){
            $filename = 'S' . '/' . $setID . '.jpg';
        }
        else if($gif){
            $filename = 'S' . '/' . $setID . '.gif';
        }

        $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

            //en ruta med info om setet
            if($pageCounter >= 10){
                $moreBricks++;
            }
        
            if($minCounter >= $min){
            if($pageCounter < 10){
            print(
                "<div class='brickinfo'>
                    <section>
                        <h2>$setName</h2>
                        <p>SetID: $setID</p>
                        <p>Year: $year<p>
                        <p>Quantity of part in set: $quantity</p>
                    </section>
                    <div class='imgbox'>
                    <a><img src=$imglink onerror='this.onerror=null; this.src=$alt' alt='$setID'></a>
                    </div>
                </div>
                \n
                "
        
            );
        $pageCounter++;
        }
        }
        else{
            $minCounter++;
        }
    }
}

if($page == 1 && $pageCounter > 9 && $moreBricks > 0){
    print("
    <div class='pageBtns'>
        <p> - </p>
        <p>Page $page</p>
        <a href='setList.php?search=$searchResult&part=$parts&color=$color&page=$pagePlus'> >></a>
    </div>");
}
elseif($page != 1 && $pageCounter != 10 || $moreBricks === 0 && $page != 1){
    print("
    <div class='pageBtns'>
        <a href='setList.php?search=$searchResult&part=$parts&color=$color&page=$pageMinus'><< </a>
        <p>Page $page</p>
        <p> - </p>
    </div>");
}
elseif($page === '1' && $pageCounter < '10'){
    print("
    <div class='pageBtns'>
        <p> - </p>
        <p>Page $page</p>
        <p> - </p>
    </div>");
}
else if($moreBricks > 0){
    print("
    <div class='pageBtns'>
        <a href='setList.php?search=$searchResult&part=$parts&color=$color&page=$pageMinus'><< </a>
        <p>Page $page</p>
        <a href='setList.php?search=$searchResult&part=$parts&color=$color&page=$pagePlus'> >></a>
    </div>");
}
?>

<!-- lägger till top-knappen -->
<button id="topBtn" title="go to top">➜</button>

</body>
</html>
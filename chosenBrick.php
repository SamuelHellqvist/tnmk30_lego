<?php 

//Inkluderar headern
include 'head.txt';

//skapar connection för att kunna koppla upp mot hemisdan
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

//testar connection
if (!$connection){
    die('MySQL connection error');
}

//Hämtar sökt term från url
if(isset($_GET["search"])){
    $searchResult = mysqli_real_escape_string($connection, $_GET["search"]);
}

//Hämtar partID från url
if(isset($_GET["part"])){
    $parts = mysqli_real_escape_string($connection, $_GET["part"]);
}

//Hämtar page nummer från url
if(isset($_GET["page"])){
    $page = mysqli_real_escape_string($connection, $_GET["page"]);
}

//sql fråga
//hämtar parts.partName från det part id som vi vill ha
$findBrick = "SELECT parts.Partname FROM parts WHERE parts.PartID = $parts";
$brickContent = mysqli_query($connection, $findBrick);
$row = mysqli_fetch_array($brickContent);
$brickName = $row['Partname'];

print("
    <div class='breadCrumbs'>
        <a href='index.php'>Start</a> / <a href='search.php?searchResult=$searchResult'>$searchResult</a> / $brickName
    </div>
");

//skriver ut vilken bit som vi hämtar version av
//det hjälper användaren att se vad den fick för resultat efter sin sökning
print("
    <h1 class='titleText'>Choose color for '$brickName'</h1>
");

//skriver till användaren vilken som är den aktuella sidan
if($page === '1'){
    print("
        <div class='pageDisplay pageBtns' id='first'>
            <p>Currenty displaying page: $page </p>
        </div>
    ");
}
else{
    print("
        <div class='pageDisplay pageBtns'>
            <p>Currenty displaying page: $page </p>
            <a href='chosenBrick.php?part=$parts&page=1'>Go to page 1</a>
        </div>
    ");
}

//ny sql fråga som hämtar allt annat vi behöver för att visa bilder på alla bitens olika färger
$searchKey = "SELECT DISTINCT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg, parts.Partname, colors.Colorname
FROM inventory, colors, parts, images WHERE inventory.ItemID = $parts 
AND inventory.ItemtypeID='P'
AND inventory.ItemID=parts.PartID
AND colors.ColorID LIKE inventory.ColorID
AND images.ItemtypeID=inventory.ItemtypeID
AND images.ItemID=inventory.ItemID
AND images.ColorID=colors.ColorID ORDER BY colors.Colorname";

$contents = mysqli_query($connection, $searchKey);
$test= mysqli_fetch_array($contents);
$colorNametest = $test['Colorname'];

//vissa bitar har inget specifikt colorID, om biten man har valt saknar colorID så skickas användaren direkt till setsen
if($colorNametest === null){
    header("Location: setList.php?search=$searchResult&part=$parts&color=-2&page=1");
}

//variabler för att kontrollera antalet resultat per sida
$check = -1;
$pagePlus = $page+1;
$pageMinus = $page-1;
$pageCounter = 0;
$top = ($page)*10;
$min = ($page-1)*10;
$minCounter = 0;

//skapar en while loop som skapar en klickbar ruta för varje färg för biten
while($row = mysqli_fetch_array($contents)){
    
    $colorName = $row['Colorname'];
    $color = $row['ColorID'];
    
    $gif = $row['has_gif'];
    $jpg = $row['has_jpg'];

    //hittar rätt bild beroende på vilken typ av bild biten ha
    if ($jpg){
        $filename =  $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.jpg';
    }
    else if ($gif){
        $filename =  $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.gif';
    }

    $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";
    
    //om färgen hitta har funnits innan, så skapas en klickbar ruta för biten med den färgen
    if($color !== $check && $pageCounter >= 10){
        $moreBricks++;
    }
    
    //skriver ut resultat för alla färger
    if($page == 1 && $minCounter == 0){
        print("
            <div class='brickinfo' id='allColors'>
                <section>
                    <a href='setList.php?search=$searchResult&part=$parts&color=-1&page=1'><h2>All Colors</h2><p>View all sets that include $brickName</p></a>
                </section>
            </div>
        ");
        $pageCounter++;
        $minCounter++;
    }

    //kollar så att en färg som redan har visats inte visas igen och skriver ut nya färger
    if($color !== $check && $minCounter >= $min){
        if($color !== $check && $pageCounter < 10){
            print("
                <div class='brickinfo'>
                    <section>
                        <a href='setList.php?search=$searchResult&part=$parts&color=$color&page=1'><h2>$colorName</h2></a>
                        <p>ColorID: $color</p>
                    </section>
                    <div class='imgbox'>
                        <a href='setList.php?search=$searchResult&part=$parts&color=$color&page=1'><img src=$imglink alt=$parts></a>
                    </div>
                </div>\n
            ");
            $pageCounter++;
        }
    }
    //om färgen redan visats på en tidigare sida skrivs ingenting ut
    else if($color !== $check){
        $minCounter++;
    }

    //här sätts variabeln check till bitens färg för att kunna undersöka om färgen har presenterats innan eller inte
    $check = $color;
}

//skriver ut navigation mellan sidorna
if($page == 1 && $pageCounter > 9 && $moreBricks > 0){
    print("
        <div class='pageBtns' id='page_s'>
            <p> - </p>
            <p>Page $page</p>
            <a href='chosenBrick.php?search=$searchResult&part=$parts&page=$pagePlus'> &#10095;</a>
        </div>
    ");
}
else if($page != 1 && $pageCounter != 10 || ($moreBricks === 0 && $page != 1)){
    print("
        <div class='pageBtns' id='page_s'>
            <a href='chosenBrick.php?search=$searchResult&part=$parts&page=$pageMinus'>&#10094; </a>
            <p>Page $page</p>
            <p> - </p>
        </div>
    ");
}
else if($page == 1 && $pageCounter < 10 || ($moreBricks == 0 && $page == 1)){
    print("
        <div class='pageBtns' id='page_s'>
            <p> - </p>
            <p>Page $page</p>
            <p> - </p>
        </div>
    ");
}
else if($moreBricks > 0){
    print("
        <div class='pageBtns' id='page_s'>
            <a href='chosenBrick.php?search=$searchResult&part=$parts&page=$pageMinus'>&#10094; </a>
            <p>Page $page</p>
            <a href='chosenBrick.php?search=$searchResult&part=$parts&page=$pagePlus'> &#10095;</a>
        </div>
    ");
}
?>

<button id="topBtn" title="go to top">➜</button>

</body>
</html>
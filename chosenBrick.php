<?php 

//Inkluderar headern
include 'head.txt';

//Hämtar partID från url
if(isset($_GET["part"])){
    $parts = $_GET["part"];
}

//Hämtar page nummer från url
if(isset($_GET["page"])){
    $page = $_GET["page"];
}

//skapar connection för att kunna koppla upp mot hemisdan
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

//testar connection
if (!$connection){
    die('MySQL connection error');
}

//sql fråga
//hämtar parts.partName från det part id som vi vill ha
$findBrick = "SELECT parts.Partname FROM parts WHERE parts.PartID = $parts";

$brickContent = mysqli_query($connection, $findBrick);

$row = mysqli_fetch_array($brickContent);
$brickName = $row['Partname'];

//skriver ut vilken bit som vi hämtar version av
//det hjälper användaren att se vad den fick för resultat efter sin sökning
print("<h1 class='titleText'>Choose color for '$brickName'</h1>");

$pagePlus = $page+1;
$pageMinus = $page-1;
$pageCounter = 0;

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
        <a href='chosenBrick.php?part=$parts&page=1'>Go to page 1</a>
    </div>");
}

$base =($page-1)*10;

//ny sql frpga som hämtar allt annat vi behöver för att visa bilder på alla bitens olika färger
$searchKey = "SELECT DISTINCT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg, parts.Partname, colors.Colorname
FROM inventory, colors, parts, images WHERE inventory.ItemID = $parts 
AND inventory.ItemtypeID='P'
AND inventory.ItemID=parts.PartID
AND colors.ColorID LIKE inventory.ColorID
AND images.ItemtypeID=inventory.ItemtypeID
AND images.ItemID=inventory.ItemID
AND images.ColorID=colors.ColorID ORDER BY colors.Colorname
LIMIT $base, 11";

$contents = mysqli_query($connection, $searchKey);

$test= mysqli_fetch_array($contents);

$colorNametest = $test['Colorname'];

$check = -1;

//vissa bitar har inget specifikt colorID, om biten man har valt saknar colorID så sätts det till
//-1 och man skickas direkt till sidan med alla sets som biten ingår i
if($colorNametest === null){
    header("Location: setList.php?part=$parts&color=-1&page=1");
}

//skapar en while loop som skapar en klickbar ruta av varje färg för biten
while($row = mysqli_fetch_array($contents)){
    
    $colorName = $row['Colorname'];

    $color = $row['ColorID'];

    $gif = $row['has_gif'];

    $jpg = $row['has_jpg'];

    //vissa bitar har jpg bilder och vissa har gif, här hittas rätt bildformat för varje bit
    //genom att man tar vilken typ av bild som biten har och använder det i en url till bilden
    if ($jpg){
        $filename =  $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.jpg';
    }
    else if ($gif){
        $filename =  $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.gif';
    }

    $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";
    
    //om färgen hitta har funnits innan, så skapas en klickbar ruta för biten med den färgen
    if($color !== $check){
        
        print("
        <div class='brickinfo'>
        <section>
            <a href='setList.php?part=$parts&color=$color&page=1'><h2>$colorName</h2></a>
            <p>ColorID: $color $colorNametest</p>
            
        </section>
        <div class='imgbox'>
        <a href='setList.php?part=$parts&color=$color&page=1'><img src=$imglink alt=$parts></a>
        </div>
    </div>
    \n
    

        ");
    }
    $pageCounter++;
    //här sätts variabeln check till bitens färg för att kunna undersöka om färgen har presenterats innan eller inte
    $check = $color;
}

if($page === '1' && $pageCounter > '9'){
    print("
    <div class='pageBtns'>
        <p> - </p>
        <p>Page $page</p>
        <a href='chosenBrick.php?part=$parts&page=$pagePlus'> >></a>
    </div>");
}
elseif($page !== '1' && $pageCounter != '10'){
    print("
    <div class='pageBtns'>
        <a href='chosenBrick.php?part=$parts&page=$pageMinus'><< </a>
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
else{
    print("
    <div class='pageBtns'>
        <a href='chosenBrick.php?part=$parts&page=$pageMinus'><< </a>
        <p>Page $page</p>
        <a href='chosenBrick.php?part=$parts&page=$pagePlus'> >></a>
    </div>");
}

?>

<!-- Lägger in top knappen -->
<button id="topBtn" title="go to top">➜</button>

</body>
</html>
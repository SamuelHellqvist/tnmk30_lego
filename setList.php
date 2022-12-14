<?php 
//inkluderar header
include 'head.txt';

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

    print("<h1 class='titleText'>'$colorName $brickName' can be found in these sets:</h1>");
}

$pagePlus = $page+1;
$pageMinus = $page-1;

print("
        <div class='pageBtns'>
            <a href='setList.php?part=$parts&color=$color&page=$pageMinus'><p>$pageMinus</p></a>
            <p>$page</p>
            <a href='setList.php?part=$parts&color=$color&page=$pagePlus'><p>$pagePlus</p></a>
        </div>");

if($color === '-1'){
    $base =($page-1)*10;
    
    $searchKey = "SELECT inventory.SetID, inventory.Quantity, sets.Setname, sets.SetID, sets.Year, images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg 
    FROM inventory, sets, images WHERE inventory.ItemID='$parts' 
    AND sets.SetID = inventory.SetID 
    AND images.ColorID=inventory.ColorID
    AND images.ItemtypeID=inventory.ItemtypeID
    AND images.ItemID=inventory.ItemID
    LIMIT $base, 10";


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

        if($jpg){
            $filename = 'S' . '/' . $setID . '.jpg';
        }
        else if($gif){
            $filename = 'S' . '/' . $setID . '.gif';
        }
        if($largejpg){
            $filename = 'S' . '/' . $setID . '.jpg';
        }
        else if($largegif){
            $filename = 'S' . '/' . $setID . '.gif';
        }

        //en ruta med information om setet
        $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

            print(
                "<div class='brickinfo'>
                    <section>
                        <h2>$setName</h2>
                        <p>SetID: $setID</p>
                        <p>Year: $year</p>
                        <p>Quantity: $quantity</p>
                    </section>
                    <div class='imgbox'>
                    <a><img src=$imglink onerror='this.onerror=null; this.src=$alt' alt='$setID'></a>
                    </div>
                </div>
                \n
                "
        
            );
    }

}
else{
    $base =($page-1)*10;

    $searchKey ="SELECT sets.SetID, sets.Setname, sets.Year, inventory.ItemID, inventory.ItemtypeID, inventory.Quantity, images.has_gif, images.has_jpg, images.has_largejpg, images.has_largegif, images.ItemID
    FROM sets, inventory, images 
    WHERE sets.SetID = inventory.SetID 
    AND inventory.ItemID = $parts 
    AND inventory.ColorID = $color
    AND sets.SetID = images.ItemID 
    AND images.ItemtypeID = 'S'
    LIMIT $base, 10";

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
            print(
                "<div class='brickinfo'>
                    <section>
                        <h2>$setName</h2>
                        <p>SetID: $setID</p>
                        <p>Year: $year<p>
                        <p>Quantity: </p>
                        <table>
                            <tr>
                                <td>$colorName: </td>
                                <td>$quantity</td>
                            </tr>
                            <tr>
                                <td>All colors: </td>
                                <td>Siffra </td>
                            </tr>
                        </table>
                    </section>
                    <div class='imgbox'>
                    <a><img src=$imglink onerror='this.onerror=null; this.src=$alt' alt='$setID'></a>
                    </div>
                </div>
                \n
                "
        
            );

    }
}
?>

<!-- lägger till top-knappen -->
<button id="topBtn" title="go to top">Top</button>

</body>
</html>
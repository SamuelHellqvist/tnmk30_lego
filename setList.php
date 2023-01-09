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

if($color === '-1'){
    $searchKey = "SELECT inventory.SetID, sets.Setname, sets.SetID, sets.Year, images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg FROM inventory, sets, images WHERE inventory.ItemID='$parts' 
    AND sets.SetID = inventory.SetID 
    AND images.ColorID=inventory.ColorID
    AND images.ItemtypeID=inventory.ItemtypeID
    AND images.ItemID=inventory.ItemID";

    /*$searchKey = "SELECT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
    images.has_gif, images.has_jpg, parts.Partname, colors.ColorID,
    sets.Setname, sets.SetID, inventory.Quantity
    FROM inventory, parts, colors, sets, images WHERE inventory.ItemID=$parts
    AND inventory.ItemtypeID='P'
    AND parts.PartID=inventory.ItemID
    AND sets.SetID=inventory.SetID
    AND colors.ColorID=inventory.ColorID
    AND images.ColorID=inventory.ColorID
    AND images.ItemtypeID=inventory.ItemtypeID
    AND images.ItemID=inventory.ItemID";*/


    $contents = mysqli_query($connection, $searchKey);

    //skapar en loop som skriver ut alla sets som hittas, tills det inte finns några kvar att visa
    while($row = mysqli_fetch_array($contents)){

        $alt = '"images/image.jpg"';
        $setName = $row['Setname'];
        $year = $row['Year'];

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
    /*
    $searchKey = "SELECT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
    images.has_gif, images.has_jpg, images.has_largegif, has_largejpg, parts.Partname, colors.Colorname, colors.ColorID,
    sets.Setname, sets.SetID, inventory.Quantity
    FROM inventory, colors, parts, sets, images WHERE colors.ColorID=$color
    AND inventory.ColorID=colors.ColorID
    AND inventory.ItemID=$parts
    AND inventory.ItemtypeID='P'
    AND inventory.ItemID=parts.PartID
    AND sets.SetID=inventory.SetID
    AND images.ItemtypeID=inventory.ItemtypeID
    AND images.ItemID=inventory.ItemID
    AND images.ColorID=colors.ColorID";
    */

    $searchKey ="SELECT sets.SetID, sets.Setname, sets.Year, inventory.ItemID, inventory.ItemtypeID, images.has_gif, images.has_jpg, images.has_largejpg, images.has_largegif, images.ItemID
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
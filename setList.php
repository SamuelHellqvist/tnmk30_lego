<?php 
include 'head.txt';

if(isset($_GET["part"])){
    $parts = $_GET["part"];
}

if(isset($_GET["color"])){
    $color = $_GET["color"];
}

$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}


if($color === '-1'){
    $findName = "SELECT Partname FROM parts WHERE PartID = '$parts'";
    $nameContent = mysqli_query($connection, $findName);

    $nameRow = mysqli_fetch_array($nameContent);

    $brickName = $nameRow['Partname'];
    print("<h1 class='titleText'>'$brickName' can be found in these sets:</h1>");
}
else{
    $findName = "SELECT parts.Partname, colors.Colorname FROM parts, colors WHERE parts.PartID = $parts AND colors.ColorID = $color";
    $nameContent = mysqli_query($connection, $findName);

    $nameRow = mysqli_fetch_array($nameContent);

    $brickName = $nameRow['Partname'];
    $colorName = $nameRow['Colorname'];

    print("<h1 class='titleText'>'$colorName $brickName' can be found in these sets:</h1>");
}

if($color === '-1'){

    $searchKey = "SELECT inventory.SetID, sets.Setname, sets.SetID, images.has_gif, images.has_jpg FROM inventory, sets, images WHERE inventory.ItemID='$parts' 
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
    while($row = mysqli_fetch_array($contents)){

        $alt = '"images/image.jpg"';
        $setName = $row['Setname'];
        $gif = $row['has_gif'];
        $jpg = $row['has_jpg'];
        $setID = $row['SetID'];

        if($gif){
            $filename = 'S' . '/' . $row['SetID'] . '.gif';
        }
        else if ($jpg){
            $filename = 'S' . '/' . $row['SetID'] . '.jpg';
        }

        $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

            print(
                "<article class='brickinfo'>
                    <section>
                        <h1>$setName</h1>
                        <p>SetID: $setID</p>
                    </section>
                    <div id='imgbox'>
                    <a><img src=$imglink onerror='this.onerror=null; this.src=$alt'></a>
                    </div>
                </article>
                \n
                "
        
            );
    }

}
else{
    
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
    
    $contents = mysqli_query($connection, $searchKey);
    while($row = mysqli_fetch_array($contents)){

        $alt = '"images/image.jpg"';
        $setName = $row['Setname'];
        $setID = $row['SetID'];

        $gif = $row['has_gif'];

        $jpg = $row['has_jpg'];

        

        if($gif){
            $filename = 'S' . '/' . $row['SetID'] . '.gif';
        }
        else{
            $filename = 'S' . '/' . $row['SetID'] . '.jpg';
        }

        $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

            print(
                "<article class='brickinfo'>
                    <section>
                        <h1>$setName</h1>
                        <p>SetID: $setID</p>
                    </section>
                    <div id='imgbox'>
                    <a><img src=$imglink onerror='this.onerror=null; this.src=$alt'></a>
                    </div>
                </article>
                \n
                "
        
            );
            
            $gif = NULL;
    
            $jpg = NULL;

    }
}

//include 'footer.txt';
?>

<button id="topBtn" title="go to top">Top</button>

</body>
</html>
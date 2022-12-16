<?php 
include 'head.txt';
echo $searchResult;
?>

<?php
if(isset($_GET["part"])){
    $parts = $_GET["part"];
    echo($parts);
}

if(isset($_GET["color"])){
    $color = $_GET["color"];
    echo($color);
}

$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

/*$searchKey = "SELECT DISTINCT inventory.SetID, colors.Colorname 
FROM inventory, colors 
WHERE ItemID = $parts 
AND colors.ColorID = $color";*/

$searchKey = "SELECT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
images.has_gif, images.has_jpg, parts.Partname, colors.Colorname, colors.ColorID,
sets.Setname, sets.SetID, inventory.Quantity
FROM inventory, colors, parts, sets, images WHERE colors.ColorID=$color
AND inventory.ColorID=colors.ColorID
AND inventory.ItemID=$parts
AND inventory.ItemtypeID='P'
AND inventory.ItemID=parts.PartID
AND images.ItemtypeID=inventory.ItemtypeID
AND images.ItemID=inventory.ItemID
AND images.ColorID=colors.ColorID
AND sets.SetID=inventory.SetID";


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
                    
                </section>
                <div id='imgbox'>
                <a><img src=$imglink onerror='this.onerror=null; this.src=$alt'></a>
                </div>
            </article>
            \n
            "
    
        );
}
?>
</body>
</html>
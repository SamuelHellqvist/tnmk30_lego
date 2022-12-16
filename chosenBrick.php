<?php 
include 'head.txt';
echo $searchResult;
?>

<p>hej</p>

<?php
if(isset($_GET["part"])){
    $parts = $_GET["part"];
    echo($parts);
}


?>


<?php
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

$check = -1;

$searchKey = "SELECT DISTINCT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
images.has_gif, images.has_jpg, parts.Partname, colors.Colorname
FROM inventory, colors, parts, images WHERE inventory.ItemID = $parts 
AND inventory.ItemtypeID='P'
AND inventory.ItemID=parts.PartID
AND colors.ColorID LIKE inventory.ColorID
AND images.ItemtypeID=inventory.ItemtypeID
AND images.ItemID=inventory.ItemID
AND images.ColorID=colors.ColorID ORDER BY colors.Colorname";



$contents = mysqli_query($connection, $searchKey);


while($row = mysqli_fetch_array($contents)){

    $colorName = $row['Colorname'];
    $color = $row['ColorID'];
    $gif = $row['has_gif'];
    $jpg = $row['has_jpg'];

    if($gif){
        $filename = $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.gif';
    }
    else if ($jpg){
        $filename = $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.jpg';
    }

    $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";
    
    if($color !== $check){
        
        print("
        <article class='brickinfo'>
        <section>
            <a href='setList.php?part=$parts&color=$color'><h1>$colorName</h1></a>
            
            
        </section>
        <div id='imgbox'>
        <a href='setList.php?part=$parts&color=$color'><img src=$imglink alt=$brickName></a>
        </div>
    </article>
    \n
    

        ");
    }
    $check = $color;
}

?>

</body>
</html>
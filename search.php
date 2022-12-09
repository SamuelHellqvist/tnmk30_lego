<?php
    include 'head.txt';
?>

<?php
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

$searchResult = $_GET['searchResult'];
echo $searchResult;



//Make sure spaces are removed on search term and in partname from server
$searchKey = 
"SELECT DISTINCT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
images.has_gif, images.has_jpg, parts.Partname
FROM inventory, colors, parts, images WHERE parts.Partname LIKE '%$searchResult%' 
AND inventory.ItemtypeID='P'
AND inventory.ItemID=parts.PartID
AND colors.ColorID=inventory.ColorID
AND images.ItemtypeID=inventory.ItemtypeID
AND images.ItemID=inventory.ItemID
AND images.ColorID=colors.ColorID
"; 

$contents = mysqli_query($connection, $searchKey);

$check = -1;

while($row = mysqli_fetch_array($contents)){
    $color = $row['Colorname'];
    $colorID = $row['ColorID'];
    $brickName = $row['Partname'];
    $brickId = $row['ItemID'];

    $gif = $row['has_gif'];
    $jpg = $row['has_jpg'];

    if($gif){
        $filename = $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.gif';
    }
    else if ($jpg){
        $filename = $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.jpg';
    }

    $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

    if($brickId !== $check){
    $hej = '1';
    print(
        "<article class='brickinfo'>
            <section>
                <a href='chosenBrick.php?part=$brickId'><h1>$brickName</h1></a>
                <p>
                    $brickId
                    $colorID
                </p>
                
            </section>
            <div id='imgbox'>
            <a href='chosenBrick.php?part=$brickId'><img src=$imglink alt=$brickName></a>
            </div>
        </article>
        \n
        "

    );
    $check = $brickId;
    }
}

?>
<button id="topBtn" title="go to top">Top</button>

</body>

</html>
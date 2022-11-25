<?php
    include 'head.txt';
?>

<?php
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

$searchKey = 
"SELECT inventory.Quantity, inventory.ItemtypeID, inventory.ItemID, inventory.ColorID, 
images.has_gif, images.has_jpg, colors.Colorname, parts.Partname 
FROM inventory, colors, parts, images WHERE inventory.SetID='375-2' 
AND inventory.ItemtypeID='P'
AND colors.ColorID=inventory.ColorID 
AND parts.PartID=inventory.ItemID 
AND images.ItemtypeID=inventory.ItemtypeID 
AND images.ItemID = inventory.ItemID 
AND images.ColorID = inventory.ColorID";

$contents = mysqli_query($connection, $searchKey);

while($row = mysqli_fetch_array($contents)){
    $color = $row['Colorname'];
    $brickName = $row['Partname'];
    $brickId = $row['ItemID'];
    print(
        "<article class='brickinfo'>
            <section>
                <h1>$brickName</h1>
                <p>
                    $brickId
                </p>
            </section>
            <div id='imgbox'>
            <img src='images/image.jpg'>
            </div>
        </article>
        \n
        "
        
    );
}




?>


</body>

</html>
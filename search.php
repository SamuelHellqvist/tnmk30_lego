<?php
    include 'head.txt';
?>

<?php
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}
// $searchResult = $_GET['searchResult'];

//form validation, blir inte körbar kod utan html format
$searchResult = htmlspecialchars($_GET['searchResult']);
//ta bort alla whitespaces
// $searchResult = str_replace(' ', '', $searchResult);

print("<h1 class='titleText'>Choose type of brick</h1>");

print("<p class='subTitleText'>Currently displaying search results for: $searchResult</p>");


/*<?php echo "Text"; ?>*/

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

$count = 0;

while($row = mysqli_fetch_array($contents)){

    $count++;
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
    print(
        "<div class='brickinfo'>
            <section>
                <a href='chosenBrick.php?part=$brickId'><h2>$brickName</h2></a>
                <p>
                   PartID: $brickId
                </p>
                
            </section>
            <div class='imgbox'>
            <a href='chosenBrick.php?part=$brickId'><img src=$imglink alt='$brickId'></a>
            </div>
        </div>
        \n
        "

    );
    $check = $brickId;
    }
}
if($count === 0){
    print("
        <div class='noResults'>
            <h2>Your search '$searchResult' did not match any of the bricks in our database</h2>
            <p>Sorry buddie :( </p>
            <p>Suggestions to find results:</p>
            <ul>
                <li>Make sure that all words are spelled correctly</li>
                <li>Try different words all together</li>
            </ul>
            <p>Suggested searches:</p>
            <ul>
                <li>Brick 2 x 2</li>
                <li>Baseplate</li>
                <li>Hinge brick</li>
            </ul>
        </div>
    
    ");
}

?>
<button id="topBtn" title="go to top">Top</button>

</body>

</html>
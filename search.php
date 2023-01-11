<?php
    //inkluderar header
    include 'head.txt';
?>

<?php

//skapar connection för att kunna koppla upp mot hemisdan
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

//form validation, blir inte körbar kod utan html format
$searchResult = htmlspecialchars($_GET['searchResult']);
//ta bort alla whitespaces
// $searchResult = str_replace(' ', '', $searchResult);

print("<h1 class='titleText'>Choose type of brick</h1>");

print("<p class='subTitleText'>Currently displaying search results for: $searchResult</p>");

$searchKey = 
"SELECT DISTINCT inventory.ColorID, inventory.ItemtypeID, inventory.ItemID, 
images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg, parts.Partname
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

//sätter en varianle count till 0
$count = 0;

while($row = mysqli_fetch_array($contents)){

    //lägger till ett på count varje gång en ny bit som matchar sökordet visas
    $count++;
    $color = $row['Colorname'];
    $colorID = $row['ColorID'];
    $brickName = $row['Partname'];
    $brickId = $row['ItemID'];

    $gif = $row['has_gif'];
    $jpg = $row['has_jpg'];    $largegif = $row['has_largegif'];

    $largejpg = $row['has_largejpg'];

    //hittar rätt bild beroende på vilken typ av bild biten har
    if($largejpg){
        $filename = $row['ItemtypeID'] . 'L' . '/' . $row['ItemID'] . '.jpg';
    }
    else if ($largegif){
        $filename =  $row['ItemtypeID'] . 'L' . '/' . $row['ItemID'] . '.gif';
    }
    else if ($jpg){
        $filename =  $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.jpg';
    }
    else if ($gif){
        $filename =  $row['ItemtypeID'] . '/' . $row['ColorID'] . '/' . $row['ItemID'] . '.gif';
    }

    $imglink = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$filename";

    //sätter att biten bara ska visas om den är skilt från check
    if($brickId !== $check){
    print(
        "<div class='brickinfo'>
            <section>
                <a href='chosenBrick.php?part=$brickId&page=1'><h2>$brickName</h2></a>
                <p>
                   PartID: $brickId
                </p>
                
            </section>
            <div class='imgbox'>
            <a href='chosenBrick.php?part=$brickId&page=1'><img src=$imglink alt='$brickId'></a>
            </div>
        </div>
        \n
        "

    );

    $pageCounter++;
    //sätter check till det nuvarande partID för att säkerställa att en bit aldrig kan visas två gånger
    $check = $brickId;
    }
}

//om count förblir 0 så har inga biter hittats och ett meddelande visas för användaren för att ge tips på hur man kan söka 
//för att få bra resultat. Detta är till för att öka användarvönligheten
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
<!-- lägger till top-knappen -->
<button id="topBtn" title="go to top">➜</button>

</body>

</html>
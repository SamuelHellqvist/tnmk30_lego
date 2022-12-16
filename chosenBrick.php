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

<section class="container">

<?php
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

$check = -1;

$searchKey = "SELECT DISTINCT inventory.SetID, colors.Colorname FROM inventory, colors WHERE ItemID = $parts AND colors.ColorID = inventory.ColorID"; 

$contents = mysqli_query($connection, $searchKey);


while($row = mysqli_fetch_array($contents)){
    $set = $row['SetID'];
    $color = $row['Colorname'];

    if($check !== $set){
        print("

        <div class='setinfo'>
        <h1>$set<h1>
        <h2>$color</h2>
        </div>
        
        ");
}
$check = $set;
}
?>

</section>

</body>
</html>
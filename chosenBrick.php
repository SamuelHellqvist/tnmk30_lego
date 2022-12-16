<?php 
include 'head.txt';
echo $searchResult;
?>

<p>hej</p>

<section class="container">
<?php
if(isset($_GET["part"])){
    $parts = $_GET["part"];
    echo($parts);
}

$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}


$searchKey = 
"SELECT * FROM inventory WHERE ItemID = '3003'";

$contents = mysqli_query($connection, $searchKey);

while($row = mysqli_fetch_array($contents)){
    print("
        <div class='test'>
        helloj
        </div>
    ")
}
?>

</section>

</body>
</html>
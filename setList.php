<?php 
include 'head.txt';
echo $searchResult;
?>

<?php
if(isset($_GET["part"])){
    $parts = $_GET["part"];
    echo($parts);
    echo($color);
}

?>

<section class="container">

<?php
$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego");

if (!$connection){
    die('MySQL connection error');
}

?>
</body>
</html>
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

</body>
</html>
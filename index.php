<?php 
if($_SERVER['REQUEST_URI'] === "/" || $_SERVER['REQUEST_URI'] === "/index.php"){
    header('Location: ./components/Homepage/homepage.php');
//echo "<h1>Hello World!</h1>";

}
    

?>
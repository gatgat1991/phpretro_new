<?php
$pdo = new PDO('mysql:host=localhost;dbname=playfirs1_habb0', 'playfirs1_habb0', 'XOPB4Xfhb1vP');
 
$statement = $pdo->prepare("SELECT * FROM users WHERE username = ? ");
$statement->execute(array('gatgat'));   
while($row = $statement->fetch()) {
   echo $row['username']."<br />";
   echo "E-Mail: ".$row['mail']."<br /><br />";
}
?>
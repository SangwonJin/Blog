<?php
$dbLink = new mysqli('localhost', 'inclass', 'secret', 'simpleblog');
if (!$dbLink) {
    die("Connection failed:" . $dbLink->error());
}

$sql = 'SELECT id, fname, lname FROM authors WHERE id > 0';
$result = $dbLink->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "ID: ", $row['id'], " First Name: ", $row['fname'], " Last Name: ", $row['lname'], "<br>";
}
$result->close();
//Close the connection

$dbLink->close();
?>

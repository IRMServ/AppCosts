<?php
//$conn = new mysqli("186.202.152.344","irmservices44","###","irmservices4");
$conn = new mysqli("localhost","irmdocumentatios","###","irmdocumentatios");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

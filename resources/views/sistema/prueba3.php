<?php 

$campo1 = "Jorge ";
$campo2 = "Conde";

$result = array("result"=>"OK", "valor"=> 'el campo 1 es: '.$campo1 . ' y el campo 2 es: ' . $campo2);

echo json_encode($result);
?>
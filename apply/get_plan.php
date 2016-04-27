<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
include "../common.php";
include _BASE_DIR."/lib/business.php";

$num_ = $_GET['num_'];
$sql="SELECT * FROM plan WHERE pla_idx = '".$num_."'";
#var_dump($sql);

$result = $connect->query($sql);
#$result = mysqli_query($con,$sql);

$row = mysqli_fetch_array($result);
    $pla_name = $row['pla_name'];
    $pla_date = $row['pla_date'];
    $pla_place = $row['pla_place'];
    $pla_time = $row['pla_time'];
    $pla_distance = $row['pla_distance'];
    // $json_arr= array("pla_date"=>$pla_date,"pla_place"=>$pla_place,"pla_time"=>$pla_time,"pla_distance"=>$pla_distance);

     // $data['pla_date'] = $row['pla_date'];
     // $data['pla_place'] = $row['pla_place'];
     // $data['pla_time'] = $row['pla_time'];
     // $data['pla_distance'] = $row['pla_distance']; 

    echo  $pla_date .",". $pla_place.",".$pla_time.",". $pla_name.",".$pla_distance;    

    
#header("Content-Type:application/json",true);
    echo json_encode($json_arr);



mysqli_close($connect);
?>
</body>
</html>
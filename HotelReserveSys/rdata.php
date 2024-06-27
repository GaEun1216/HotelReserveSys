<?php
    header("Content-Type: application/json");

    include './dbconnect.php';
    $place = $_POST['place'];
    $sort = $_POST['sort'];//정렬 기준


    if($sort=='date')
      $q = "SELECT * FROM review where hotel_id = '".$place."' order by review_id desc";

    if($sort=='desc')
      $q = "SELECT * FROM review where hotel_id = '".$place."' order by rate desc";


    $res = mysqli_query($conn,$q);//데이터 베이스와 연결 ->conn에 대해서는 dbconnect.php에 서술
    mysqli_error($conn);
    $result = array();
    //가능하면 hotel_room 테이블에 접근하여 방의 이름 반환하고 싶으나 지금은 구현 X
    while($row = mysqli_fetch_array($res)){
      array_push($result, array('review_id'=>$row['review_id'],'room_id'=>$row['room_id'],'review'=>$row['review'],'member_id'=>$row['member_id'],'rate'=>$row['rate']));
    }
    echo json_encode(array("result"=>$result),JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
?>

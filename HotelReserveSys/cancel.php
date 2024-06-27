<?
    include './dbconnect.php';

    $number = $_POST['order_num'];
    echo $number;
    $q = "SELECT * FROM reserve_room WHERE reserve_id='$number'";
    $result = mysqli_query($conn,$q);//데이터 베이스와 연결 ->con에 대해서는 connect.php에 서술
    mysqli_error($conn);
    $row = mysqli_fetch_array($result);


    // member 수정
    $query = "update member set frequency=frequency-1 where id='{$row['id']}'";
    mysqli_query($conn, $query);
    // 회원 등급 수정
    $query = "select frequency from member where id='{$row['id']}'";
    $result = mysqli_query($conn, $query);
    $frequency = mysqli_fetch_assoc($result);
    if ($frequency['frequency']>=15){
      $query = "update member set class='VIP' where id='{$row['id']}'";
      mysqli_query($conn, $query);
    }
    else if ($frequency['frequency']>=10) {
      $query = "update member set class='GOLD' where id='{$row['id']}'";
      mysqli_query($conn, $query);
    }
    else {
      $query = "update member set class='SILVER' where id='{$row['id']}'";
      mysqli_query($conn, $query);
    }

    $can = "DELETE FROM reserve_room WHERE reserve_id = '$number'";//삭제 수행

    mysqli_query($conn,$can);//방 예약 취소
?>
<script>
alert("예약이 취소되었습니다.");
</script>
<meta http-equiv="refresh" content="0;url=select_hotel.php" />

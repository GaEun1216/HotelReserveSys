<?
    include './dbconnect.php';

    $number = $_POST['order_num'];

    $can = "DELETE FROM reserve_banquet WHERE reserve_id = '$number'";//삭제 수행
    mysqli_query($conn,$can);//연회장 예약 취소
?>
<script>
alert("예약이 취소되었습니다.");
</script>
<meta http-equiv="refresh" content="0;url=select_hotel.php" />

<html>
<head>
<title>Order_inform</title>
<div align="right" class="mode_change">
  <input align="right" type="button" name="change_mode" value="메인화면" onclick="location.href='select_hotel.php'">
</div>
</head>
<div align='center'>
<?php
    include './dbconnect.php';

    ini_set('display_errors', '0');//오류 메시지를 숨겨줌

    $number = $_POST['order_num'];

    $q = "SELECT * FROM reserve_banquet WHERE reserve_id=$number";
    $result = mysqli_query($conn,$q);//데이터 베이스와 연결 ->con에 대해서는 connect.php에 서술
    mysqli_error($conn);
    $row = mysqli_fetch_array($result);

    if(!isset($row)){
      echo "<script>alert(\"해당 주문번호를 조회할 수 없습니다. 번호를 다시 확인해주세요.\");</script>";
      exit();
    }

    $mem = "SELECT * FROM member WHERE id='{$row['id']}'";
    $mem_res = mysqli_query($conn,$mem);
    $row_m = mysqli_fetch_array($mem_res);
    $real = $row_m['name'];

    //서울일때 미팅룸 !!! 미팅룸 예약 날짜가 회원 예약 테이블의 날짜에 포함되면 출력
    $meet = "SELECT * from reserve_meetingroom WHERE member_id = '{$row['id']}'";
    $meet_res = mysqli_query($conn,$meet);
    $row_mt = mysqli_fetch_array($meet_res);
    ?>
    <html>
    <article>
    <table class="list-table" border="1">
      <tr align='center'><td>예약 내역<br>
      <?
        echo "이용 목적 : {$row['wedding_or_banquet']}<br>";
        echo "예약 날짜 : {$row['day']}<br>";//hotel_room 테이블의 roo_name 출력

        echo "###결제 내역###<br>";
        echo  "총 가격  : 500000";
    // ?>
  </td>
</table>
  </article>
  <form method = "post" action = 'banquet_cancel.php'>
    <input type="hidden" name = "order_num" value="<?=$number?>">
    <p></p>
    <input type="submit" value="예약 취소하기">
  </div>
    </html>
    <?
    //예약 취소하기 기능 및 결제내역
    mysqli_error($conn);
 ?>

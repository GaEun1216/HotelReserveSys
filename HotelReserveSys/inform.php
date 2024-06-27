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

    $q = "SELECT * FROM reserve_room WHERE reserve_id='$number'";
    $result = mysqli_query($conn,$q);//데이터 베이스와 연결 ->con에 대해서는 connect.php에 서술
    mysqli_error($conn);
    $row = mysqli_fetch_array($result);

    $room = "SELECT * FROM hotel_room WHERE hotel_id='$row[hotel_id]' and room_id='$row[room_num]'";
    $room_res = mysqli_query($conn,$room);
    $row2 = mysqli_fetch_array($room_res);

    if(!isset($row)){
      echo "<script>alert(\"해당 주문번호를 조회할 수 없습니다. 번호를 다시 확인해주세요.\");</script>";
      exit();
    }
    //이름 출력하려고 사용한 쿼리인데, 비회원인경우 생략해야함.
    $mem = "SELECT * FROM member WHERE id='{$row['id']}'";
    $mem_res = mysqli_query($conn,$mem);
    $row_m = mysqli_fetch_array($mem_res);
    $real = $row_m['name'];

    //서울일때 미팅룸 !!! 미팅룸 예약 날짜가 회원 예약 테이블의 날짜에 포함되면 출력
    if($row['hotel_id']=='seoul'){
    $meet = "SELECT * from reserve_meetingroom WHERE reserve_date<='{$row['check_out']}' and reserve_date >='{$row['check_in']}' and member_id = '{$row['id']}'";
    $meet_res = mysqli_query($conn,$meet);
    $row_mt = mysqli_fetch_array($meet_res);
  }

    //제주일때 웨딩 or 연회!!
    if($row['hotel_id']=='jeju'){
    $banq = "SELECT * from reserve_banquet WHERE day<='{$row['check_out']}' and day >='{$row['check_in']}' and member_id = '{$row['id']}'";
    $banq_res = mysqli_query($conn,$banq);
    $row_bq = mysqli_fetch_array($banq_res);
  }

    if(''==$row['id'])
        $real = "비회원";

    if($number==$row['reserve_id'])
        echo "$real({$row['id']})님의 {$number} 주문 정보입니다.<br><br>";

    //주문 정보가 조회되도록 설정
    ?>
    <html>
    <article>
    <table class="list-table" border="1">
      <tr><td>예약 내역<br>
        <?
    echo "지점 : {$row['hotel_id']}<br>";
    echo "호텔 번호 : {$row['room_num']} ({$row2['room_name']})<br>";//hotel_room 테이블의 roo_name 출력
    echo "총 인원 : {$row['num_peo']}<br>";

    $day = (strtotime($row['check_out'])-strtotime($row['check_in']))/86400 + 1;//일 수로 반환
    $sleep = $day-1;
    echo "이용기간 : {$row['check_in']} ~ {$row['check_out']} (총 {$sleep}박 {$day} 일) <br>";

    echo "###결제 내역###<br>";
    $sum = $day * $row2['price'];
    echo  "총 가격  : {$sum}"
    ?>
  </td>
</table>
  </article>


  <form method = "post" action = 'cancel.php'>
    <input type="hidden" name = "order_num" value="<?=$number?>">
    <p></p>
    <input type="submit" value="예약 취소하기">
  </form><form method = "post" action = 'review_write.php'>
    <input type="hidden" name = "order_num" value="<?=$number?>">
    <input type="submit" value="리뷰 남기기">
  </form>
  </div>
    </html>
    <?
    //예약 취소하기 기능 및 결제내역
    mysqli_error($conn);
 ?>

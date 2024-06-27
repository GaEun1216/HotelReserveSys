<?
  session_start();
  include './dbconnect.php';

  $num_peo = $_GET['num_people'];
  $check_in = $_GET['check_in'];
  $check_out = $_GET['check_out'];
  $room_num = $_POST['room_num'];
  $hotel_id = $_GET['hotel_id'];
  $member_id = '';
  if (isset($_SESSION['user_id'])){
    $member_id = $_SESSION['user_id'];
  }

  // 예약하는 방의 price 추출
  $query = "select price from hotel_room where hotel_id='$hotel_id' and room_id=$room_num";
  $result = mysqli_query($conn, $query);
  $price = mysqli_fetch_assoc($result);

  // 예약 사항을 payment 추가
  $in_date = new DateTime($check_in);
  $out_date = new DateTime($check_out);
  $day = $out_date->diff($in_date)->format("%a");
  if (isset($_SESSION['user_id'])) {
    $query = "insert into payment values(NULL, '$hotel_id', $price[price]*$day, '$member_id', $room_num)";
  }
  else {
    $query = "insert into payment values(NULL, '$hotel_id', $price[price]*$day, NULL, $room_num)";
  }
  mysqli_query($conn, $query);

  // reserve_room에 예약 사항 추가
  if (isset($_SESSION['user_id'])) {
    $query = "insert into reserve_room values ('0', '$hotel_id', '$check_in', '$member_id', '$check_out', $room_num, $num_peo);";
  }
  else { // 로그인하지 않았으면 ID에 NULL값을 넣습니다
    $query = "insert into reserve_room values ('0', '$hotel_id', '$check_in', NULL, '$check_out', $room_num, $num_peo);";
  }
  mysqli_query($conn, $query);

  // 회원인 경우 member 테이블 업데이트
  if (isset($_SESSION['user_id'])){
    // member 업데이트
    $query = "update member set frequency=frequency+1 where id='$member_id'";
    mysqli_query($conn, $query);
    // 회원 등급 업데이트
    $query = "select frequency from member where id='$member_id'";
    $result = mysqli_query($conn, $query);
    $frequency = mysqli_fetch_assoc($result);
    // 15번 이상 이용하면 VIP
    if ($frequency['frequency']>=15){
      $query = "update member set class='VIP' where id='$member_id'";
      mysqli_query($conn, $query);
    }
    // 10번 이상 이용하면 GOLD
    else if ($frequency['frequency']>=10) {
      $query = "update member set class='GOLD' where id='$member_id'";
      mysqli_query($conn, $query);
    }
    // 그 이하는 SILVER
    else {
      $query = "update member set class='SILVER' where id='$member_id'";
      mysqli_query($conn, $query);
    }
  }

  // 예약 번호 추출
  $query1 = "select * from reserve_room where hotel_id like '$hotel_id' and check_in='$check_in' and room_num=$room_num ORDER BY reserve_id DESC";
  $result = mysqli_query($conn, $query1);
  $row = mysqli_fetch_assoc($result);

  echo "<center>
          <h1>예약 완료!</h1>
          <p>예약 번호: $row[reserve_id]</p>";
  if(isset($_SESSION['user_id']))
    echo "<p>{$member_id}님의 예약이 완료되었습니다.</p>";
  else
    echo "<p>비회원이므로 예약 번호를 기억해두세요.</p>";
  echo "<a href='./order_num.php'><div>예약 확인하기</div></a>";

?>

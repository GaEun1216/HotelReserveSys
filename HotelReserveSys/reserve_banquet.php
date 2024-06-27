<?
  session_start();
  include './dbconnect.php';

  $member_id = $_SESSION['user_id'];
  $reserve_date = $_GET['date'];
  $reason = $_GET['select_reason'];

  // reserve_banquet에 추가
  $query = "insert into reserve_banquet values (NULL, '$reason', '$member_id', '$reserve_date');";
  mysqli_query($conn, $query);

  // payment에 추가
  $query = "insert into payment values(NULL, '$reason', 500000, '$member_id', NULL)";
  mysqli_query($conn, $query);

  // 예약 번호 추출하기
  $query1 = "select * from reserve_banquet where wedding_or_banquet='$reason' and day='$reserve_date' and member_id='$member_id' ORDER BY reserve_id DESC LIMIT 1 ";
  $result = mysqli_query($conn, $query1);
  $row = mysqli_fetch_assoc($result);

  echo "<center>
          <h1>웨딩&연회 예약 완료!</h1>
          <p>웨딩&연회 예약 번호: $row[reserve_id]</p>
          <a href='./select_hotel.php'><div>예약 확인하기(임시 메인화면 설정)</div></a>";
?>

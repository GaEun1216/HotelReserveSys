<?
  session_start();
  include './dbconnect.php';
  $member_id = $_SESSION['user_id'];

  $meetingroom_id = $_GET['meetingroom_id'];
  $time = $_GET['time'];
  $reserve_date = $_GET['reserve_date'];

  # 예약하는 미팅룸의 price 추출
  $query = "select price from meetingroom where meetingroom_id=$meetingroom_id";
  $result = mysqli_query($conn, $query);
  $price = mysqli_fetch_assoc($result);

  # 예약 사항을 payment 추가
  $query = "insert into payment values(NULL, 'meetingroom', $price[price], '$member_id', NULL)";
  mysqli_query($conn, $query);

  # reserve_meetingroom 예약 추가
  $query = "insert into reserve_meetingroom values (NULL, $meetingroom_id, '$member_id', $time, '$reserve_date');";//null값이 reserve_id
  mysqli_query($conn, $query);

  # 예약 번호 추출
  $query1 = "select * from reserve_meetingroom where meetingroom_id=$meetingroom_id and reserve_date='$reserve_date' and time=$time";
  $result = mysqli_query($conn, $query1);
  $row = mysqli_fetch_assoc($result);

  echo "<center>
          <h1>미팅룸 예약 완료!</h1>
          <p>미팅룸 예약 번호: $row[reserve_id]</p>
          <a href='./select_hotel.php'><div>예약 확인하기(임시 메인화면 설정)</div></a>";
?>

<html>
<head>
<title>Order</title>
<div align="right" class="mode_change">
  <input align="right" type="button" name="change_mode" value="메인화면" onclick="location.href='select_hotel.php'">
</div>
</head>
</html>
<?php //만약 세션이 있을 시 여기로 넘어오도록 만들기
  session_start();
  include './dbconnect.php';

  ini_set('display_errors', '0');//오류 메시지를 숨겨줌

  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
  $pw = $_SESSION['user_password'];

  if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
  $q = "SELECT * FROM member WHERE id='$user_id' and password='$pw'";
  $result = mysqli_query($conn,$q);//데이터 베이스와 연결 ->con에 대해서는 connect.php에 서술
  mysqli_error($conn);
  $row = mysqli_fetch_array($result);

  echo "<div align='center'>";
  if($user_id==$row['id']&&$pw==$row['password']){//아이디와 비밀번호가 일치하면 연결
    echo "{$row['name']} 고객님이 조회할 수 있는 예약 번호 목록입니다.<br>";//목록 뜨도록
    $q2 = "SELECT * FROM RESERVE_ROOM WHERE ID='$user_id'";
    $result = mysqli_query($conn,$q2);
    mysqli_error($conn);
    while($row2 = mysqli_fetch_array($result)){
      if($user_id==$row2['id']){
        echo "예약 번호 : ". $row2['reserve_id'];//주문 조회
        $b = $row2['reserve_id'];
      ?>
      <html>
      <div>
        <form method = "post" action = 'inform.php'>
          <input button type='submit' value = '예약 조회'/>
          <input type="hidden" name = "order_num" value="<?=$row2['reserve_id']?>">
        </form>
      </div>
        </html>
        <?php
      }
    }
    ?>
    <div align='center'>
      <p>------------미팅룸 예약 목록입니다------------</p>
      <?
        $query = "select * from reserve_meetingroom where member_id='$user_id'";
        $result = mysqli_query($conn, $query);
        while($row2 = mysqli_fetch_array($result)) {
          echo "예약 번호 : ". $row2['reserve_id'];//주문 조회
          ?>
          <form method = "post" action = 'meetingroom_inform.php'>
            <input button type='submit' value = '예약 조회'>
            <input type="hidden" name = "order_num" value="<?=$row2['reserve_id']?>">
          </form>
          <?
          }
      ?>
      <p>------------연회장 예약 목록입니다------------</p>
      <?
        $query = "select * from reserve_banquet where member_id='$user_id'";
        $result = mysqli_query($conn, $query);
        while($row2 = mysqli_fetch_array($result)) {
          echo "예약 번호 : ". $row2['reserve_id'];//주문 조회
        ?>
        <form method = "post" action = 'banquet_inform.php'>
          <input button type='submit' value = '예약 조회'>
          <input type="hidden" name = "order_num" value="<?=$row2['reserve_id']?>">
        </form>
        <?
        }
      ?>
    </div>
  <?
  }
}else{?>
</div>
<html>
<script>
function receipt(){
  if(!document.notlogin_form.order_num.value){
    alert('주문번호를 입력해주세요.');
    document.notlogin_form.order_num.focus();
    return;
  }
  document.notlogin_form.submit();
}
</script>
<head>
  <title>login-order number</title>
  <meta charset="utf-8">
</head>
<body>
  <form name="notlogin_form" method="post" action="inform.php">
  <center>
  <div align='center'>
    <label>주문 번호를 입력하면 해당 주문의 예약 정보를 보여드립니다.<br><br></label>
    <label for="order_num">주문 번호</label>
    <input type="text" name="order_num"/>
    <p></p>
  </div>
  <div class="button">
    <input type="button" value="check" onClick="receipt()">
  </div>
</center>
</form>
</html>
<?}?>

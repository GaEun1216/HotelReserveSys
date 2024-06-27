<?php session_start(); ?>
<!DOCTYPE html>
<html lang="kor" dir="ltr">
<script>
// 비회원인 경우 미팅룸을 예약할 수 없다는 알려주는 함수
function meeting(){
  <?
    // 세션 관련한 에러를 catch합니다
    set_error_handler('exceptions_error_handler');

    function exceptions_error_handler($severity, $message, $filename, $lineno) {
      if (error_reporting() == 0) {
        return;
      }
      if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
      }
    }

    $user_id = '';
    try {
      if ($_SESSION['user_id']) {
        $user_id=$_SESSION['user_id'];
      }
    } catch(Exception $e) {}
  ?>
  var userid = '<?= $user_id?>';
  if(userid==='')
    alert("비회원일시 미팅룸을 이용하실 수 없습니다");
  else
      location.href='meetingroom.php'
}
</script>
  <head>
    <meta charset="utf-8">
    <title>Seoul</title>
    <div align="right" class="mode_change">
      <!-- 로그인이 되었는지 알려줍니다 -->
      <?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
                  $user_id = $_SESSION['user_id'];
                  $user_name = $_SESSION['user_name'];
                  echo "<p><strong>$user_name</strong>($user_id)님 환영합니다.";
                  ?><input align="right" type="button" name="login" value="로그아웃" onclick="location.href='login.php'"><?
              }
          else{?>
      <input align="right" type="button" name="login" value="로그인" onclick="location.href='login.php'"><?}?>
      <input align="right" type="button" name="change_mode" value="메인화면" onclick="location.href='select_hotel.php'">
    </div>
    <h1><center>SEOUL</center></h1>
    <span><center>서울점에 오신 것을 환영합니다 </center></span>
  </head>
  <body>
    <div align="center" class="choose_button">
      <p>아래의 메뉴를 골라주세요</p>
      <input type="button" name="reserve_room" value="방 예약하기" onclick="location.href='reserve_seoul_room.php'">
      <input type="button" name="reserve_meeting" value="미팅룸 예약하기" onclick= meeting()>
      <input type="button" name="confirm_reserve" value="예약 확인하기" onclick="location.href='order_num.php';">
      <input type="button" name="seoul_review" value="리뷰" onClick = "location.href='review.php'">
    </div>
  </body>
</html>

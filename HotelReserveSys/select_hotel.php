<?php session_start();

?>
<html>
<body>
  <div align="right">
    <!-- 로그인 되었는지 알려줍니다 -->
    <?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
                $user_id = $_SESSION['user_id'];
                $user_name = $_SESSION['user_name'];
                echo "<p><strong>$user_name</strong>($user_id)님 환영합니다.";
                ?><input align="right" type="button" name="login" value="로그아웃" onclick="location.href='login.php'"><?
            }
        else{?>
    <input align="right" type="button" name="login" value="로그인" onclick="location.href='login.php'"><?}?>
    <input align="right" type="button" name="change_mode" value="관리자 모드" onclick="location.href='sales_pie.php'">
  </div>

  <div class="main_page" align="center">
    <title>select hotel</title>
    <h1>호텔 지점을 선택하세요</h1>
    <input type="button" name="select_jeju" value="제주점" onclick="location.href='jeju.php'">
    <input type="button" name="select_seoul" value="서울점" onclick="location.href='seoul.php'" width="500px">
  </div>
</body>
</html>

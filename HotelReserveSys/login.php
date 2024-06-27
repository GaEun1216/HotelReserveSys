<?php session_start(); ?>
<html>
<script>
// 아이디나 비밀번호를 입력하지 않으면 입력하라는 알림이 생김
function receipt(){
  if(!document.login_form.user_id.value){
    alert('ID를 입력해주세요.');
    document.login.form.user_id.focus();
    return;
  }
  if(!document.login_form.user_password.value){
    alert('PASSWORD를 입력해주세요.');
    document.login_form.user_password.focus();
    return;
  }
  document.login_form.submit();
}
</script>
  <head>
    <title>login page</title>
    <meta charset="utf-8">
  </head>
  <body>
        <?if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])){?>
    <div class="login" align="center">
      <h1>로그인</h1>
      <form name= "login_form" method="post" action="/login_check.php">
        <div>
          <label for="id">ID</label>
          <input type="text" name="user_id"/>
        </div>
        <div>
          <label for="pw">PW </label>
          <input type="password" name="user_password"/>
        </div>

        <div class="login_button">
          <input type="button" value="Login" onClick="receipt()">
          <!-- <button type="submit"> login </button> -->
        </div>
      </form>
    </div>
    <?}else{
    session_destroy();
?>
<meta http-equiv="refresh" content="0;url=select_hotel.php" />
<?}?>
  </body>
</html>

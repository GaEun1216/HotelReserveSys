<?php
    include './dbconnect.php';

    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_password'];
    //임시 방편 나중에 조회하도록 설정

    $q = "SELECT * FROM member WHERE id='$user_id' and password='$user_pw'";
    $result = mysqli_query($conn,$q);//데이터 베이스와 연결 ->con에 대해서는 connect.php에 서술
    mysqli_error($conn);
    $row = mysqli_fetch_array($result);
    if($user_id==$row['id']&&$user_pw==$row['password']){
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_password']=$user_pw;
      }
      //header("location:".$prevPage);*/
      ?>
<script>
   history.go(-2); // -2, -3 등의 숫자로 이전 페이지 이동가능
</script>
<meta http-equiv="refresh" content="0;url=select_hotel.php" />

<?
  // 미팅룸의 에약 가능한 시간을 보여줍니다
  session_start();
  include './dbconnect.php';

  $reserve_date = $_GET['reserve_date'];
  $meetingroom_id = $_GET['meetingroom_id'];
  $member_id = $_SESSION['user_id'];
?>

<script type="text/javascript">
  // 조회하고 예약하는 버튼의 form을 제출할 때 실행하는 함수
  function send(a, f) {
    // a는 조회하기 버튼인지 예약하기 버튼의 반응인지
    var reserve_date = document.getElementsByName('reserve_date')[0].value;
    var meetingroom_id = document.getElementsByName('meetingroom_id')[0].value;
    var time = document.getElementsByName('time')[0].value;
    // 조회하기를 누르면 해당 날짜와 미팅룸의 예약 가능한 시간을 보여줍니다
    if (a=='1') {
      var link = "update_table_meetingroom.php?reserve_date="+reserve_date+"&meetingroom_id="+meetingroom_id;
      f.action=link;
    }
    // 예약하기를 누르면 미팅룸의 예약합니다
    else {
      var link = "reserve_meetingroom.php?reserve_date="+reserve_date+"&meetingroom_id="+meetingroom_id+"&time="+time;
      f.action=link;
    }

    f.submit();
  }

  // 날짜나 미팅룸이 변할 때 새로고침해서 변화된 값을 form에 전달하도록 하는 함수
  function reload(){
    var reserve_date = document.getElementsByName("reserve_date")[0].value;
    var meetingroom_id = document.getElementsByName("meetingroom_id")[0].value;
    location.href='./update_table_meetingroom.php?reserve_date='+reserve_date+'&meetingroom_id='+meetingroom_id;
  }
</script>

<!DOCTYPE html>
<html lang="kor" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>reserve meeting room</title>
  </head>

  <body>
    <div align='center'>
      <h1>미팅룸 예약하기</h1>
      <form class="reserve" method="post">
        <label for="date_label">날짜 : </label>
        <input type="date" name="reserve_date" value=<?echo $reserve_date;?> onchange="reload();">
        <label for="num_of_people">미팅룸 : </label>
        <select name="meetingroom_id" onchange="reload();">
          <?
            if ($meetingroom_id==1) {
              echo "<option value='1' selected='selected'>미팅룸 1 (최대 6명)</option>
                    <option value='2'>미팅룸 2 (최대 10명)</option>
                    <option value='3'>미팅룸 3 (최대 15명)</option>";
            }
            else if ($meetingroom_id==2)
            {
              echo "<option value='1'>미팅룸 1 (최대 6명)</option>
                    <option value='2'selected='selected'>미팅룸 2 (최대 10명)</option>
                    <option value='3'>미팅룸 3 (최대 15명)</option>";
            }
            else {
              echo "<option value='1'>미팅룸 1 (최대 6명)</option>
                    <option value='2'>미팅룸 2 (최대 10명)</option>
                    <option value='3'selected='selected'>미팅룸 3 (최대 15명)</option>";
            }
          ?>
        </select>
        <input type="submit" name="show_table" value="조회하기" onclick="send('1', this.form);">
        <p>사용하고자 하는 시간을 선택하세요</p>
        <table border="1" width="300">
          <tr align='center'>
            <th>시간</th>
            <th>선택</th>
          </tr>
          <?
          // 예약 가능한 시간은 10시부터 22시까지 가능하고 두 시간 단위로 사용합니다
          $reserve_time = 10;
          while ($reserve_time<=20) {
            $query = "Select * from reserve_meetingroom
                      where reserve_date='$reserve_date' and time=$reserve_time
                            and meetingroom_id=$meetingroom_id";
            $result = mysqli_query($conn, $query);
            $num = mysqli_num_rows($result);
            if ($num<=0) {
              $end_time=$reserve_time+2;
              echo"
                <tr align='center'>
                  <td>$reserve_time - $end_time 시</td>
                  <td><input type='radio' name='time' value='$reserve_time'></td>
                </tr>";
            }
            $reserve_time = $reserve_time + 2;
          }
          ?>
        </table>
        <p></p>
        <script type="text/javascript">
          // 첫 번째 값이 선택되어 선택하지 않은 채 예약하기 페이지로 넘어가지 않도록 설정
          document.getElementsByName('time')[0].checked = true;
        </script>
        <input type="submit" name="submit" value="예약하기" onclick="send('0', this.form);">
      </form>
    </div>
  </body>
</html>

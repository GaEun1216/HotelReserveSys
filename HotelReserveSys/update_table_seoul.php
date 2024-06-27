<?
// 서울점 예약 가능한 테이블을 보여줍니다
  include './dbconnect.php';

  $num_peo = $_GET['num_people'];
  $check_in = $_GET['check_in_date'];
  $check_out = $_GET['check_out_date'];
  $hotel_id = 'seoul';

  // reserve_room 테이블에 예약 인원이 최대 수용 인원(max_peo)을 넘지 않고
  // 체크인 날짜와 체크아웃 날짜 안에 겹치지 않아 예약이 가능한 테이블을 보여줍니다
  $query = "Select * from hotel_room where hotel_id like '$hotel_id' and max_peo >= $num_peo
            and room_id NOT IN (Select room_num from reserve_room
                                where ((check_in >= '$check_in' and check_in <= '$check_out')
                                and check_out > '$check_in')
                                and (hotel_id like '$hotel_id' and max_peo >= $num_peo))";
  $result = mysqli_query($conn, $query);
  $num = mysqli_num_rows($result);
?>

<html lang="kor" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>reserve seoul room</title>
  </head>
  <style type="text/css">
  .center {
    top: 30%;
  }
  </style>

  <script type="text/javascript">
    // 날짜와 인원이 입력되지 않으면 알림이 나오도록 하는 함수
    function check_date(f){
      var check_in = new Date(document.getElementsByName("check_in_date")[0].value);
      var check_out = new Date(document.getElementsByName("check_out_date")[0].value);
      if (check_in.getTime() >= check_out.getTime()) {
        alert('날짜를 확인해주세요');
        return;
      }

      var num_peo = document.getElementsByName('num_people')[0].value;
      if (!num_peo)
      {
        alert('인원을 입력하세요');
        return;
      }
      f.submit();
    }

    // 체크인 날짜나 체크아웃 날짜, 인원이 변경되면
    // 새로고침해서 form 제출 시 변경된 값을 제출하도록 설정합니다.
    function reload(){
      var check_in = document.getElementsByName("check_in_date")[0].value;
      var check_out = document.getElementsByName("check_out_date")[0].value;
      var num_people = document.getElementsByName("num_people")[0].value;
      location.href='./update_table_seoul.php?num_people='+num_people+'&check_in_date='+check_in+'&check_out_date='+check_out+'&hotel_id=seoul';
    }
  </script>

  <body class="center">
    <form class="reservation" action="./update_table_seoul.php" method="GET">
      <h1 align="center">서울점 예약하기</h1>
      <div class="reserve_room" align="center">
        <label for="num_of_people">인원</label>
        <select class="people" name="num_people" onchange="reload();">
          <option value="">---인원---</option>
          <?
            if ($num_peo==1) {
              echo '<option value="1" selected="selected">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>';
            }
            else if ($num_peo==2) {
              echo '<option value="1">1</option>
              <option value="2" selected="selected">2</option>
              <option value="3">3</option>
              <option value="4">4</option>';
            }
            else if ($num_peo==3) {
              echo '<option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected="selected">3</option>
              <option value="4">4</option>';
            }
            else {
              echo '<option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected="selected">4</option>';
            }
          ?>
        </select>
        <label for="check_in">체크인 : </label>
        <input type="date" name="check_in_date" value=<?echo $check_in?> min="2019-01-01" max="2019-12-31" onchange="reload();">
        <label for="check_out">체크아웃 : </label>
        <input type="date" name="check_out_date" value=<?echo $check_out?> min="2019-01-01" max="2019-12-31" onchange="reload();">
        <input type="submit" name="submit" value="조회하기" onclick="check_date(this.form);">
        <br>  </br>
      </div>
    </form>

    <center>
    <form action="./reserve_room.php?num_people=<? echo $num_peo ?>&check_in=<?echo $check_in?>&check_out=<?echo $check_out?>&hotel_id=seoul" method="POST">
      <table width="500" border="1">
        <tr align='center'>
          <th> 선택하기 </th>
          <th>방 이름</th>
          <th>가격/일</th>
        </tr>

    <?
      while ($row = mysqli_fetch_array($result)) {
        echo"
          <tr align='center'>
            <td><input type='radio' name='room_num' value=$row[room_id]></td>
            <td>$row[room_name]</td>
            <td>$row[price]</td>
          </tr>";
      }
    ?>
      </table>
      <p></p>
      <script type="text/javascript">
        // 첫 번째 값이 선택되어 선택하지 않은 채 예약하기 페이지로 넘어가지 않도록 설정
        document.getElementsByName('room_num')[0].checked = true;
      </script>
      <input type='button' name= '예약하기' value='예약하기' onclick="check_date(this.form);">
    </form>
  </body>
</html>

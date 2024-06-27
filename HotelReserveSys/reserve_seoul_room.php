<!DOCTYPE html>
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
    // 날짜와 인원을 입력했는지 확인하고 입력되지 않았으면 알림이 뜹니다
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
    }
  </script>

  <body class="center">
    <form class="reservation" action="./update_table_seoul.php" method="GET">
      <h1 align="center">서울점 예약하기</h1>
      <div class="reserve_room" align="center">
        <label for="num_of_people">인원</label>
        <select class="people" name="num_people">
          <option value="">---인원---</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
        <label for="check_in">체크인 : </label>
        <input type="date" name="check_in_date" value="2019-01-01" min="2019-01-01" max="2019-12-31">
        <label for="check_out">체크아웃 : </label>
        <input type="date" name="check_out_date" value="2019-01-01" min="2019-01-01" max="2019-12-31">
        <input type="submit" name="submit" value="조회하기" onclick="check_date(this.form);">
        <p></p>
      </div>
    </form>
  </body>
</html>

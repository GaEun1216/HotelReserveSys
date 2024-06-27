<!DOCTYPE html>
<!-- 웨딩&연회 예약하는 화면 -->
<html lang="kor" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>reserve wedding&banquet</title>
  </head>
  <body>
    <div align='center'>
      <!-- GET 방식으로 예약하는 페이지로 넘깁니다 -->
      <form class="" action="./reserve_banquet.php" method="GET">
        <h1>웨딩&연회 예약하기</h1>
        <!-- 날짜를 선택합니다 -->
        <label for="date">날짜 :</label>
        <input type="date" name="date" value="2019-01-01">
        <!-- 이용 목적을 선택합니다 -->
        <label for="reason">이용목적 :</label>
        <select class="select_reason" name="select_reason">
          <option value="wedding">웨딩</option>
          <option value="banquet">연회</option>
        </select>
        <input type="submit" name="submit" value="예약하기">
      </form>
    </div>
  </body>
</html>

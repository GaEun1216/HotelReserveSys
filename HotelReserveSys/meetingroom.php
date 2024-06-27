<!DOCTYPE html>
<html lang="kor" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>reserve meeting room</title>
  </head>
  <body>
    <div align='center'>
      <h1>미팅룸 예약하기</h1>
      <form class="reserve" action="update_table_meetingroom.php" method="get">
        <label for="date_label">날짜 : </label>
        <input type="date" name="reserve_date" value="2019-01-01">
        <label for="num_of_people">미팅룸 : </label>
        <select name="meetingroom_id">
          <option value="1">미팅룸 1 (최대 6명)</option>
          <option value="2">미팅룸 2 (최대 10명)</option>
          <option value="3">미팅룸 3 (최대 15명)</option>
        </select>
        <input type="submit" name="submit" value="조회하기">
      </form>
      <p>예약 가능한 시간을 보여줍니다</p>
    </div>
  </body>
</html>

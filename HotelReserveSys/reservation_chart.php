<?
  include './dbconnect.php';
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!DOCTYPE html>
<html lang="kor" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reservation</title>
  </head>
  <body>
    <div align='right'>
      <input type="button" name="to_home" value="메인화면" onclick="location.href='select_hotel.php'">
    </div>
    <div align='center'>
      <h1>월별 예약 통계</h1>
      <input type="button" name="sale" value="매출 현황" onclick="location.href='sales_pie.php'">
      <input type="button" name="member" value="회원 관리" onclick="location.href='member_chart.php'">
      <input type="button" name="reservation" value="예약 관리" onclick="location.href='reservation_chart.php'">
      <p></p>
    </div>
    <div align='center'>
      <input type="radio" name="chart" value="all" checked>호텔룸
      <input type="radio" name="chart" value="jeju">미팅룸
      <p></p>
    </div>
    <div id="chartContainer" style="height: 350px; width: 100%;"></div>
  </body>
</html>
<script>
var chart = new CanvasJS.Chart("chartContainer", {});
var option1 = {
animationEnabled: true,
title:{
  text: "Reservation per Month"
},
axisX: {
	interval: 1,
	intervalType: "month"
},
data: [{
  type: "line",
  startAngle: 240,
  yValueFormatString: "#0건",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // 편의성을 위해
      // 체크인, 체크아웃 날짜와 예약한 달(month)를 따로 빼서 만든 뷰를 사용합니다
      $month = 1;
      while($month <= 12){
        $query = "select count(month) as num_month from reserve_room_month where month=$month";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo "{y: $row[num_month], label: '$month\월'},";
        $month = $month+1;
      }
    ?>
  ]
}]
};

var option2 = {
animationEnabled: true,
title:{
  text: "Meeting room Time per Month"
},
axisX: {
	interval: 1,
	intervalType: "month"
},
data: [{
  type: "stackedColumn",
  showInLegend: true,
  color: "#EDCA93",
  name: "미팅룸 1",
  // valueFormatString: "##0건",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      $meetingroom_id = 1;
      $month = 1;

      // 편의를 위해 미팅룸 번호와 예약한 달을 따로 빼서 생성한 뷰를 사용합니다.
      while($month <= 12){
        $query = "Select count(*) as counted from meetingroom_distribution
                  where meetingroom_id= $meetingroom_id and month=$month";
        $result = mysqli_query($conn, $query);
        $count = mysqli_fetch_assoc($result);
        echo "{y: $count[counted], label: '$month\월'},";
        $month = $month+1;
      }
    ?>
	]},
  {
    type: "stackedColumn",
    showInLegend: true,
    color: "#695A42",
    name: "미팅룸 2",
    yValueFormatString: "##0건",
    indexLabel: "{label} {y}",
    dataPoints: [
      <?
        $meetingroom_id = 2;
        $month = 1;
        // 편의를 위해 미팅룸 번호와 예약한 달을 따로 빼서 생성한 뷰를 사용합니다.
        while($month <= 12){
          $query = "Select count(*) as counted from meetingroom_distribution
                    where meetingroom_id= $meetingroom_id and month=$month";
          $result = mysqli_query($conn, $query);
          $count = mysqli_fetch_assoc($result);
          echo "{y: $count[counted], label: '$month\월'},";
          $month = $month+1;
        }
      ?>
  	]
  },
  {
    type: "stackedColumn",
    showInLegend: true,
    color: "#B6B1A8",
    name: "미팅룸 3",
    yValueFormatString: "##0건",
    indexLabel: "{label} {y}",
    dataPoints: [
      <?
        $meetingroom_id = 3;
        $month = 1;
        // 편의를 위해 미팅룸 번호와 예약한 달을 따로 빼서 생성한 뷰를 사용합니다.
        while($month <= 12){
          $query = "Select count(*) as counted from meetingroom_distribution
                    where meetingroom_id= $meetingroom_id and month=$month";
          $result = mysqli_query($conn, $query);
          $count = mysqli_fetch_assoc($result);
          echo "{y: $count[counted], label: '$month\월'},";
          $month = $month+1;
        }
      ?>
  	]
  }
  ]
};

if($('input[name=chart]').is(':checked')) {
drawChart(option1);
}

$('input:radio[name=chart]').change(function() {
if(this.value == 'all'){
  drawChart(option1);
}
else if(this.value == 'jeju') {
  drawChart(option2);
}
else if(this.value =='seoul'){
  drawChart(option3);
}
});

function drawChart(options) {
chart.options = options;
chart.render();
}

</script>

<?
  include './dbconnect.php';
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!DOCTYPE HTML>
<html>
<head>
<title>Sales</title>
</head>
<body>
  <div align='right'>
    <input type="button" name="to_home" value="메인화면" onclick="location.href='select_hotel.php'">
  </div>
  <div align='center'>
    <h1>호텔 매출 통계</h1>
    <input type="button" name="sale" value="매출 현황" onclick="location.href='sales_pie.php'">
    <input type="button" name="member" value="회원 관리" onclick="location.href='member_chart.php'">
    <input type="button" name="reservation" value="예약 관리" onclick="location.href='reservation_chart.php'">
    <p></p>
  </div>
  <div align='center'>
    <input type="radio" name="chart" value="all" checked>호텔 매출
    <input type="radio" name="chart" value="jeju">제주 매출
    <input type="radio" name="chart" value="seoul">서울 매출
    <p></p>
  </div>
<div id="chartContainer" style="height: 350px; width: 100%;"></div>

</body>
</html>
<script>
var chart = new CanvasJS.Chart("chartContainer", {});

// 첫 번재 옵션은 호텔 매출의 비율을 보여줍니다.
var option1 = {
animationEnabled: true,
title:{
  text: "Sales of Hotel"
},
data: [{
  type: "pie",
  startAngle: 240,
  yValueFormatString: "##0.00\"%\"",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // payment의 총 합계
      $query = "Select sum(price) as total from payment";
      $result = mysqli_query($conn, $query);
      $total = mysqli_fetch_assoc($result);

      // payment_from으로 그룹화하여 price 총합 계산
      $query = "Select payment_from, sum(price) as total from payment group by payment_from";
      $result = mysqli_query($conn, $query);

      while($group_by = mysqli_fetch_array($result)) {
        $percentage = $group_by['total'] / $total['total']*100;
        echo "{y: $percentage, label: '$group_by[payment_from]'},";
      }
    ?>
  ]
}]
};

// 두 번째 옵션은 제주점의 방 예약 비율을 보여줍니다
var option2 = {
animationEnabled: true,
title:{
  text: "Sales of Jeju"
},
data: [{
  type: "pie",
  startAngle: 240,
  yValueFormatString: "##0.00\"%\"",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // 제주점 payment의 총 합계
      $query = "Select sum(price) as total from payment where payment_from='jeju'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_fetch_assoc($result);

      // 제주점의 방 별 비율을 구합니다
      $query = "Select room_num, sum(price) as total from payment where payment_from='jeju' group by room_num;";
      $result = mysqli_query($conn, $query);
      while($group_by = mysqli_fetch_array($result)) {
        $percentage = $group_by['total'] / $total['total']*100;
        echo "{y: $percentage, label: '$group_by[room_num]'},";
      }
    ?>
  ]
}]
};

// 세 번째 옵션은 서울점의 방 예약 비율을 보여줍니다
var option3 = {
animationEnabled: true,
title:{
  text: "Sales of Seoul"
},
data: [{
  type: "pie",
  startAngle: 240,
  yValueFormatString: "##0.00\"%\"",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // 서울점 payment의 총 합계
      $query = "Select sum(price) as total from payment where payment_from='seoul'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_fetch_assoc($result);

      // 서울점의 방 별 비율을 구합니다
      $query = "Select room_num, sum(price) as total from payment where payment_from='seoul' group by room_num;";
      $result = mysqli_query($conn, $query);
      while($group_by = mysqli_fetch_array($result)) {
        $percentage = $group_by['total'] / $total['total']*100;
        echo "{y: $percentage, label: '$group_by[room_num]'},";
      }
    ?>
  ]
}]
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

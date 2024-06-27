<?
  include './dbconnect.php';
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!DOCTYPE html>
<html lang="kor" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Members</title>
  </head>
  <body>
    <div align='right'>
      <input type="button" name="to_home" value="메인화면" onclick="location.href='select_hotel.php'">
    </div>
    <div align='center'>
      <h1>회원 통계</h1>
      <input type="button" name="sale" value="매출 현황" onclick="location.href='sales_pie.php'">
      <input type="button" name="member" value="회원 관리" onclick="location.href='member_chart.php'">
      <input type="button" name="reservation" value="예약 관리" onclick="location.href='reservation_chart.php'">
      <p></p>
    </div>
    <div align='center'>
      <input type="radio" name="chart" value="all" checked>연령대 분포
      <input type="radio" name="chart" value="jeju">클래스 비율
      <input type="radio" name="chart" value="seoul">클래스별 매출 비율
      <p></p>
    </div>
    <div id="chartContainer" style="height: 350px; width: 100%;"></div>
  </body>
</html>
<script>
var chart = new CanvasJS.Chart("chartContainer", {});

// 첫번재 옵션은 연령대별 회원 분포를 보여줍니다
var option1 = {
animationEnabled: true,
title:{
  text: "Member Age"
},
data: [{
  type: "column",
  startAngle: 240,
  yValueFormatString: "##0명",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // if문을 이용해서 연령대별 회원 수를 구합니다
      $query = " Select sum(if(age between 20 and 29, 1, 0)) as age_20, sum(if(age between 30 and 39, 1, 0)) as age_30, sum(if(age between 40 and 49, 1, 0)) as age_40, sum(if(age between 50 and 59, 1, 0)) as age_50, sum(if(age>59, 1, 0)) as age_over from member;";
      $result = mysqli_query($conn, $query);
      $age = mysqli_fetch_assoc($result);

      echo "{y: $age[age_20], label:'20대'},
            {y: $age[age_30], label:'30대'},
            {y: $age[age_40], label:'40대'},
            {y: $age[age_50], label:'50대'},
            {y: $age[age_over], label:'60대 이상'},";
    ?>
  ]
}]
};

// 두 번째 옵션은 클래스의 비율을 보여줍니다
var option2 = {
animationEnabled: true,
title:{
  text: "Distribution of Member Class"
},
data: [{
  type: "pie",
  startAngle: 240,
  yValueFormatString: "##0명",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // class로 그룹화해서 인원을 구합니다
      $query = "Select class, count(class) as num_class from member group by class;";
      $result = mysqli_query($conn, $query);
      while($group_by = mysqli_fetch_array($result)) {
        echo "{y: $group_by[num_class], label: '$group_by[class]'},";
      }
    ?>
  ]
}]
};

// 세 번째 옵션은 클래스별 매출의 비율을 보여줍니다
var option3 = {
animationEnabled: true,
title:{
  text: "Sales of Hotel Group by Class"
},
data: [{
  type: "pie",
  startAngle: 240,
  yValueFormatString: "##0.00\"%\"",
  indexLabel: "{label} {y}",
  dataPoints: [
    <?
      // member와 payment를 조인해서 회원의 총 매출을 구합니다
      $query = "select sum(price) as total from payment join member on member.id = payment.member_id;";
      $result = mysqli_query($conn, $query);
      $total = mysqli_fetch_assoc($result);

      // member와 payment를 조인해서 회원의 클래스별 매출의 비율을 구합니다
      $query = "select class, sum(price) as total from payment join member on member.id = payment.member_id group by member.class;";
      $result = mysqli_query($conn, $query);
      while($group_by = mysqli_fetch_array($result)) {
        $percentage = $group_by['total'] / $total['total']*100;
        echo "{y: $percentage, label: '$group_by[class]'},";
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


<?
$number = $_POST['order_num'];
$review = $_POST['review'];
$rate = $_POST['rate'];
echo "$number";
    include './dbconnect.php';

    $number = $_POST['order_num'];

    $q = "SELECT * FROM reserve_room WHERE reserve_id='$number'";
    $result = mysqli_query($conn,$q);//데이터 베이스와 연결 ->con에 대해서는 connect.php에 서술
    mysqli_error($conn);
    $row = mysqli_fetch_array($result);

    $id = $row['id'];
    $place = $row['hotel_id'];
    $room = $row['room_num'];
    $query = "insert into review values ('0', '$id', '$rate', '$review', '$place', '$room');";
    mysqli_query($conn, $query);

?>
<script>alert("리뷰 작성이 완료 되었습니다(비회원은 리뷰를 남길 수 없습니다.)");</script>
<meta http-equiv="refresh" content="0;url=select_hotel.php" />

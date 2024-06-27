<?$number = $_POST['order_num'];?>
<html>
<div class="review" align='center'>
  <form method = "post" action = 'review_pass.php'>
    <label>남길 리뷰를 작성해주세요</label>
    <input type="text" name="review"/>
    <input type="hidden" name = "order_num" value="<?=$number?>">
    <p>별점
      <input type="radio" name="rate" value="5" checked="checked">5
      <input type="radio" name="rate" value="4">4
      <input type="radio" name="rate" value="3">3
      <input type="radio" name="rate" value="2">2
      <input type="radio" name="rate" value="1">1
      <br>
    </p>
    <input type="submit" value="리뷰 남기기">
  </form>
</html>

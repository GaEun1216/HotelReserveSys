<html>
<head>
  <meta charset="utf-8">
  <title>Review</title>
  <div align="right" class="mode_change">
    <input align="right" type="button" name="change_mode" value="메인화면" onclick="location.href='select_hotel.php'">
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script>

  function pri() {
    let data = new FormData()
    data.append('place', getRadioValue2())//체크박스로 받은 데이터 불러옴
    data.append('sort', getRadioValue())
    const tbodyElement = document.querySelector('table tbody')
    tbodyElement.innerHTML = '' //테이블 초기화
    fetch('rdata.php', {
        body: data,
        method: 'POST'
    }).then((res) => {
        return res.json()
    }).then(body => {
        for (let review of body.result) {
            const row = document.createElement('tr')

            for (let data in review) {
                const col = document.createElement('td')
                col.textContent = review[data]

                row.appendChild(col)
            }

            tbodyElement.appendChild(row)
        }
    })
  }
  function getRadioValue2() {
    for (inputEl of document.querySelectorAll('input[name="place"]:checked') ){
      return inputEl.getAttribute('value')
    }
  }
  // radio button 의 value 를 가져옴
function getRadioValue() {
  for (inputEl of document.querySelectorAll('input[name="sort"]:checked') ){//sort란 이름에 체크된거 반환
    return inputEl.getAttribute('value')
  }
}

  </script>
  </head>
  <center><h2>리뷰 조회하기<br></h2></center>
  <form>
    <center>
      <div>
        <form name = "check_place" method="post">
          <input type="radio" name="place" value="seoul" checked="checked">서울 지점
          <input type="radio" name="place" value="jeju">제주 지점

      </form>
      <p></p>
      </div>

    <p></p>
    <form name = "check_sort" method="post">
    <input type="radio" name="sort" value="desc" checked="checked">좋은 평점순
    <input type="radio" name="sort" value="date">최신순
    </form>

    <p></p>
    <input type="button" value = "리뷰 조회" onClick="pri()">
    <p></p>
    <table id = "my_table" border="1">
    <thead>
          <tr>
              <th width="100">리뷰 번호</th>
              <th width="100">사용한 방</th>
                <th width="500">한줄평</th>
                <th width="120">글쓴이</th>
                <th width="100">별점</th>
            </tr>

        </thead>
        <tbody>
          <tr align='center'>
          </tr>
        </tbody>
      </table>

  </center>
  </form>



</html>

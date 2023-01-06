<!-- 
  파일명 : user_regist.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  회원가입 폼
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>toy project 1st</title>
</head>

<body>
  <h1>회원가입 화면</h1>
  <form action="./user_registprocess.php" method="POST">
    <label>사용자 아이디 : </label><input type="text" name="username" placeholder="영숫자 8글자 이상으로 입력해주세요." required /><br>
    <label>비밀번호 : </label><input type="password" name="passwd" placeholder="영숫자와 특수문자 이용 10글자 이상으로 입력해주세요." required /><br>
    <label>비밀번호(확인) : </label><input type="password" name="cpasswd" placeholder="확인을 위해 위 비밀번호를 한번 더 입력해주세요." required /><br>
    <label>전화번호 : </label><input type="text" name="cellphone" placeholder="셀폰번호를 010-1234-1234 형식으로 입력해주세요." required /><br>
    <label>E-Mail : </label><input type="text" name="email" placeholder="이메일 주소를 이메일 주소 형식에 맞게 입력해주세요." required /><br>
    <br>
    <input type=submit value="회원가입">
  </form>
</body>

</html>
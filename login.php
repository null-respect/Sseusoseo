<?
  session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>쓰소서</title>


  <!-- Compiled and minified CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <link rel="stylesheet" href="./css/main.css?ver=1">


   <!-- Compiled and minified JavaScript -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
  <div class="main">
    <div class="row" style="padding:4%">
    </div>
    <div class="row">
      <div class="col s2 offset-s5 ">
        <div class="row" style="text-align: center;">
          <img src="./image/logo.png" alt="" width="50%" >
        </div>
        <div class="row card">
          <form action="./login_process.php" style="padding:15px" method="POST">
            <div class="input-field col s12">
              <input name="id" id="id" type="text" class="validate">
              <label for="id">아이디</label>
            </div>
            <div class="input-field col s12">
              <input name="pwd" id="pwd" type="password" class="validate">
              <label for="pwd">비밀번호</label>
            </div>
            <button style="padding:0px 100px 0px 100px; margin: 10px;"class="btn waves-effect waves-light blue accent-4" type="submit" name="action">
             로그인
             </button>
          </form>
          <?
            if(isset($_SESSION['check_login'])){
              if($_SESSION['check_login']){
                $_SESSION['check_login'] = false;
                echo "<div id='error'>잘못된 비밀번호이거나 없는 아이디입니다.</div><br>";
              }
            }
          ?>
          회원이 아니신가요? <a href="./signup.html">회원가입</a>
          <div style="padding:10px;">
          </div>
        </div>
      </div>
    </div>

  </div>

  </div>

</body>
</html>

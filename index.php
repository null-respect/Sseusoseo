<?
  session_start();
  if($_SESSION['is_login'] == false){
    header('Location: ./login.php');
  }
  $conn= mysqli_connect("localhost", "root", "111111", "lord");
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>쓰소서</title>
    <!-- Compiled and minified CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
     <link rel="stylesheet" href="./css/main.css?ver=2">


     <!-- Compiled and minified JavaScript -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </head>
  <body>
    <div class="row" style="margin:0px; padding-top: 20px; padding-bottom:0px;">
      <div class="col s5">
        <ul style="padding-top:10px; padding-left:85px;">
          <?
            $sql = "SELECT name from member where id = '".$_SESSION['id']."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            $num=1;
            $no=1;
            if(isset($_GET['no'])){
              $no = $_GET['no'];
            }
            $list = array('1번', '2번', '3번', '4번', '공유');
            if(isset($_GET['num'])){
              $num = $_GET['num'];
            }
            foreach ($list as $key => $value) {
              if($num==($key+1))  echo "<li class='menu'><a id='menu-select' href='./index.php?num=" .($key+1). "'>".$value."</a></li>";
              else echo "<li class='menu'><a href='./index.php?num=" .($key+1). "'>".$value."</a></li>";
            }
          ?>
        </ul>
      </div>
      <div class="col s2" style="text-align: center;">
        <img src="./image/logo.png" alt="" width="40%" style="padding:1px">
      </div>
      <div class="col s5 menu" id="menu2">
        <?=$row['name']?>님 자소서 작성 중
        <a href="./logout_process.php" style="padding-left:20px;">로그아웃</a>
        </div>
    </div>

    <div class="row">
      <div class="col s2" style="margin-left:7%;" id="side">
        <div class="card" id="side1">
          <div class="collection" style="margin:0px;" >

            <?
            $shared = 0;
            $sql = "SELECT *FROM letter where id = '". $_SESSION['id']
            ."' AND l_num = ".$num;
            if($num==5) {
              $shared = 1;
              $sql = "SELECT *FROM letter where l_id IN
                (SELECT l_id from share where to_id = '" .$_SESSION['id']
                  . "'AND (l_status = '1' OR l_status = '2' ))";
            }

            $result = mysqli_query($conn, $sql);
            $collection = '';
            $l_id;
            $que;
            $l_shared = 0;
            $title = '';
            $content = '';
            $date = '';
            $ex = 1;

            $i = 1;
            while($row = mysqli_fetch_array($result)) {
              if($shared==0){
                $collection = $collection
                ."<a href='./index.php?num=".$num."&no=".$i."' class='collection-item";
              }
              else {
                $collection = $collection
                ."<a href='./index.php?num=5&no=".$i."' class='collection-item";
              }

              if($no==$i){
                $collection = $collection." active";
                $l_id = $row['l_id'];
                $title = $row['l_title'];
                $content = $row['l_content'];
                $date = $row['l_date'];
                $l_shared = $row['l_status'];

                $num = $row['l_num'];
                if($num == 4) {
                  $que = $row['l_que'];
                }
              }

              $collection = $collection
              ."' style='font-size:25px; padding-top:15px; color:black;'><span class='collection-title'>".$row['l_title'];


              $collection = $collection
              ."</span><br> <span class='collection-date' style='font-size:12px;'>마지막 저장: ".$row['l_date']."</span>";

              if(($row['l_status'])!='0'){
                if($shared==0){
                  $sql = "SELECT name FROM member where id IN
                    (SELECT to_id from share WHERE l_id = '". $row['l_id']. "')";
                  $result2 = mysqli_query($conn, $sql);
                  $row2 = mysqli_fetch_array($result2);

                  if($row['l_status']==1){
                    $collection = $collection
                    .'<br><span style="font-size:12px; ">'. $row2['name'] . '님께 도움받는중 </span>';

                  }
                  else{
                    $collection = $collection
                    .'<br><span style="font-size:12px; ">'. $row2['name'] . '님께 도움받음 </span>';
                  }
                }
                elseif($shared==1){
                  $sql = "SELECT name FROM member where id IN
                    (SELECT from_id from share WHERE l_id = '". $row['l_id']. "')";
                  $result2 = mysqli_query($conn, $sql);
                  $row2 = mysqli_fetch_array($result2 );
                  if($row['l_status']==1){
                    $collection = $collection
                    .'<br><span style="font-size:12px; ">'. $row2['name'] . '님이 구원을 원함 </span>';
                  }
                  elseif($row['l_status']==2){
                    $collection = $collection
                    .'<br><span style="font-size:12px; ">'. $row2['name'] . '님께 구원을 완료함 </span>';
                  }
                }


              }
              $i++;

            }
            if(($i==1)&&($num!=5)){
                $sql = "insert into letter (l_title, l_num, id) values('첫 번째 글','"
                  .$num. "','" .$_SESSION['id']. "')";
                $result = mysqli_query($conn, $sql);

                header('Location: ./index.php?num='.$num);
                if($_SESSION['is_login'] == false){
                  header('Location: ./login.php');
                }
            }
            else if(($i==1)&&($shared==1)){
              $collection = $collection
              ."<p style='padding: 10px;'>공유받은 글이 없습니다.</p>";
              $ex = 0;
            }
            echo $collection;
            ?>

            <form>
              <input type="hidden" id="l_id" value="<?=$l_id?>">
              <input type="hidden" id="get_title" value="<?=$title?>">
              <input type="hidden" id="get_content" value="<?=$content?>">
              <input type="hidden" id="get_index" value="<?=$i?>">
              <input type="hidden" id="get_num" value="<?=$num?>">
              <input type="hidden" id="get_id" value="<?=$_SESSION['id']?>">
              <input type="hidden" id="get_no" value="<?=$no?>">
              <input type="hidden" id="get_que" value="<?=$que?>">
            </form>
          </div>
        </div>
        <div id="side2" style="padding-top:12px">
          <?
          if($shared==0)
            echo '
            <a id="btn_new" class="waves-effect waves-light btn-large white menuBtn" style="margin-left:4px;">새로쓰기</a>
            <a id="btn_copy" class="waves-effect waves-light btn-large white menuBtn">복사하기</a>
            <br>
            <a id="btn_share" class="waves-effect waves-light btn-large white menuBtn modal-trigger"  href="#modal1">공유하기</a>
            <a id="btn_del" class="waves-effect waves-light btn-large white menuBtn">삭제하기</a>
            ';
          else
            echo '
            <a id="btn_share_fin" style="padding-left:57px; padding-right: 57px;" class="waves-effect waves-light btn-large white menuBtn">공유 완료</a>
            <a id="btn_del_list" class="waves-effect waves-light btn-large white menuBtn">목록에서 지우기</a>
            ';
          ?>
        </div>
      </div>


      <div class="col s7 offset-s1 card" id="right" style="margin-top:0px;">
        <div class="" id="right1">
          <br>
          <form>

          <?
            if($num==4){
              echo '<textarea class="question" style="height:60px; width:500px;" id="que" class="materialize-textarea" data-length="1000" placeholder="문항을 입력하세요"></textarea>
              <label for="que"></label>';
            }
            elseif($i!=1){
              echo "<div class='question'>";
              if($num == 1) {
                echo "고등학교 재학기간 중 학업에 기울인 노력과 학습 경험을 통해,  <br>배우고 느낀 점을 중심으로 기술해 주시기 바랍니다.";
              }
              elseif ($num==2) {
                echo "고등학교 재학기간 중 본인이 의미를 두고 노력했던 교내 활동(3개 이내)을 통해 배우고 느낀 점을 <br>중심으로 기술해 주시기 바랍니다.
단, 교외 활동 중 학교장의 허락을 받고 참여한 활동은 포함됩니다.";
              }
              elseif ($num==3) {
                echo "학교생활 중 배려, 나눔, 협력, 갈등 관리 등을 실천한 사례를 들고, <br>그 과정을 통해 배우고 느낀 점을 기술해 주시기 바랍니다.";
              }
              echo "</div>";
            }

          if($i!=1){
            echo '
              <div style="padding-right:700px;">
                <input style="font-size:30px; height:60px;"id="title" type="text" class="validate" placeholder="제목을 입력하세요">
                <label for="title"></label>
              </div>

            <div class="input-field "style="padding-top:0px; margin:0px;">
              <textarea style="height:590px;" id="textarea" class="materialize-textarea" data-length="';

              if(($num==1)||$num==3) echo "1000"; else echo 1500;

              echo '
              " placeholder="내용을 입력하세요" autofocus></textarea>
              <label for="textarea"></label>
            </div>
              ';
          }

            if($ex==1){
              if((($l_shared!=1)&&($shared==0))||
                (($l_shared==1)&&($shared==1))){
                echo '
                <a id="save" class="waves-effect waves-light btn light-blue darken-4" style="margin-top:4px; margin-right: 20px; float:left;">저장하기</a>
                <div id="last_save" style="padding:7px; font-size:20px;">마지막 저장: ' .$date. '</div>
                ';
              }
            }
            if(($l_shared==1)&&($shared==0)){
              echo '<div id="last_save" style="padding:8px; font-size:20px;">공유하고 있는 글은 수정할 수 없습니다. 이 글을 사용하려면 복사하여 사용하세요.  </div>';
            }
            elseif(($l_shared!=1)&&($shared==1)) {
              echo '<div id="last_save" style="padding:8px; font-size:20px;">공유 완료한 글은 더 이상 수정할 수 없습니다.</div>';
            }
          ?>
          </form>
        </div>
      </div>
    </div>

    <div id="modal1" class="modal bottom-sheet">
      <div class="modal-content" style="padding:20px 20px 0px 20px;">
        <h4 style="padding-bottom: 10px;">공유할 사람의 아이디를 입력하세요.</h4>
        <div class="input-field col s12" style="margin-bottom:0px;">
          <input id="shared_id" name="shared_id" type="text" class="validate" required>
          <label for="shared_id">아이디</label>
        </div>
        </form>
      </div>

      <div class="modal-footer" style="text-align:left">
        <a id="btn_modal" class="modal-close waves-effect waves-green btn-flat" style="margin-left:10px; float:left">공유하기</a>
        <div id="modal_text" style="padding-top:13px; margin-left:120px;"></div>
      </div>
    </div>

  </body>
  <script>

  $(document).ready(function() {
    $('input#input_text, textarea#textarea').characterCounter();
    $('input#input_text, .character-counter').css('font-size', '30px');

    $('#title').val($('#get_title').val());
    $('#textarea').val($('#get_content').val());
    if(($('#get_num').val())=='4'){
      $('#que').val($('#get_que').val());
    }

     $('.modal').modal();

    $('.collection-item').click(function(){
      $('.collection-item').removeClass('active');
      $(this).addClass('active');
    });
  });


    $('#save').click(function(){
      $.ajax({
        url:'./update_ajax.php',
        type:'post',
        data: {
          title : $('#title').val(),
          content : $('#textarea').val(),
          l_id : $('#l_id').val(),
          num : $('#get_num').val(),
          que : $('#que').val()
        },
        success:function(data){
          $('.collection-title').eq($('#get_no').val()-1).text($('#title').val());
          $('.collection-date').eq($('#get_no').val()-1).text('마지막 저장: '+data);
          $('#last_save').text('마지막 저장: '+data);
        }
      });
    });

    $('#btn_new').click(function(){
      $.ajax({
        url:'./insert_ajax.php',
        type:'post',
        data: {
          num : $('#get_num').val(),
          id : $('#get_id').val(),
          type : '1'
        },
        success:function(data){
          location.href='./index.php?num='+ $('#get_num').val() + "&no=" + $('#get_index').val();
        }
      });
    });

    $('#btn_copy').click(function(){
      $.ajax({
        url:'./insert_ajax.php',
        type:'post',
        data: {
          num : $('#get_num').val(),
          id : $('#get_id').val(),
          type : '2',
          title : $('#title').val(),
          content : $('#textarea').val()
        },
        success:function(data){
          location.href='./index.php?num='+ $('#get_num').val() + "&no=" + $('#get_index').val();
        }
      });
    });

    $('#btn_del').click(function(){
      $.ajax({
        url:'./insert_ajax.php',
        type:'post',
        data: {
          l_id : $('#l_id').val(),
          type : '3'
        },
        success:function(data){
          location.href='./index.php?num='+ $('#get_num').val();
        }
      });
    });

    $('#btn_modal').click(function(){
      if(($('#shared_id').val())!=""){
        $.ajax({
          url:'./share_ajax.php',
          type:'post',
          data: {
            l_id : $('#l_id').val(),
            to_id : $('#shared_id').val(),
            from_id : $('#get_id').val(),
            que : $('#get_que').val()
          },
          dataType : 'json',
          success:function(data){
            if(data.result){
              location.href='./index.php?num='+ $('#get_num').val() + "&no=" + $('#get_no').val();
            }
            else{
              $('.modal').modal('open');
              $('#modal_text').text(data.message);
            }
          }
        });
      }
      $('#shared_id').val("");
    });

    $('#btn_share_fin').click(function(){
    $.ajax({
      url:'./update_ajax.php',
      type:'post',
      data: {
        title : $('#title').val(),
        content : $('#textarea').val(),
        l_id : $('#l_id').val(),
        num : $('#get_num').val(),
        que : $('#que').val()
      },
      success:function(data){

      }
    });

      $.ajax({
        url:'./insert_ajax.php',
        type:'post',
        data: {
          l_id : $('#l_id').val(),
          type : '4'
        },
        success:function(data){
          location.href='./index.php?num=5' + "&no=" + $('#get_no').val();
        }
      });
    });

    $('#btn_del_list').click(function(){
      $.ajax({
        url:'./insert_ajax.php',
        type:'post',
        data: {
          l_id : $('#l_id').val(),
          type : '5'
        },
        success:function(data){
          location.href='./index.php?num=5' + "&no=1";
        }
      });
    });

  </script>
</html>

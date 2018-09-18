<?
  $name = preg_replace("/\s+/", "",$_POST['name']);
  $id = preg_replace("/\s+/", "",$_POST['id']);
  $pwd = preg_replace("/\s+/", "",$_POST['pwd']);
  $pwd2 = preg_replace("/\s+/", "",$_POST['pwd2']);
  $result['success'] = false;
  $result['message'] = '';

  if(($name=='')||($id=='')||($pwd=='')||($pwd2=='')) {
      $result['message'] = "모든 항목에 입력해주세요";
  }
  else{
    if($pwd != $pwd2) {
        $result['message'] = "비밀번호가 일치하지 않습니다.";
    }
    else {
        $conn= mysqli_connect("localhost", "root", "111111", "lord");
        if($conn){
          $sql = "insert into member (id, name, pwd) values('"
            .$id. "','" .$name. "','" .$pwd. "')";
          $result2 = mysqli_query($conn, $sql);
          if($result2){
            $result['success'] = true;
          }
          else {
              $result['message'] = "이미 존재하는 아이디입니다.";
          }
        }
     }
  }

  echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>

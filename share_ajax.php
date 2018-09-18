<?
  if($_POST['to_id']==$_POST['from_id']){
    $data['result'] = false;
    $data['message'] = '자신에게 할 수 없습니다.';
  }
  else{
    $conn= mysqli_connect("localhost", "root", "111111", "lord");

    $sql = "select * from member where id = '" .$_POST['to_id']. "'";
    $result = mysqli_query($conn, $sql);

    if($row = mysqli_fetch_array($result)){
      $data['result'] = true;

      $sql = "select * from letter where l_id = '". $_POST['l_id']. "'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $sql = "insert into letter (l_title, l_content, l_num, id, l_que, l_status) values ('"
        .$row['l_title']. "', '". $row['l_content']. "', '"
        .$row['l_num']. "', '" .$row['id']. "', '" .$row['l_que']. "', '1')";
      $result = mysqli_query($conn, $sql);

      $sql = "select * from letter WHERE l_status = '1'  ORDER BY l_date DESC limit 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $sql = "insert into share (from_id, to_id, l_id, s_status) values ('"
        .$_POST['from_id']. "', '" .$_POST['to_id']. "', '" .$row['l_id']. "', '1')";

      $result = mysqli_query($conn, $sql);
    }
    else{
      $data['result'] = false;
      $data['message'] = '존재하지 않는 아이디입니다.';
    }
  }

  echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>

<?
  $conn= mysqli_connect("localhost", "root", "111111", "lord");

  if($_POST['type']=='1'){
    $sql = "insert into letter (l_num, id) values('"
      .$_POST['num']. "','" .$_POST['id']. "')";
    $result = mysqli_query($conn, $sql);
  }
  else if($_POST['type']=='2'){
    $sql = "insert into letter (l_num, id, l_title, l_content) values('"
      .$_POST['num']. "','" .$_POST['id']."','"
      .$_POST['title']. " - 복사본','" .$_POST['content']. "')";
    $result = mysqli_query($conn, $sql);
  }

  else if($_POST['type']=='3'){
    $sql = "delete from letter where l_id = " .$_POST['l_id'];
    $result = mysqli_query($conn, $sql);
  }

  // 공유 완료
  else if($_POST['type']=='4'){
    $sql = "UPDATE letter SET l_status = '2' WHERE l_id = '" .$_POST['l_id']. "'";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE share SET s_status = '2' WHERE l_id = '" .$_POST['l_id']. "'";
    $result = mysqli_query($conn, $sql);
  }

  // 목록에서 삭제
  else if($_POST['type']=='5'){
    $sql = "UPDATE letter SET l_status = '3' WHERE l_id = '" .$_POST['l_id']. "'";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE share SET s_status = '3' WHERE l_id = '" .$_POST['l_id']. "'";
    $result = mysqli_query($conn, $sql);
  }
?>

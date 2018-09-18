<?
  $conn= mysqli_connect("localhost", "root", "111111", "lord");

  $sql = "UPDATE letter SET l_title = '" . $_POST['title']
    ."' , l_content = '" .$_POST['content']. "' ";

  if($_POST['num']=='4'){
    $sql = $sql. ", l_que = '" .$_POST['que']. "'";
  }

  $sql = $sql.  "WHERE l_id = ". $_POST['l_id'];

  $result = mysqli_query($conn, $sql);

  $sql = "SELECT l_date from letter where l_id = " . $_POST['l_id'];
  $result = mysqli_query($conn, $sql);

  $row = mysqli_fetch_array($result);

  echo $row['l_date'];
?>

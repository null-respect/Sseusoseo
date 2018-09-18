<?
  session_start();
  if((isset($_POST['id']))&&(isset($_POST['pwd']))) {
    $conn= mysqli_connect("localhost", "root", "111111", "lord");
    if($conn){
      $sql = "SELECT *FROM member where id = '". $_POST['id']. "'";

      $result2 = mysqli_query($conn, $sql);
      if($result2){
         $row = mysqli_fetch_array($result2);
         if($row['pwd']==$_POST['pwd']){

           $_SESSION['is_login'] = true;
           $_SESSION['id'] = $_POST['id'];
           header('Location: ./index.php');
         }
         else {
           $_SESSION['check_login'] = true;
           header('Location: ./login.php');
         }
      }
      else {

      }
    }
  }
  else{
    header('Location: ./login.php');
  }
?>

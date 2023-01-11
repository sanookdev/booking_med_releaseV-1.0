 <?php
    include "config/connect.php";
    include "function.php";

    $where = $_POST['where'];
    $table = $_POST['table'];
    $sql = "SELECT * FROM $table WHERE $where";
    $sql = str_replace("\\","",$sql);
    $result = $conn->query($sql);
    $result = $result->fetch_array();
   //  echo json_encode($table." : ". $where);
   //  if($result->num_rows > 0){
   //    while($row = $result->fetch_assoc()){
   //       $result['category_id'][] = $row['category_id'];
   //    }
   //  }

    echo json_encode($result);
    ?>
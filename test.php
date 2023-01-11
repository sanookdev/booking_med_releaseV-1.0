<?
    $json=json_decode(stripslashes($_POST['data']), true);
    echo json_encode($json);
?>
<?
function delete($table, $where, $conn)
{
    $sql = "DELETE FROM $table WHERE $where";
    if ($conn->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
        return false;
    }
}

function select($sql, $conn)
{
    $result = array();
    $res = $conn->query($sql) or die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
    while ($data = $res->fetch_assoc()) {
        $result[] = $data;
    }
    return $result;
}

function insert($table, $data, $conn)
{
    $fields = "";
    $values = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $fields .= ", ";
            $values .= ", ";
        }
        $fields .= "$key";
        $values .= "'$val'";
        $i++;
    }
    $sql = "INSERT INTO $table VALUES ($values)";
    if ($conn->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
        return false;
    }
}

function search($department, $sql)
{

    // processing....
    require_once "../config/connect.php";
    $data = array();
    echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $data[$i] = $row[$i];
            echo $row[$i];
            $i++;
        }
    }
}

function update($table, $data, $where, $conn)
{
    $modifs = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $modifs .= ", ";
        }
        if (is_numeric($val)) {
            $modifs .= $key . '=' . "$val";
        } else {
            $modifs .= $key . ' = "' . $val . '"';
        }
        $i++;
    }
    $sql = "UPDATE ". $table ." SET ".$modifs. " WHERE ".$where;
    if ($conn->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
        return false;
    }
}
?>
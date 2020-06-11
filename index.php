<?php require_once 'page.php'; ?>
<?php require_once 'view/header.php'; ?>
<?php require_once 'core/db.php'; ?>

<form action="" method="post">
    請輸入員工資料：
    <p> 
    <label for="employeeid">員工ID</label>
    <input name="employeeid" type="char" size="10"/>
   </p>
     <p> 
    <label for="ename">姓名</label>
    <input name="ename" type="char" size="20"/>
    </p>

     <p>
    <label for="birthday">生日</label>
    <input name="birthday" type="date" />
     </p>
     <p>
    <label for="id">身份證字號</label>
    <input name="id" type="char" size="10" />
     </p>
     <p> 
     <label for="cellphone">電話號碼</label>
     <input name="cellphone" type="char" size="10" />
     </p>    
     <p>
     <label for="address">地址</label>
     <input name="address" type="varchar" size="50"/>
     </p>
      <p>
     <label for="memo">簡介(小於50字)</label>
     <input name="memo" type="varchar" size="50"/>
     </p>
    <input name="action" type="hidden" value="add" />
    <input type="submit" value="新增" />
</form>
<?php

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        //新增
        case 'add':                                                                                                                                                                                                                                          
           $query = $pdo->prepare("INSERT INTO employee(employeeid,ename,birthday,id,cellphone,address) VALUES(substr('{$_POST['employeeid']}',1,10),substr('{$_POST['ename']}',1,20),substr('{$_POST['birthday']}',1,10),substr('{$_POST['id']}',1,10),substr('{$_POST['cellphone']}',1,10),substr('{$_POST['address']}',1,50));");
            $result = $query->execute();
            if ($result) {
                echo '<p>新增成功</p>';
            } else {
                echo "<p>新增失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
            //修改
        case 'edit_ok':
            $query = $pdo->prepare("UPDATE employee SET ename = '{$_POST['ename']}' WHERE employeeid = '{$_POST['employeeid']}'");
            $result = $query->execute();

            if ($result) {
                echo '<p>編輯成功</p>';
            } else {
                echo "<p>編輯失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
        //刪除
        case 'delete':
            $query = $pdo->prepare("DELETE FROM employee WHERE employeeid = '{$_POST['employeeid']}'");
            $result = $query->execute();

            if ($result) {
                echo '<p>刪除成功</p>';
            } else {
                echo "<p>刪除失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
    }    
}
$query = $pdo->prepare('SELECT * FROM employee');
$query->execute();
$total_rows =$query->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);


$query = $pdo->prepare('SELECT * FROM employee');
$total_rows =$query->rowCount();
$query = $pdo->prepare('SELECT * FROM employee LIMIT  :offset, :no_of_records_per_page');

$query->bindParam(':offset',$offset,PDO::PARAM_INT);
$query->bindParam(':no_of_records_per_page',$no_of_records_per_page,PDO::PARAM_INT);
$query->execute();








if ($query->rowCount() > 0) 
{
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    $edit = isset($_POST['action']) ? $_POST['action'] === 'edit' : false;
    $id = $edit ? $_POST['employeeid'] : null;

    echo '<table>';
    echo '<thead>';
    echo '<tr><th>員工ID</td><th>姓名</th><th>生日</th><th>身分證字號</th><th>電話號碼</th><th>地址</th><th></th><th></th></tr>';    
    echo '</thead>';
    echo '<tbody>';
    //var_dump($offset,  $no_of_records_per_page, $pageno,$total_pages,$total_rows);
    
    
    foreach ($data AS $row) {
        if ($edit && $id === $row['employeeid']) {
            echo '<tr><td>' . $row['employeeid'] . '</td>';
            echo '<td><form action="" method="post"><input name="ename" value="' . $row['ename'] . '" /></td><th></th><th></th><th></th><th></th><td>';
            echo '<input name="action" type="hidden" value="edit_ok" />';
            echo '<input name="employeeid" type="hidden" value="' . $row['employeeid'] . '" />';
            echo '<input type="submit" value="確認" /></form></td><td></td></tr>';
        } 
        else {
            echo '<tr><td>' . $row['employeeid'] . '</td><td>' . $row['ename'] . '</td><th>' . $row['birthday'] . '</th><th>' . $row['id'] . '</th><th>' . $row['cellphone'] . '</th><th>' . $row['address'] . '</th><td>';
            echo '<form action="" method="post">';
            echo '<input name="action" type="hidden" value="edit" />';
            echo '<input name="employeeid" type="hidden" value="' . $row['employeeid'] . '" />';
            echo '<input type="submit" value="編輯" /></form></td><td>';
            echo '<form action="" method="post">';
            echo '<input name="action" type="hidden" value="delete" />';
            echo '<input name="employeeid" type="hidden" value="' . $row['employeeid'] . '" />';
            echo '<input type="submit" value="刪除" />';
            echo '</form></td></tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
} 
else {
    echo '目前沒有資料';
} 
$pdo=null;
?>
     
<?php require_once 'view/footer.php'; ?> 
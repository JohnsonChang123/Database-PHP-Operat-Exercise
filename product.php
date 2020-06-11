<?php require_once 'page.php'; ?>
<?php require_once 'view/header.php'; ?>
<?php require_once 'core/db.php'; ?>


<form action="" method="post">
    請輸入貨品資料：
    <p> 
    <label for="productid">貨品編號</label>
    <input name="productid" type="char" size="10"/>
   </p>
   
     <p> 
    <label for="productname">貨品名稱</label>
    <input name="productname" type="varchar" size="50"/>
    </p>
    
    <p> 
    <label for="type">型號</label>
    <input name="type" type="char" size="30"/>
     </p>
     
     <p> 
    <label for="company">產商</label>
    <input name="company" type="char" size="30" />
     </p>
     
     <p> 
    <label for="memo">備註</label>
    <input name="memo" type="char" size="30"/>
     </p>
    
    <input name="action" type="hidden" value="add" />
    <input type="submit" value="新增" />
</form>
<?php

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        //新增
        case 'add':
           $query = $pdo->prepare("INSERT INTO product (productid,productname,type,company)  VALUES(substr('{$_POST['productid']}',1,10),substr('{$_POST['productname']}',1,50),substr('{$_POST['type']}',1,30),substr('{$_POST['company']}',1,30));");
            $result = $query->execute();
            if ($result) {
                echo '<p>新增成功</p>';
            } else {
                echo "<p>新增失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
            //修改
        case 'edit_ok':
            $query = $pdo->prepare("UPDATE product SET productname = '{$_POST['productname']}' WHERE productid = '{$_POST['productid']}'");
            $result = $query->execute();
           

            if ($result) {
                echo '<p>編輯成功</p>';
            } else {
                echo "<p>編輯失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
        //刪除
        case 'delete':
            $query = $pdo->prepare("DELETE FROM product WHERE productid = '{$_POST['productid']}'");
            $result = $query->execute();

            if ($result) {
                echo '<p>刪除成功</p>';
            } else {
                echo "<p>刪除失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
    }
}
$query = $pdo->prepare('SELECT * FROM product');
$query->execute();

$total_rows =$query->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);

$query = $pdo->prepare('SELECT * FROM product LIMIT  :offset, :no_of_records_per_page');
$query->bindParam(':offset',$offset,PDO::PARAM_INT);
$query->bindParam(':no_of_records_per_page',$no_of_records_per_page,PDO::PARAM_INT);
$query->execute();






if ($query->rowCount() > 0) 
{
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    $edit = isset($_POST['action']) ? $_POST['action'] === 'edit' : false;
    $id = $edit ? $_POST['productid'] : null;

    echo '<table>';
    echo '<thead>';
    echo '<tr><th>貨品編號</td><th>貨品名稱</th><th>型號</th><th>廠商</th><th></th><th></th></tr>';    
    echo '</thead>';
    echo '<tbody>';
    foreach ($data AS $row) {
        if ($edit && $id === $row['productid']) {
            echo '<tr><td>' . $row['productid'] . '</td>';
            
            echo '<td><form action="" method="post"><input name="productname" value="' . $row['productname'] . '" /></td><td>' . $row['type'] . '</td><td>' . $row['company'] . '</td><td>';;
            
            echo '<input name="action" type="hidden" value="edit_ok" />';
            
            echo '<input name="productid" type="hidden" value="' . $row['productid'] . '" />';
            //echo '<input name="type" type="hidden" value="' . $row['type'] . '" />';
            echo '<input type="submit" value="確認" /></form></td><td></td></tr>';
        } 
        
        
        
        
        else {
            echo '<tr><td>' . $row['productid'] . '</td><td>' . $row['productname'] . '</td><td>' . $row['type'] . '</td><td>' . $row['company'] . '</td><td>';
            echo '<form action="" method="post">';
            echo '<input name="action" type="hidden" value="edit" />';
            echo '<input name="productid" type="hidden" value="' . $row['productid'] . '" />';
            echo '<input type="submit" value="編輯" /></form></td><td>';
            echo '<form action="" method="post">';
            echo '<input name="action" type="hidden" value="delete" />';
            echo '<input name="productid" type="hidden" value="' . $row['productid'] . '" />';
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




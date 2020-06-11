<?php require_once 'view/header.php'; ?>
<?php require_once 'core/db.php'; ?>
<?php require_once 'page.php'; ?>
<form action="" method="post">
    請輸入盤點資料：
    <p> 
    <label for="employeeid">員工編號</label>
    <input name="employeeid" type="char" size="10"/>
   </p>
     <p> 
     <label for="productid">貨品編號</label>
     <input name="productid" type="char" size="10"/>
     </p>
     
     <p>
     <label for="inventoryprice">價值</label>        
     <input name="inventoryprice" type="int"/>
     </p>
    
     <p>
     <label for="inventoryquantity">盤點數量</label>        
     <input name="inventoryquantity" type="int"/>
     </p>
     
     <p>
     <label for="inventorydate">盤點日期</label>
     <input name="inventorydate" type="date" />
     </p>
      

      
    <input name="action" type="hidden" value="add" />
    <input type="submit" value="新增" />
</form>
<?php

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        //新增
        case 'add':
      
           $query= $pdo->prepare("INSERT INTO `inventorydetail` (`employeeid`, `productid`, `inventoryprice`, `inventoryquantity`, `quantitydifference`, `inventorylosses`, `inventorydate`, `stockprice`, `stockquantity`) VALUES (substr('{$_POST['employeeid']}',1,10),substr('{$_POST['productid']}',1,10),{$_POST['inventoryprice']},{$_POST['inventoryquantity']}, NULL, NULL, substr('{$_POST['inventorydate']}',1,10), NULL, NULL);UPDATE `inventorydetail`SET inventorydetail.stockprice =(SELECT stockprice FROM stockdetail WHERE productid=inventorydetail.productid);UPDATE `inventorydetail`SET inventorydetail.stockquantity =(SELECT stockquantity FROM stockdetail WHERE productid=inventorydetail.productid); UPDATE `inventorydetail`SET inventorydetail.quantitydifference =(stockquantity-inventoryquantity); UPDATE `inventorydetail`SET inventorydetail.inventorylosses =((stockprice-inventoryprice)*quantitydifference);)");
            $result = $query->execute();
            if ($result) {
                echo '<p>新增成功</p>';
            } else {
                echo "<p>新增失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
            //修改
        case 'edit_ok':
            $query = $pdo->prepare("UPDATE inventorydetail SET productid = '{$_POST['productid']}' WHERE employeeid= '{$_POST['employeeid']}'");
            $result = $query->execute();

            if ($result) {
                echo '<p>編輯成功</p>';
            } else {
                echo "<p>編輯失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
        //刪除
        case 'delete':
            $query = $pdo->prepare("DELETE FROM inventorydetail WHERE employeeid= '{$_POST['employeeid']}'");
            $result = $query->execute();

            if ($result) {
                echo '<p>刪除成功</p>';
            } else {
                echo "<p>刪除失敗，錯誤訊息：" . $query->errorInfo[2] . '</p>';
            }
            break;
    }    
}
$query = $pdo->prepare('SELECT * FROM inventorydetail');
$query->execute();

$total_rows =$query->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);

$query = $pdo->prepare('SELECT * FROM inventorydetail LIMIT  :offset, :no_of_records_per_page');
$query->bindParam(':offset',$offset,PDO::PARAM_INT);
$query->bindParam(':no_of_records_per_page',$no_of_records_per_page,PDO::PARAM_INT);
$query->execute();
$query_employee = $pdo->prepare('SELECT * FROM employee WHERE employeeid=:employeeid');
$query_product = $pdo->prepare('SELECT * FROM product WHERE productid=:productid');




if ($query->rowCount() > 0) 


{
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    $edit = isset($_POST['action']) ? $_POST['action'] === 'edit' : false;
    $id = $edit ? $_POST['employeeid'] : null;

    echo '<table>';
    echo '<thead>';
    echo '<tr><th>員工編號​</td><th>貨品編號​</th><th>盤點日期​</th><th>盤差數量</th><th>盤虧數量</th><th></th><th></th></tr>';    
    echo '</thead>';
    echo '<tbody>';
    foreach ($data AS $row) {
         $employeeid=$row['employeeid'];
        $productid=$row['productid'];
        
        $query_employee->bindParam(':employeeid',$employeeid,PDO::PARAM_STR,10);
        $query_employee->execute();
        $query_product->bindParam(':productid',$productid,PDO::PARAM_STR,10);
        $query_product->execute();
        
        $product=$query_product->fetch(PDO::FETCH_ASSOC);
        
        $employee=$query_employee->fetch(PDO::FETCH_ASSOC);
        if ($edit && $id === $row['employeeid']) {
            echo '<tr><td>' . $row['employeeid'] . '</td>';
            echo '<td><form action="" method="post"><input name="productid" value="' . $row['productid'] . '" /></td><td></td><td></td><td></td><td>';
            echo '<input name="action" type="hidden" value="edit_ok" />';
            echo '<input name="employeeid" type="hidden" value="' . $row['employeeid'] . '" />';
            
            echo '<input type="submit" value="確認" /></form></td><td></td></tr>';
        } else {
            echo '<tr><td>' . $row['employeeid'] . '</td><td>' . $row['productid'] . '</td><td>' . $row['inventorydate'] . '</td><td>' . $row['quantitydifference'] . '</td><td>' . $row['inventorylosses'] . '</td><td>';
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
} else {
    echo '目前沒有資料';
}
$pdo=null;
?>
     
<?php require_once 'view/footer.php'; ?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>demo</title>
    </head>
    <style>     
        * {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Style the header */
header {
  background-color: #666;
  padding: 30px;
  text-align: center;
  font-size: 35px;
  color: white;
}

/* Container for flexboxes */
section {
  display: -webkit-flex;
  display: flex;
}

/* Style the navigation menu */
nav {
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
nav ul {
  list-style-type: none;
  padding: 0;
}

/* Style the content */
article {
  -webkit-flex: 3;
  -ms-flex: 3;
  flex: 3;
  background-color: #f1f1f1;
  padding: 10px;
}

/* Style the footer */
footer {
  background-color: #777;
  padding: 10px;
  text-align: center;
  color: white;
}

/* Responsive layout - makes the menu and the content (inside the section) sit on top of each other instead of next to each other */
@media (max-width: 600px) {
  section {
    -webkit-flex-direction: column;
    flex-direction: column;
  }
}
        table{
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead{
            background: #ddd;
        }
        
        td, th{
            border: 1px solid #ccc;
            padding: 6px;
        }
        
        tbody tr:nth-child(even){
            background: #eee;
        }
      pagenation {
  background-color: #777;
  padding: 10px;
  text-align: center;
  color: white;
          }
    </style>
    <body>
    <header>
  <h2>公司資料庫應用</h2>
</header>
<div class="topnav">
  <a href="index.php">員工資料維護</a>
   <a href="product.php">產品資料</a>
 <a href="StockDetail.php">入庫明細</a>
  <a href="InventoryDetail.php">盤點明細</a>
</div>


  








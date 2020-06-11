 <div class="content">
<ul class="pagenation">
<a href="?pageno=1">第1頁</a>
        <class= "<?php if($pageno <= 1)
        { echo 'disabled'; } ?> " >
            
            <a href= " <?php if($pageno <=1)
            { echo '#errrrrr'; } 
            else { echo "?pageno=". ($pageno - 1); } ?>" >上1頁</a>
                       
          <?php echo '第'. $pageno .'頁';  ?> 
            
        <class = "<?php if ($pageno >= $total_pages) {echo'disabled';} ?>">
            
            <a href=" <?php if ($pageno >= $total_pages) { echo'#'; } 
            else {echo "?pageno=". ( $pageno + 1 ) ;  } ?>" >下一頁</a>
            
            
        <a href="?pageno=<?php echo $total_pages; ?>">最後頁</a>
    </ul>
        </div> 
  
</body>
</html>


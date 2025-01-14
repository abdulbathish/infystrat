<?php include "top_head.php";?>

<!-- Body BEGIN -->
<body class="corporate">
   
   <!-- Header Start -->
		<?php include "header.php";
		$sel_down = "select * from general_pages where status=1 and id=9";
		$res_down = q($sel_down,$dbconnect);
		$row_down = f($res_down);
			if($row_down['url_title']!=''){
				$down_link = str_replace(" ","-",$row_down['url_title']);
			}else{
				$down_link1 = str_replace(" ","-",$row_down['page_title']);
				$down_link = strtolower($down_link1);
			}

		$sel_pdf = "select * from tbl_download where fld_status=1 order by fld_id ASC";
		$res_pdf = q($sel_pdf,$dbconnect);
		$cnt_download = nr($res_pdf);
		?>
   <!-- Header END -->


    <div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo $base_url;?>index.php">Home</a></li>
            <li><a href="#"><?php echo $page_subtitle;?></a></li>            
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12">
            <h1><?php echo $page_subtitle;?></h1>
            <div class="content-page">
              <div class="row">                
                <div class="col-md-9 col-sm-9 blog-posts">

                  <?php 
					$count=1;
					if($cnt_download>0){
					while($row_pdf = f($res_pdf)){ 					
					$download_title=$row_pdf['fld_title'];
					$download_intro=$row_pdf['fld_intro_text'];
					$pdf = $row_pdf['fld_pdf'];
					$pdf_path = "download_images/".$row_pdf['fld_pdf'];
				  ?>
				  <div class="row">                    
                    <div class="col-md-12 col-sm-12">
                      <h2><?php echo $download_title;?></h2>                     
                      <p><?php echo $download_intro;?></p> 
					  <?php if($pdf!="") { ?>
					  <p><a href="<?php echo $pdf_path;?>" target="_blank"><img src="<?php echo $base_url;?>images/pdf_icon.png"></a>&nbsp;&nbsp;<a href="<?php echo $pdf_path;?>" target="_blank">Click here to download file</a></p>
					  <?php } ?>
                    </div>
                  </div>
                  <?php if($count < $cnt_download){ ?>
				  <hr class="blog-post-sep">
				  <?php } ?>
				  <?php $count++; } //end while ?>
				  <?php }  else { ?>
					<p>No download file found...</p>
				  <?php } ?>
                  
                  <!--<hr class="blog-post-sep">
                  <ul class="pagination">
                    <li><a href="#">Prev</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="active"><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">Next</a></li>
                  </ul> -->              
                </div>
                <!-- END LEFT SIDEBAR -->

                <!-- BEGIN RIGHT SIDEBAR --> 
					<?php include "right_sidebar.php";?>
				<!-- BEGIN RIGHT SIDEBAR --> 
          
              </div>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>

   <!-- START FOOTER -->
	<?php include "footer.php"; ?>
   <!-- END FOOTER -->

</body>
<!-- END BODY -->
</html>
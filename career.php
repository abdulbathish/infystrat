<?php
include('db/config.php');
include('mail_test.php');
	$sql = "select * from tbl_job";
	$result = @mysql_query($sql, $dbconnect);
	
	if(@mysql_numrows($result) > 0){
	    $txt = '';
    	while($row = @mysql_fetch_array($result)) {
    	    $txt .='<div class="col-xl-12 col-lg-12 job-list-wrapper">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>'.$row["fld_jobname"].'</h5>
                    </div>
                    <div class="col-sm-3 text-center">
                        <h5>Position</h5>
                        <p>'.$row[fld_position].'</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <h5>Location</h5>
                        <p>'.$row[fld_location].'</p>
                    </div>
                    <div class="col-sm-2 text-center m-auto">
                        <a href="#" class="job-apply" data-toggle="modal" data-target="#resumeModal">Apply</a>
                    </div>
                </div>
            </div>';
    	}       
	}
	include $htmlfile."career.html";
	
	$postData = $uploadedFile = $statusMsg = '';
    $msgClass = 'errordiv';
if(isset($_POST['submit'])){
        $name = $_POST['name'];
   
    // Check whether submitted data is not empty
    if(!empty($name)){
        $uploadStatus = 1;
    
        if(!empty($_FILES["attachment"]["name"])){
            $targetDir = "uploads/";
            $fileName = basename($_FILES["attachment"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
            
            if(in_array($fileType, $allowTypes)){
                if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $targetFilePath;
                }else{
                    $uploadStatus = 0;
                    $statusMsg = "Sorry, there was an error uploading your file.";
                    echo "<script>alert('Sorry, there was an error uploading your file')</script>";
                }
            }else{
            $uploadStatus = 0;
            echo '<script>alert("Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload")</script>';
            $statusMsg = 'Sorry, only PDF, DOC files are allowed to upload.';
            }
        }
        if($uploadStatus == 1){
            if(!empty($uploadedFile) && file_exists($uploadedFile)){
                
                $fileatt = $uploadedFile;
                $fileatt_type = $fileType;
                $fileatt_name = $fileName;
                
                $fromName = 'Infystrat';
                $email_from = "careers@Infystrat.com"; // Who the email is from
                $email_subject = "New Job application from ".$name; // The Subject of the email
                $email_message = $name." has been applied for the job, Please find the below resume of the candidate.
                ";
            
                $email_to = 'careers@Infystrat.com'; // Who the email is to
            
                $headers = "From: ".$email_from;
            
                $file = fopen($fileatt,'rb');
                $data = fread($file,filesize($fileatt));
                fclose($file);
            
                $semi_rand = md5(time());
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
            
                $headers .= "\nMIME-Version: 1.0\n" .
                "Content-Type: multipart/mixed;\n" .
                " boundary=\"{$mime_boundary}\"";
            
                $email_message .= "This is a multi-part message in MIME format.\n\n" .
                "--{$mime_boundary}\n" .
                "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" .
                $email_message .= "\n\n";
            
                $data = chunk_split(base64_encode($data));
            
                $email_message .= "--{$mime_boundary}\n" .
                "Content-Type: {$fileatt_type};\n" .
                " name=\"{$fileatt_name}\"\n" .
                //"Content-Disposition: attachment;\n" .
                //" filename=\"{$fileatt_name}\"\n" .
                "Content-Transfer-Encoding: base64\n\n" .
                $data .= "\n\n" .
                "--{$mime_boundary}--\n";
            
                $ok = @mail($email_to, $email_subject, $email_message, $headers);
            
                if($ok) {
               echo '<script>alert("Your contact request has been submitted successfully !")</script>';
            
                } else {
                echo '<script>alert("Your contact request submission failed, please try again.")</script>';
                }
                 @unlink($uploadedFile);
                
            }
        }
    }else{
        echo '<script>alert("Please fill all the fields.")</script>';
    $statusMsg = 'Please fill all the fields.';
    }
}
?>
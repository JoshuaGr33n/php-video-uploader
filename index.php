<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$targetDir = "uploads/";
$uploadStatus = 1;
$uploadedFile = '';
if(isset($_POST["submit"])) {
    $fileName = basename($_FILES["videoFile"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    $allowTypes = array('mp4','avi','3gp','mov','mpeg');
    if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["videoFile"]["tmp_name"], $targetFilePath)){
            $uploadedFile = $fileName;
            $uploadStatus = 1;
        }else{
            $uploadStatus = 0;
        }
    }else{
        $uploadStatus = 2;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Upload and Display</title>
</head>
<body>

<?php if($uploadStatus == 1): ?>
    <p>File successfully uploaded.</p>
    <video width="320" height="240" controls>
      <source src="<?php echo $targetDir . $uploadedFile; ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
<?php elseif($uploadStatus == 0): ?>
    <p>Sorry, there was an error uploading your file.</p>
<?php elseif($uploadStatus == 2): ?>
    <p>Sorry, only MP4, AVI, 3GP, MOV, and MPEG files are allowed.</p>
<?php endif; ?>

<h2>Upload a Video File</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    Select video to upload:
    <input type="file" name="videoFile" id="videoFile">
    <input type="submit" value="Upload Video" name="submit">
</form>

</body>
</html>

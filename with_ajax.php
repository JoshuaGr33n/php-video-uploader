<?php
if(isset($_FILES['videoFile']['name'])){
    $targetDir = "uploads/";
    $fileName = basename($_FILES['videoFile']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('mp4','avi','3gp','mov','mpeg', 'png');
    if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES['videoFile']['tmp_name'], $targetFilePath)){
            echo $targetFilePath;
        }else{
            echo "err";
        }
    }else{
        echo "type_err";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Upload and Display</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'with_ajax.php',
                type: 'post',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != "err" && response != "type_err"){
                        $("video").find("source").attr("src", response);
                        $("video")[0].load();
                        alert("File successfully uploaded.");
                    }else if(response == "type_err"){
                        alert("Sorry, only MP4, AVI, 3GP, MOV, and MPEG files are allowed.");
                    }else{
                        alert("Sorry, there was an error uploading your file.");
                    }
                }
            });
        });
    });
    </script>
</head>
<body>

<video width="320" height="240" controls>
    <source src="movie.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<h2>Upload a Video File</h2>
<form action="with_ajax.php" method="post" enctype="multipart/form-data">
    Select video to upload:
    <input type="file" name="videoFile" id="videoFile">
    <input type="submit" value="Upload Video" name="submit">
</form>

</body>
</html>

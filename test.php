<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <?php
        if(isset($_POST['submit'])){
            if(move_uploaded_file($_FILES['image']['tmp_name'], './images/'.$_FILES['image']['name'])){
                echo "finished";

            }else{
                echo "Unfinished";
            }

        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="file"name="image">
    <input type="submit" name="submit">
</form>

</body></html>


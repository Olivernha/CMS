<?php

if(isset($_GET['edit_user_id'])) {
    $the_user_id = escape($_GET['edit_user_id']);

    $query="Select * From users WHERE user_id=$the_user_id";
    $select_users=mysqli_query($connection,$query);
//    confirm($select_comments);
    while($row=mysqli_fetch_assoc($select_users)) {
        $user_id = escape($row['user_id']);
        $username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_image = escape($row['user_image']);
        $user_role = escape($row['user_role']);
    }
    ?>
    <?php

    if(isset($_POST['edit_user'])) {

        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
//    $post_image=$_FILES['image']['name'];
//    $post_image_temp=$_FILES['image']['tmp_name'];

        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);
//        $post_date=date('d-m-y');
        //  $post_comment_count=4;

        //move_uploaded_file($post_image_temp,"../images/$post_image");
        /*$query = "SELECT randSalt FROM users";
        $select_randSalt_query = mysqli_query($connection, $query);
        if (!$select_randSalt_query) {
            die('Query Failed' . mysqli_error($connection));
        }
        $row = mysqli_fetch_array($select_randSalt_query);
        $randSalt = $row['randSalt'];
        $hashed_password=crypt($user_password,$randSalt);*/

        if (!empty($user_password)) {
            $query_password = "Select user_password From users Where user_id=$the_user_id";
            $get_user = mysqli_query($connection, $query_password);
            confirm($get_user);

            $row = mysqli_fetch_array($get_user);
            $db_user_password = escape($row['user_password']);

            if ($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }
            $query = "UPDATE users SET";
            $query .= " user_firstname ='{$user_firstname}',";
            $query .= " user_lastname ='{$user_lastname}',";
            $query .= " user_role='{$user_role}',";
            $query .= " username='{$username}',";
            $query .= " user_email='{$user_email}',";
            $query .= " user_password='{$hashed_password}'";
            $query .= " WHERE user_id={$the_user_id}";

            $update_user = mysqli_query($connection, $query);
            confirm($update_user);
            echo "<p class='bg-success'>User Updated :" . " " . "<a href='./users.php'>View Users</a>" . " or " . "<a href='../registration.php'>Add More Users</a></p>";
        }
    }
}
else{
    header("Location:index.php");
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" value="<?php echo $user_firstname;?>" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" value="<?php echo $user_lastname;?>"class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <select name="user_role" id="" >
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if($user_role == 'admin'){
                echo " <option value=\"subscriber\">subscriber</option>";
            }
            else{
                echo "<option value=\"admin\">admin</option>";
            }

            ?>



        </select>

    </div>

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" value="<?php echo $username;?>"class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="email" value="<?php echo $user_email;?>" class="form-control" name="user_email">
    </div>
    <!--    <div class="form-group">-->
    <!--        <label for="post_image">Post Image</label>-->
    <!--        <input type="file"  name="image">-->
    <!--    </div>-->
    <div class="form-group">
        <label for="post_tags">Password</label>
        <input autocomplete="off" type="password"  class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>

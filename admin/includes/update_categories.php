
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
        <?php
        if(isset($_GET['edit'])){
            $edit_id=escape($_GET['edit']);


            $query="SELECT * FROM categories WHERE cat_id=$edit_id";
            $select_categories_id=mysqli_query($connection,$query);

            while($row=mysqli_fetch_assoc( $select_categories_id)){
                $cat_id=escape($row['cat_id']);
                $cat_title=escape($row['cat_title']);
                ?>
                <input value="<?php if($cat_title) echo $cat_title; ?>" type="text" class="form-control" name="update_cat_title">
            <?php  }} ?>


        <?php
        if(isset($_POST['update_query'])) {


            $edit_title = escape($_POST['update_cat_title']);
            $edit_id=escape($_GET['edit']);

            if($edit_title == "" || empty($edit_title)){
                echo '<script>alert("This field shouldn\'t be empty")</script>';
            }
            else{
                $stmt=mysqli_prepare($connection,"UPDATE categories SET cat_title=?  WHERE cat_id=?");
                mysqli_stmt_bind_param($stmt,'si',$edit_title,$edit_id);
                mysqli_stmt_execute($stmt);


                if(!$stmt){
                    die('Query Failed').mysqli_error($result);
                }
                mysqli_stmt_close($stmt);
                redirect("categories.php");
            }

        }
        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_query" value="Edit Category">
    </div>
</form>
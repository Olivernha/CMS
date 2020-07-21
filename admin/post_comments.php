<?php include "includes/admin_header.php" ?>
<?php ob_start(); ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_nav.php" ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Comment
                        <small>Author</small>
                    </h1>
                    <?php
                    if(isset($_POST['checkBoxArray'])){
                        foreach($_POST['checkBoxArray'] as $postValueId){
                            $bulk_options= escape($_POST['bulk_options']);

                            switch ($bulk_options){
                                case 'published':
                                    $query="Update posts Set post_status='{$bulk_options}' WHERE post_id={$postValueId}";
                                    $update_to_published_status=mysqli_query($connection,$query);
                                    confirm($update_to_published_status);
                                    break;


                                case 'draft':
                                    $query="Update posts Set post_status='{$bulk_options}' WHERE post_id={$postValueId}";
                                    $update_to_draft_status=mysqli_query($connection,$query);
                                    confirm($update_to_draft_status);
                                    break;

                                case 'delete':

                                    $query="Delete From posts WHERE post_id={$postValueId}";
                                    $update_to_deleted_status=mysqli_query($connection,$query);
                                    confirm($update_to_deleted_status);
                                    break;

                                case 'clone':
                                    $query="Select * From posts where post_id='{$postValueId}'";
                                    $select_post_query=mysqli_query($connection,$query);

                                    while($row=mysqli_fetch_array($select_post_query)){
                                        $post_title=escape($row['post_title']);
                                        $post_category_id=escape($row['post_category_id']);
                                        $post_date=escape($row['post_date']);
                                        $post_author=escape($row['post_author']);
                                        $post_status=escape($row['post_status']);
                                        $post_image=escape($row['post_image']);
                                        $post_tags=escape($row['post_tags']);
                                        $post_content=escape($row['post_content']);

                                    }
                                    $query="INSERT INTO posts(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_status)";
                                    $query .="VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
                                    $copy_query=mysqli_query($connection,$query);
                                    if(!$copy_query){
                                        die("Query Failed".mysqli_error($connection));
                                    }
                            }
                        }
                    }

                    ?>
                    <form action="" method="post">
                        <table class="table table-bordered table-hover">
                            <div id="bulkOptionsContainer" class="col-xs-4" style="padding: 0px;">
                                <select class="form-control" name="bulk_options" id="" >
                                    <option value="">Select Options</option>
                                    <option value="published">Publish</option>
                                    <option value="draft">Draft</option>
                                    <option value="delete">Delete</option>
                                    <option value="clone">Clone</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                                <!--        <a href="./posts.php?source=add_posts" class="btn btn-primary">Add New</a>-->
                            </div>
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAllBoxes"></th>
                                <th>ID</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>In Response to</th>
                                <th>Date</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query="Select * From comments WHERE comment_post_id=".mysqli_real_escape_string($connection,$_GET['id']);
                            $select_comments=mysqli_query($connection,$query);
                            //    confirm($select_comments);
                            while($row=mysqli_fetch_assoc($select_comments)){
                                $comment_id=escape($row['comment_id']);
                                $comment_post_id=escape($row['comment_post_id']);
                                $comment_author=escape($row['comment_author']);
                                $comment_content=escape($row['comment_content']);
                                $comment_email=escape($row['comment_email']);
                                $comment_status=escape($row['comment_status']);
                                $comment_date=escape($row['comment_date']);

                                echo  "<tr>";
                                ?>
                                <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id?>"></td>
                                <?php
                                echo "<td>$comment_id</td>";
                                echo "<td> $comment_author</td>";
                                echo "<td> $comment_content</td>";

//        $query="select * from categories where cat_id={$post_category_id}";
//        $select_cat_id=mysqli_query($connection,$query);
//
//        while($row=mysqli_fetch_assoc($select_cat_id)){
//            $cat_id=$row['cat_id'];
//            $cat_title=$row['cat_title'];
//            echo "<td> {$cat_title}</td>";
//        }

                                echo "<td>  $comment_email</td>";
                                echo "<td>  $comment_status</td>";

                                $query="Select * From posts Where post_id= $comment_post_id";
                                $select_post_id_query=mysqli_query($connection,$query);
                                while($row=mysqli_fetch_assoc($select_post_id_query)){
                                    $post_id=escape($row['post_id']);
                                    $post_title=escape($row['post_title']);

                                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                }



                                echo "<td>$comment_date</td>";

                                echo "<td> <a href='comments.php?approve=$comment_id'>Approve</a></td>";
                                echo "<td> <a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                                //    echo "<td> <a href='posts.php?source=edit_posts&p_id='>Edit</a></td>";
                                echo "<td> <a href='post_comments.php?delete=$comment_id&id=".$_GET['id']."'>Delete</a></td>";
                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>
                    </form>
                    <?php
                    if(isset($_GET['approve'])){
                        $approve_id=escape($_GET['approve']);

                        $query="UPDATE comments SET comment_status='approved' Where comment_id= $approve_id ";
                        $approve_query=mysqli_query($connection,$query);
                        header('location:comments.php');
                    }

                    if(isset($_GET['unapprove'])){
                        $unapprove_id=escape($_GET['unapprove']);
                        $query="UPDATE comments SET comment_status='unapproved' Where comment_id= $unapprove_id ";
                        $unapprove_query=mysqli_query($connection,$query);
                        header('location:comments.php');
                    }

                    if(isset($_GET['delete'])){
                        $the_comment_id=escape($_GET['delete']);
                        $query="Delete From comments Where comment_id ={$the_comment_id}";
                        $delete_query=mysqli_query($connection,$query);
                        header("location:post_comments.php?id=".$_GET['id']."");
                    }
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>

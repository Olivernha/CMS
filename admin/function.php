
<?php

//=======Database Helpers Function =======//



function currentUser(){
    if(isset($_SESSION['username'])){
        return $_SESSION['username'];
    }
    return false;
}

function imagePlaceholder($image=''){
    if(!$image){
        return '3.jpg';
    }
    else{
        return $image;
    }
}
function redirect($location){
    return header("Location:".$location);
//    exit;
}
function query($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    confirm($result);
    return $result ;
}
function fetchRecords($result){
    return mysqli_fetch_array($result);
}
function count_records($result){
    return mysqli_num_rows($result);
}
//=== End Database help  ers ====//

//======General helper ===//

function get_user_name(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;

}
//======End General helper ===//

//======Authentication helper ===//
function is_admin(){
    if(isLoggedIn()) {
        $result=query("Select user_role From users WHERE user_id = ".$_SESSION['user_id']." ");
        $row = mysqli_fetch_array($result);
        if ($row['user_role'] = 'admin') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
//======End Authentication helper ====//
//======User Specific helper ====//

function get_all_user_posts(){

    return query("Select * From posts WHERE user_id=" . loggedInUserId()." ");

}
function get_all_post_user_comments(){
    return query("Select * From posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE user_id=".loggedInUserId()." ");
}
function get_all_user_categories(){
    return query("Select * From categories WHERE user_id=" . loggedInUserId()." ");
}
function get_all_user_published_posts(){
    return query("Select * From posts WHERE user_id=" . loggedInUserId()." AND post_status='published'");
}
function get_all_user_drafted_posts(){
    return query("Select * From posts WHERE user_id=" . loggedInUserId()." AND post_status='draft'");
}
function get_all_user_approved_post_comments(){
    return query("Select * From posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status='approved'");
}
function get_all_user_unapproved_post_comments(){
    return query("Select * From posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status='unapproved' ");
}
function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection,trim($string));
}
function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}
function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}
function loggedInUserId(){
    if(isLoggedIn()) {
        $result = query("Select * From users WHERE username='" . $_SESSION['username'] . "'");
        confirm($result);
        $users = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $users['user_id'] : false;
    }
}
function userLikedThisPost($post_id){
    $result=query("Select * From likes WHERE user_id=". loggedInUserId()." AND post_id={$post_id}");
    confirm($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}
function getPostlikes($post_id){
    $result=query("Select * From likes WHERE post_id=$post_id");
    confirm($result);
    echo mysqli_num_rows($result);
}
function user_online(){
    if(isset($_GET['onlineusers'])) {
        global $connection;

        if(!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "Select * From user_online WHERE session ='$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "Insert Into user_online(session ,time) Values ('$session','$time')");
            }else {
                mysqli_query($connection, "Update user_online Set time ='$time' where session ='$session'");
            }
            $user_online_query = mysqli_query($connection, "Select * From user_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($user_online_query);

        }
    } //get request isset
}
user_online();

function insert_function(){
    global $connection;
    if(isset($_POST['submit'])){
        $cat_title=$_POST['cat-title'];

        if($cat_title == "" || empty($cat_title)){
            echo '<script>alert("This field shouldn\'t be empty")</script>';
        }
        else{
            $stmt=mysqli_prepare($connection,"INSERT INTO categories(cat_title) VALUE (?)");
            mysqli_stmt_bind_param($stmt,'s',$cat_title);
            mysqli_stmt_execute($stmt);


            if(!$stmt){
                die('QUERY FAILED').mysqli_error($connection);
            }
            mysqli_stmt_close($stmt);
        }

    }
}

function findAllCategories(){
    global $connection;
    $query="SELECT * FROM categories";
    $result=mysqli_query($connection,$query);
    while($row=mysqli_fetch_assoc($result)){
        $cat_id=$row['cat_id'];
        $cat_title=$row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>";
        echo "</tr>";
    }
}
function deleteCategories(){
    global $connection;

    if(isset($_GET['delete'])){
        $delete_id=$_GET['delete'];
        $query="DELETE FROM categories WHERE cat_id= $delete_id";
        $delete_query=mysqli_query($connection,$query);
        header('location: categories.php');

    }
}

function confirm($result){
    global $connection;
    if(!$result){
        die("Query Failed".mysqli_error($connection));
    }
}
function recordCount($table){
    global $connection;
    $query="Select * From ".$table;
    $select_all=mysqli_query($connection,$query);
    return mysqli_num_rows($select_all);
}
function checkStatus($table,$column,$status){
    global $connection;
   // $query="SELECT * From" . $table ."where" . $column . " =".$status;
    $query="Select * From $table WHERE $column = '$status'";
    $select_all=mysqli_query($connection,$query);
    return mysqli_num_rows($select_all);
}

function checkUserRole($table,$column,$role){
    global $connection;
    // $query="SELECT * From" . $table ."where" . $column . " =".$status;
    $query="Select * From $table WHERE $column = '$role'";
    $select_all=mysqli_query($connection,$query);
    return mysqli_num_rows($select_all);
}

function username_exists($username){
    global $connection;
    $query="Select username From users WHERE username='$username'";
    $result=mysqli_query($connection,$query);
    confirm($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    else{
        return false;
    }
}

function email_exists($email){
    global $connection;
    $query="Select user_email From users WHERE user_email='$email'";
    $result=mysqli_query($connection,$query);
    confirm($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    else{
        return false;
    }
}

function register_user($username,$email,$password){
    global $connection;
    $username=mysqli_real_escape_string($connection,$username);
    $email=mysqli_real_escape_string($connection,$email);
    $password=mysqli_real_escape_string($connection,$password);

    $password=password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));

//         $query = "SELECT randSalt FROM users";
//         $select_randSalt_query = mysqli_query($connection, $query);
//
//         if (!$select_randSalt_query) {
//             die('Query Failed' . mysqli_error($connection));
//         }
//
//         $row = mysqli_fetch_array($select_randSalt_query);
//         $randSalt = $row['randSalt'];
//         $password=crypt($password,$randSalt);
        $query ="Insert Into users(username,user_email,user_password,user_role)";
        $query .="Values('{$username}','{$email}','{$password}','subscriber')";

        $register_user_query = mysqli_query($connection, $query);
        confirm($register_user_query);
     //   $message="Your registration has been submitted";

}

function login_user($username,$password){
    global $connection;
    $username= trim($username);
    $password =trim($password);
    $username=mysqli_real_escape_string($connection,$username);
    $password=mysqli_real_escape_string($connection,$password);

    $query="SELECT * FROM users WHERE username='{$username}'";
    $select_user_query=mysqli_query($connection,$query);
    if(!$select_user_query){
        die("Query Failed".mysqli_error($connection));
    }
    while ($row=mysqli_fetch_array($select_user_query)){
        $db_user_id=$row['user_id'];
        $db_username=$row['username'];
        $db_user_password=$row['user_password'];
        $db_user_firstname=$row['user_firstname'];
        $db_user_lastname=$row['user_lastname'];
        $db_user_role=$row['user_role'];

        if(password_verify($password,$db_user_password) && $db_user_role == 'admin'){
            $_SESSION['user_id']=$db_user_id;
            $_SESSION['username']=$db_username;
            $_SESSION['firstname']=$db_user_firstname;
            $_SESSION['lastname']=$db_user_lastname;
            $_SESSION['user_role']=  $db_user_role;

            redirect("/cms/admin");
        }
        else{
            return false;
        }
    }
    // $password=crypt($password, $db_user_password);


}
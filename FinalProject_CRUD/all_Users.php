<?php session_start();
	// add values of variables of title and description
	$title = "A base all user homepage";
	$description = "All users page";

	require_once './reuse_file/header.php';
	require_once './reuse_file/Database.php';

    // account table: users
    $table_admins = 'users';

    if(isset($_SESSION['user_id'])){
        if(!isset($db)){
            $db = new Database();
        }

        $usersInfo = $db->displayData($table_admins);

    } else {
        header("Location:index.php?protectMsg=Please Log In First");
    }

    if(isset($_GET['DeleteUserId'])) {
	    $deleteColumn = 'user_id';
	    $deleteUserId = (int)$_GET['DeleteUserId'];
	    var_dump($deleteUserId);
	    $delete = $db->deleteDateById($table_admins, $deleteUserId, $deleteColumn);
	    // if user delete itself account
	    if ($_SESSION['user_id'] == $deleteUserId && $delete) {
		    header("Location:index.php?LogoutMsg=You Deleted itself account, please register again");
	    } else {
		    $delete ? header("Location:all_Users.php?deletedUserMsg=Deleted Successfully") :
			    header("Location:all_Users.php?deletedUserMsg=Deleted Failed");
	    }
    }
?>
<!-- All Users Name section -->
<section class="all_user_section">
	<?php
	if(isset($_GET['updateMsg'])){
		echo '<div class="alert alert-danger" role="alert">';
		echo $_GET['updateMsg'];
		echo '</div>';
	}
	if(isset($_GET['deletedUserMsg'])){
		echo '<div class="alert alert-info m-auto text-center" role="alert">';
		echo $_GET['deletedUserMsg'];
		echo '</div>';
	}
	?>
	<ul class="list-group pt-1">
        <li class="list-group-item list-group-item-danger">
            <div class="d-flex">
                <p class="m-auto">User Name</p>
                <p class="m-auto">User Email</p>
                <a class="btn btn-warning m-1" href="index.php">Home</a>
                <a class="btn btn-danger m-1" href="index.php?LogoutMsg=Log Out Successfully">Log Out</a>
            </div>
        </li>
        <?php
            foreach ($usersInfo as $value) {
        ?>
		<li class="list-group-item list-group-item-warning mt-1">
			<div class="d-flex">
				<p class="m-auto"><?php echo $value['username']; ?></p>
                <p class="m-auto"><?php echo $value['email']; ?></p>
				<a class="btn btn-warning m-1" href="editUserInfo.php?UpdateUserId=<?php echo $value['user_id']; ?>">Update</a>
				<a class="btn btn-danger m-1" href="all_Users.php?DeleteUserId=<?php echo $value['user_id']; ?>">Delete</a>
			</div>
		</li>
        <?php } ?>
	</ul>
</section>

<?php
    require_once './reuse_file/footer.php';
?>
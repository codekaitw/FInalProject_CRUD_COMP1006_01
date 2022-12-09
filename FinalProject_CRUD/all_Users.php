<?php session_start();
	// add values of variables of title and description
	$title = "A base profile homepage";
	$description = "Assignment 3 index page";

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

    if(isset($_GET['DeleteUserId'])){
        $deleteColumn = 'user_id';
        $delete = $db->deleteDateById($table_admins, $_GET['DeleteUserId'], $deleteColumn);
        $delete ? header("Location:all_Users.php?deletedUserMsg=Deleted Successfully") :
	        header("Location:all_Users.php?deletedUserMsg=Deleted Failed");
    }
?>

<!-- All Users Name section -->
<section class="container">
	<ul class="list-group pt-1">
        <li class="list-group-item">
            <div class="d-flex">
                <p class="m-auto">User Name</p>
                <a class="btn btn-warning m-1" href="index.php">Home</a>
                <a class="btn btn-danger m-1" href="index.php?LogoutMsg=Log Out Successfully">Log Out</a>
            </div>
        </li>
        <?php
            foreach ($usersInfo as $value) {
        ?>
		<li class="list-group-item list-group-item-info mt-1">
			<div class="d-flex">
				<p class="m-auto"><?php echo $value['username']; ?></p>
				<a class="btn btn-warning m-1" href="editUserInfo.php?UpdateUserId=<?php echo $value['user_id']; ?>">Update</a>
				<a class="btn btn-danger m-1" href="all_Users.php?DeleteUserId=<?php echo $value['user_id']; ?>">Delete</a>
			</div>
		</li>
        <?php } ?>
	</ul>
</section>
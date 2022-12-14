<?php
// add values of variables of title and description
$title = "Update User Info Page";
$description = "update user information page";

require_once './reuse_file/header.php';
require_once './reuse_file/Database.php';

// account table: users
$table_admins = 'users';

// display data
if(isset($_GET['UpdateUserId'])) {
	if(!isset($db)) {
		$db = new Database();
	}
    $currentEditUserId = $_GET['UpdateUserId'];
	$userInfo = $db->displayData($table_admins, array('where' => array('user_id' => $currentEditUserId), 'return_type' => 'single'));
}

// update form post
if(isset($_POST['update']) && $_POST['update'] == 'Update'){
	if(!isset($db)) {
		$db = new Database();
	}

	// store info to variable
	$updateData = array(
		'username' => $_POST['update_username'],
		'password' => $_POST['update_password'],
		'email'    => $_POST['update_email'],
        'user_id'  => $_POST['update_user_id']
	);
	$confirmPassword = $_POST['update_confirmPassword'];
	$updateUserId = $_POST['update_user_id'];
	// check input whether error
	$updateUserInputIsValid =  $db->inputErrorCheck_SignupUpdateData($updateData, $confirmPassword);
	if(is_bool($updateUserInputIsValid) && $updateUserInputIsValid){
		// check username and email are unique in database except current user info
        $conditions = array('updateUser' => $updateUserId);
		$updateUserDataIsUnique = $db->checkSignupUpdateDataValid($table_admins, $updateData, $conditions);

		if(is_bool($updateUserDataIsUnique) && $updateUserDataIsUnique){
			// update data
            $updateUserColumn = 'user_id';
			$update = $db->updateData($table_admins, $updateData, $updateUserColumn);
			$update ? header("Location:all_Users.php?updateMsg=Updated Successfully") :
				header("Location: editUserInfo.php?UpdateUserId=$updateUserId&updateMsg=Not Updated Successfully");
		} elseif (is_string($updateUserDataIsUnique)){
			header("Location:editUserInfo.php?UpdateUserId=$updateUserId&updateMsg=$updateUserDataIsUnique");
		}
	}elseif(is_string($updateUserInputIsValid)){
		header("Location:editUserInfo.php?UpdateUserId=$updateUserId&updateMsg=$updateUserInputIsValid");
	}
}

?>

<section class="signup-custom">
	<div class="container d-flex justify-content-center h-100">
		<div class="card" id="signup-custom-card">
			<div class="card-header text-center">
				<?php
				if(isset($_GET['updateMsg'])){
					echo '<div class="alert alert-danger" role="alert">';
					echo $_GET['updateMsg'];
					echo '</div>';
				}
				?>
				<h3>Update</h3>
			</div>
			<div class="card-body">
				<form action="editUserInfo.php?UpdateUserId=<?php echo $userInfo['user_id']; ?>" method="post">
                    <!-- Hidden user id -->
                    <input type="hidden" name="update_user_id" value="<?php echo $userInfo['user_id']; ?>">
					<div class="input-group form-group mb-4">
						<input type="text" class="form-control" placeholder="username" name="update_username" value="<?php echo $userInfo['username']; ?>">
					</div>
					<div class="input-group form-group mb-4">
						<input type="password" class="form-control" placeholder="password" name="update_password" value="<?php echo $userInfo['password']; ?>">
					</div>
					<div class="input-group form-group mb-4">
						<input type="password" class="form-control" placeholder="confirm password" name="update_confirmPassword" value="<?php echo $userInfo['password']; ?>">
					</div>
					<div class="input-group form-group mb-4">
						<input type="email" class="form-control" placeholder="Email" name="update_email" value="<?php echo $userInfo['email']; ?>">
					</div>
					<div class="form-group text-center">
						<input type="submit" name="update" value="Update" class="btn float-right login_btn">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
require_once './reuse_file/footer.php';
?>

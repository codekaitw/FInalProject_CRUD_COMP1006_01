<?php
    // add values of variables of title and description
    $title = "Sign Up Page";
    $description = "Register page";

    require_once './reuse_file/header.php';
    require_once './reuse_file/Database.php';

    // signup form post
    if(isset($_POST['register']) && $_POST['register'] == 'Register'){
        if(!isset($db)) {
	        $db = new Database();
        }
        // account table: users
        $table_admins = 'users';

        // store info to variable
	    // encryption password
        $encryptPassword = hash('sha512', $_POST['signup_password']);
        $signUpData = array(
            'username' => $_POST['signup_username'],
            'password' => $encryptPassword,
            'email'    => $_POST['signup_email']
        );
        $confirmPassword = hash('sha512', $_POST['signup_confirmPassword']);

        // check input whether error
        $signupInputIsValid =  $db->inputErrorCheck_SignupUpdateData($signUpData, $confirmPassword);
        if(is_bool($signupInputIsValid) && $signupInputIsValid){
            // check username and email are unique in database
            $signupDataIsUnique = $db->checkSignupUpdateDataValid($table_admins, $signUpData);
            if(is_bool($signupDataIsUnique) && $signupDataIsUnique){
                // insert data
                $insert = $db->insertData($table_admins, $signUpData);
                $insert ? header("Location:index.php?insertMsg=Sign Up Successfully") :
                     header("Location:index.php?insertMsg=Not Sign Up Successfully");
            } elseif (is_string($signupDataIsUnique)){
                header("Location:signup.php?signupMsg=$signupDataIsUnique");
            }
        }elseif(is_string($signupInputIsValid)){
            header("Location:signup.php?signupMsg=$signupInputIsValid");
        }
    }
?>

<section class="signup-custom">
	<div class="container d-flex justify-content-center h-100">
		<div class="card" id="signup-custom-card">
			<div class="card-header text-center">
                <?php
                    if(isset($_GET['signupMsg'])){
	                    echo '<div class="alert alert-danger" role="alert">';
	                    echo $_GET['signupMsg'];
	                    echo '</div>';
                    }
                ?>
				<h3>Register</h3>
			</div>
			<div class="card-body">
				<form action="signup.php" method="post">
					<div class="input-group form-group mb-4">
						<input type="text" class="form-control" placeholder="username" name="signup_username">
					</div>
					<div class="input-group form-group mb-4">
						<input type="password" class="form-control" placeholder="password" name="signup_password">
					</div>
                    <div class="input-group form-group mb-4">
                        <input type="password" class="form-control" placeholder="confirm password" name="signup_confirmPassword">
                    </div>
                    <div class="input-group form-group mb-4">
                        <input type="email" class="form-control" placeholder="Email" name="signup_email">
                    </div>
					<div class="form-group text-center">
						<input type="submit" name="register" value="Register" class="btn float-right login_btn">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
	require_once './reuse_file/footer.php';
?>

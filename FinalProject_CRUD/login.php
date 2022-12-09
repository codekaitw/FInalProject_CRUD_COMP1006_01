<?php session_start();
    // access the existing session created automatically by the server
    // add values of variables of title and description
    $title = "Login page";
    $description = "Login page";

    require_once './reuse_file/header.php';
    require_once './reuse_file/Database.php';

    // check if already login
    if(isset($_SESSION['user_id'])){
        header("Location:personalPage.php?LoginMsg=You already logged in! Please log out first!");
    }
    // login form post
    if(isset($_POST['login']) && $_POST['login'] == 'Login'){
        if(!isset($db)){
            $db = new Database();
        }
	    // account table: users
	    $table_admins = 'users';

	    // store info to variable
	    $encryptPassword = hash('sha512', $_POST['login_password']);
	    $loginData = array(
            'login_username' => $_POST['login_username'],
            'login_password' => $encryptPassword
        );
        // validate login data
        $db->checkLoginDataValid($table_admins, $loginData);
    }

?>
    <section class="login-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" id="login-card">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <?php
                                    if(isset($_GET['checkErrorMsg'])){
                                        echo '<div class="alert alert-danger" role="alert">';
                                        echo $_GET['checkErrorMsg'];
                                        echo '</div>';
                                    }
                                ?>
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your username and password!</p>
                                <form action="login.php" method="post">
                                    <div class="form-outline form-white mb-5">
                                        <input type="text" class="form-control form-control-lg" placeholder="User Name" name="login_username"/>
                                    </div>

                                    <div class="form-outline form-white mb-5">
                                        <input type="password" class="form-control form-control-lg" placeholder="Password" name="login_password"/>
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login" value="Login">Login</button>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center links">
                                    Don't have an account?<a href="signup.php">Sign Up</a>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a href="#">Forgot your password?</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
	require_once './reuse_file/footer.php';
?>
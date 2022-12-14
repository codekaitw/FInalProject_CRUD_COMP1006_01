<?php session_start();
    // session is started if you don't write this line can't use $_Session  global variable
    // In this session, it will limit the amount of time users are allowed to view this page

    // add values of variables of title and description
    $title = "A base CRUD homepage";
    $description = "Final Project index page";

    require_once './reuse_file/header.php';
	require_once './reuse_file/Database.php';
?>
	<section id="home-start">
		<?php
		if(isset($_GET['LogoutMsg'])){
			echo '<div class="alert alert-info m-auto text-center" role="alert">';
			echo $_GET['LogoutMsg'];
			echo '</div>';
			// Finally, destroy the session.
			session_destroy();
		}
		if(isset($_GET['insertMsg'])){
			echo '<div class="alert alert-info m-auto text-center" role="alert">';
			echo $_GET['insertMsg'];
			echo '</div>';
		}

        if(isset($_GET['protectMsg'])){
	        echo '<div class="alert alert-info m-auto text-center" role="alert">';
	        echo $_GET['protectMsg'];
	        echo '</div>';
        }
		?>
		<div class="home-start-container mb-5">
			<h1>Welcome PHP Message Board</h1>
			<h2>We Are Here With You</h2>
			<a href="
                <?php
                    if(isset($_SESSION['user_id'])) echo "personalPage.php";
                    else echo "login.php";
                ?>
            " class="btn-get-started">Get Start</a>
		</div>
	</section>

<?php
    require_once './reuse_file/footer.php';
?>
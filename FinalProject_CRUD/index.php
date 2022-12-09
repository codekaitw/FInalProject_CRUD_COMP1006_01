<?php

    // session is started if you don't write this line can't use $_Session  global variable
    // In this session, it will limit the amount of time users are allowed to view this page
    session_start();
    // add values of variables of title and description
    $title = "A base profile homepage";
    $description = "Assignment 3 index page";

    require_once './reuse_file/header.php';
	require_once './reuse_file/Database.php';

?>

<main>
	<section id="home-start">
		<div class="home-start-container">
			<h1>Welcome</h1>
			<h2>We are xxx xxx xxx</h2>
			<a href="
                <?php
                    if(!isset($_SESSION['user_id'])) echo "login.php";
                    else echo "personalPage.php";
                ?>
            " class="btn-get-started">Get Start</a>
		</div>
	</section>
</main>

<?php
    require_once './reuse_file/footer.php';
?>
<?php
        require_once './reuse_file/ErrorHandle.php';
    // create an object of error handle class if an object doesn't exist
    if(!isset($errorObj)){
        $errorObj = new ErrorHandle();
        //
        $errorObj->fatalErrorHandle();

        $errorFunctionName = 'customErrorHandle';
        // set the custom function to handle error
        set_error_handler(array($errorObj, $errorFunctionName)
        );
    }
    $title='Default';
    $description='Default';
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?php
                // dynamic title
                echo $title;
            ?>
        </title>
        <meta name="description" content="
        <?php
            // dynamic description
            echo $description;
        ?>
        ">
        <meta name="robots" content="noindex, nofollow">
        <!-- add Google fonts -->

        <!-- add Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- add custom CSS -->
        <link rel="stylesheet" href="./css/style.css">
        <!-- add custom JS -->
        <script src="./js/custom.js"></script>
    </head>
    <body>
        <header class="fixed-top">
            <nav class="navbar navbar-expand-lg navbar-dark bg-success">
                <a class="navbar-brand" href="#">
                    <img class="p-1" src="./img/logo.png" width="70" height="50" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="personalPage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="all_Users.php">All User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">LogIn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?LogoutMsg=Log Out Successfully">LogOut</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutUs.php">AboutUs</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- For space in order to show content after fix header -->
        <div class="spacer"></div>
    <main>

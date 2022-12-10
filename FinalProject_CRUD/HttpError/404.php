<?php
$title = "Page Not Found";
$description = "This page handle 404 error which mean the page is not exist or is not found";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center row">
        <div class=" col-md-6">
            <img src="https://cdn.pixabay.com/photo/2017/03/09/12/31/error-2129569__340.jpg" alt=""
                 class="img-fluid">
        </div>
        <div class=" col-md-6 mt-5">
        <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
        <p class="lead">
            The page you’re looking for doesn’t exist.
        </p>
        <a href="../index.php" class="btn btn-primary">Go Home</a>
    </div>

</div>
</div>
</body>

</html>

<!--	<section>-->
<!--		<div>-->
<!--			<h1>Page Not Found</h1>-->
<!--		</div>-->
<!--	</section>-->
<!--	<section>-->
<!--		<h2>Click the navigation bar to return homepage or click the link below to return homepage</h2>-->
<!--		<a href="../index.php">Home</a>-->
<!--	</section>-->
<?php session_start();
    // session is started if you don't write this line can't use $_Session  global variable
    // In this session, it will limit the amount of time users are allowed to view this page

    // add values of variables of title and description
    $title = "A base profile homepage";
    $description = "Assignment 3 index page";

    require_once './reuse_file/header.php';
    require_once './reuse_file/Database.php';

    // check the user log in time isn't out of (session)time
    if(isset($_SESSION['user_id'])){
        if(!isset($db)){
            $db = new Database();
        }
    }else{
        header("Location:index.php?LogoutMsg=Time Out! Please Log In.");
    }

    // table name: users
    $tableName_users = 'users';

    // table name: messages
    $tableName_messages = 'messages';

    // insert: add new message
    if(isset($_POST['msg_text'])){
        $msgData = array(
            'message_text' => $_POST['msg_text'],
            'created'      => '',
            'uid'          => $_SESSION['user_id']
        );

        $insert = $db->insertData($tableName_messages, $msgData);
        $insert ? header("Location:personalPage.php?insertMsg=Insert Successfully") : header("Location:personalPage.php?insertMsg=Insert Failed");
    }

    // update: edit message
    if(isset($_POST['edit_msg_text']) && isset($_POST['edit_message_id'])){
        $edit_msgData = array(
            'message_text' => $_POST['edit_msg_text'],
            'modified'     => '',
            'message_id'   => $_POST['edit_message_id']
        );
        var_dump($edit_msgData);
        $whereSetId = 'message_id';
        $update = $db->updateData($tableName_messages, $edit_msgData, $whereSetId);
        var_dump($update);
	    $update ? header("Location:personalPage.php?editMsg=Edit Successfully") :
		    header("Location:personalPage.php?editMsg=Edit Failed");
    }

    // show Other Worlds Section base on different page(home or other user)
    if(isset($_GET['otherUserId'])){
        // Other user: where condition and using single to get rid of index
	    $condition_user_id_single = array('where' => array('user_id' => $_GET['otherUserId']), 'return_type' => 'single');

        // $_GET['otherUserId'] will get string, so need to covert to int()
	    $condition_messages_uid = array('where' => array('uid' => (int)$_GET['otherUserId']));
    } else {
	    // Home User: where condition and using single to get rid of index
	    $condition_user_id_single = array('where' => array('user_id' => $_SESSION['user_id']), 'return_type' => 'single');

	    $condition_messages_uid = array('where' => array('uid' => $_SESSION['user_id']));
    }

        // using single to get rid of index in order to use without foreach
	    $userInfo_single = $db->displayData($tableName_users, $condition_user_id_single);
        // all user data
	    $userInfo = $db->displayData($tableName_users);
        // all user message data
	    $userMsgInfo = $db->displayData($tableName_messages, $condition_messages_uid);

?>
<?php
    if(isset($_GET['LoginMsg'])){
	    echo '<div class="alert alert-info m-auto text-center" role="alert">';
	    echo $_GET['LoginMsg'];
	    echo '</div>';
    }elseif(isset($_GET['insertMsg'])){
	    echo '<div class="alert alert-info m-auto text-center" role="alert">';
	    echo $_GET['LoginMsg'];
	    echo '</div>';
    }elseif(isset($_GET['editMsg'])){
	    echo '<div class="alert alert-info m-auto text-center" role="alert">';
	    echo $_GET['editMsg'];
	    echo '</div>';
    }
?>
<section class="container">
	<h1><?php echo $userInfo_single['username'] . ' World'; ?></h1>
</section>
<!-- User Info and User Message -->
<section class="container">
    <div class="row">
        <!-- User Info section-->
        <section class="userInfoSection col-sm-8">
            <div class="row flex-nowrap">
                <div class="world-user-info card d-flex flex-row">
                    <div class="p-2">
                        <img class="rounded-circle" src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Default_pfp.svg" alt="img" width="40">
                    </div>
                    <div class="align-self-center flex-grow-1"><?php echo $userInfo_single['username']; ?></div>
                    <?php
                        // this content(Add New Msg) only will display on home page
                        if(!isset($_GET['otherUserId'])){
                    ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary align-self-center" data-toggle="modal" data-target="#AddMessageModal">
                        New Msg
                    </button>

                    <!-- Modal Add Message Pop up -->
                    <div class="modal fade" id="AddMessageModal" tabindex="-1" role="dialog" aria-labelledby="AddMessageModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Show Them Who You Are</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="personalPage.php" method="post" class="form-group" id="post_msg_form">
                                        <div class="form-group">
                                            <label for="msgTextArea">What do you think now</label><textarea class="form-control" id="msgTextArea" rows="3" placeholder="Add something new here..." name="msg_text"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit" value="postMsg" name="Submit" onclick="post_msg_text()">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php } ?>
                </div>
            </div>
            <!-- Message of user created section-->
            <section class="MessageSection">
                <div class="row">
                    <?php
                    // if user have message info($userMsgInfo) print out all message
                    if(isset($userMsgInfo) && !is_array($userMsgInfo)) {
                        echo '<div class="alert alert-info mt-2" role="alert">';
                        echo 'No Content!!! Add New One!';
                        echo '</div>';
                    } else {
                        // reverse in order to show msg from new to old
                        $reverseArray_userMsgInfo = array_reverse($userMsgInfo);
                        foreach ($reverseArray_userMsgInfo as $value){
                            ?>
                            <div class="card mt-3">
                                <div class="row card-header">
                                    <!-- Hidden message id -->
                                    <input type="hidden" name="message_id" value="<?php echo $value['message_id']; ?>">
                                    <div class="col-2 w-auto">
                                        <img class="rounded-circle" width="40" src="iii" alt="img">
                                    </div>
                                    <div class="col align-self-center">
                                        <?php echo $userInfo_single['username']; ?>
                                    </div>
                                    <div class="col align-self-center">
                                        Last Update:
                                        <?php
                                        if(isset($value['modified'])) echo $value['modified'];
                                        else echo $value['created'];
                                        ?>
                                    </div>
                                    <a class="nav-link dropdown-toggle align-self-center col-auto" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu w-auto" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" data-toggle="modal" data-target="#EditMessageModal">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                    <!-- Edit Message modal Pop Up-->
                                    <div class="modal fade" id="EditMessageModal" tabindex="-1" role="dialog" aria-labelledby="EditMessageModal" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Your Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="personalPage.php" method="post" class="form-group" id="edit_msg_form">
                                                        <!-- Hidden message id -->
                                                        <input type="hidden" name="edit_message_id" value="<?php echo $value['message_id']; ?>">
                                                        <div class="form-group">
                                                            <label for="edit_msgTextArea">What do you think now</label><textarea class="form-control" id="edit_msgTextArea" rows="3" name="edit_msg_text"><?php echo $value['message_text']; ?></textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" type="submit" value="editMsg" name="Submit" onclick="edit_msg_text()">Edit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row cord-body">
                                    <div class="col m-2">
                                        <p>
                                            <?php echo $value['message_text']; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Reply
                                    </button>
                                    <div class="collapse mt-3" id="collapseExample">
                                        <div class="card card-body">
                                            <form class="form-group">
                                                <div class="form-group">
                                                    <label for="replyTextArea">Any comment</label><textarea class="form-control" id="replyTextArea" rows="3" placeholder="Reply here..." name="reply_text"></textarea>
                                                </div>
                                            </form>
                                            <div class="card-footer">
                                                <div class="text-center">
                                                    <button class="btn btn-primary">
                                                        Reply
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } // end of foreach
                    } // end of if statement
                    ?>
                </div>
            </section>
        </section>
        <!-- Other worlds section-->
        <div class="otherWorldSection col-sm-4">
            <!-- the title of other user info section -->
            <div class="text-left">
                <h3>Other Worlds</h3>
            </div>
            <!-- other user info -->
            <aside class="container rounded border border-info p-2">
			    <?php
			    // no content show message (count > 2 >>> if only contain log in user and current page user)
			    if(!isset($userInfo) || count($userInfo) == 2
				    && isset($_GET['otherUserId'])){
				    echo '<div class="alert alert-info col-sm-8 m-auto" role="alert">';
				    echo 'No Other World Now!!!!';
				    echo '</div>';
			    } else {
				    // iterate through the users data except current user base on page
				    foreach ($userInfo as $value){
					    // show other worlds on other page(not home user page)
					    if(isset($_GET['otherUserId'])){
						    if($_GET['otherUserId'] == $value['user_id']) continue;
						    if ($_SESSION['user_id'] == $value['user_id']) continue;
					    } else{
						    // show other worlds on home user page
						    if ($_SESSION['user_id'] == $value['user_id']) continue;
					    }
					    // close php here in order to foreach(travel) these codes below
					    // Note: the start and close position will affect the CSS
					    ?>
                        <div class="container d-flex flex-column list-group">
                            <div class="container list-group-item">
                                <a class="d-flex flex-wrap" href="<?php echo "personalPage.php?otherUserId=" . $value['user_id'] ?>">
                                    <img class="rounded-circle" width="40
" src="iii" alt="img">
                                    <div class="p-2"><?php echo $value['username']; ?></div>
                                </a>
                            </div>
                        </div>
					    <?php
				    } // close foreach
			    } // close if statement
			    ?>
            </aside>
        </div>
    </div>
</section>
<?php
	require_once './reuse_file/footer.php';
?>

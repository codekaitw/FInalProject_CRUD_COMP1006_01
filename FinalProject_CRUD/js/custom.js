function post_msg_text(){
    // check whether empty, if yes submit
    if(document.getElementById('msgTextArea').value !== '') {
        document.getElementById('post_msg_form').submit();
    }
}

function edit_msg_text(){
    // check whether empty, if yes submit
    if(document.getElementById('edit_msgTextArea').value !== '') {
        document.getElementById('edit_msg_form').submit();
    }
}
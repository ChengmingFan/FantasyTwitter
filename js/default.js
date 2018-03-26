function signup() {
	var name = $('#name').val();
	var password = $('#password').val();
	dataVal = {
		username: name,
		userpassword: password
	};
	$.ajax({
		url: 'php/verifyNew.php',
		type: 'GET',
		data: dataVal,
		success: function(msg) {
			alert(msg);
		}
	});
};

function signin() {
	var name = $('#name').val();
	var password = $('#password').val();
    dataVal = {
        username: name,
        userpassword: password
    };
    $.ajax({
        url: 'php/verifyOld.php',
        type: 'GET',
        data: dataVal,
        success: function(msg) {
                    if(msg.status == 'ok') {
                          window.location = "php/homepage.php" + msg.message;
                        }else{
              alert(msg.message);
                        }
        }
    });
};

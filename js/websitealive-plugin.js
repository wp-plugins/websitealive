
	var wsa_username, wsa_server_url, wsa_objectref, wsa_groupid, wsa_websiteid;


	function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( !emailReg.test( email ) ) {
			return false;
		} else {
			return true;
		}
	}
	
	function validateText(text,minlength){
	
		var alNumRegex = /^([a-zA-Z0-9]+)$/; //only letters and numbers
		
		if(alNumRegex.test(text) && text.length >= minlength) {
			return true;
		}else{
			return false;
		}
	}
	
		
	function ajaxJqueryReturn(url,parameters,type,callback) {

			$.ajax({	url: url,
						data: parameters,
						type: type,
						//async: false,
						success: function (data) {
							
							callback(data);
							
						},
				
				  error: function (e) { 
					   callback('error in ajax call');
				  } 
			 }); 
			
			
		}
		
		
	$(document).ready(function () {		
		
				
				
	});
	
	
	
	function populateWebsiteid(){
		
		$.getJSON("https://api-v1.websitealive.com/org/", {  
					  
				tags: "jquery",
				tagmode: "any",
				format: "json",
				action: "getwebsites",
				objectref: $('#wsa_objectref').val(),
				groupid: $('#wsa_groupid').val()

			}, function (data) {
				
				$('#websiteid').empty();
				for (var i = 0; i < data.length; i++) {
								 
					$('#websiteid').append($("<option />").val(data[i].websiteid).text(data[i].title));
				}
				
			});

					
	}
	
	function validateLogin(){
		
		if ($('#user_name').val() == '' || $('#password').val() == ''){
			alert('Your username and password combination is incorrect.');
		}else{
			
			$.getJSON("https://api-v1.websitealive.com/auth/", {  
					  
				tags: "jquery",
				tagmode: "any",
				format: "json",
				action: "login_validate",
				user_name: $('#user_name').val(),
				password: $('#password').val()
				
			}, function (data) {
				
				if (data[0].is_admin == 'Y'){
					
					$('#wsa_objectref').val(data[0].objectref); 
					$('#wsa_groupid').val(data[0].groupid);
					$('#wsa_username').val($('#user_name').val());
					$('#span_user_name').html($('#user_name').val());
					
					//$('#div_wp_login').hide();
					//$('#div_wp_config').show();
					
					alert('Success! wsa_server_url=' + wsa_server_url + ',wsa_groupid=' + wsa_groupid); 
					
					$('#div_wp_login').hide();
					$('#div_wp_config').show();

					populateWebsiteid();
					
				}else{
					alert('Your username and password combination is incorrect.');
				}
			});
		}	
	}

	function register(){
		
		if (!(validateEmail($('#reg_emailadmin').val()) && $('#reg_emailadmin').val() != '' && validateText($('#reg_username').val(),6))){ 
			alert('Please enter a valid username and email.');
		}else{
		   
			$.getJSON('http://secure.websitealive.com/apps/signup/signup_api.asp?format=json&username=' + $('#reg_username').val() + '&emailadmin=' + $('#reg_emailadmin').val() + '&promocode=wordpress5&confirmemail=Y&version=pro2', {}, function (data) {
						
				if (data[0].responseType == 'error'){
					alert(data[0].errorMessage);
				}else{
					
					// alert(data[0].responseType);
					// alert(data[0].username);
					// alert(data[0].emailadmin);
					// alert(data[0].server_url);
					// alert(data[0].groupid);
					// alert(data[0].objectref);
					
					//var wsa_username, wsa_server_url, wsa_objectref, wsa_groupid, wsa_websiteid;

					$('#wsa_objectref').val(data[0].objectref); 
					$('#wsa_groupid').val(data[0].groupid);
					$('#wsa_username').val($('#reg_username').val());
					$('#span_user_name').html($('#reg_username').val());
					
					//send reg email here.


					$("#div_wp_register").hide();
					$("#div_wp_config").show();

					populateWebsiteid();
					
				}
				});
		}
	
		
	}
	
	function saveWebsite(){
		wsa_updateWP($('#wsa_username').val(),$('#wsa_groupid').val(), $('#wsa_objectref').val(), $('#websiteid').val());
	}
	function logOut(){
		wsa_updateWP("","","","");
	}
	

	function wsa_updateWP(wsa_username, wsa_groupid, wsa_objectref, wsa_websiteid){
		$('#wsa_username').val(wsa_username);
		$('#wsa_groupid').val(wsa_groupid);
		$('#wsa_objectref').val(wsa_objectref);
		$('#wsa_websiteid').val(wsa_websiteid);
		$('#dofollow').submit();
	}

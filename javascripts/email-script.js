$(document).ready(function(){

function IsEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
		$('form').on('click', '#formsubmit', function(event) {
			event.preventDefault();

			// validate array. If anything inside after check, form errors
			var invalid = [];

			// validate fields
			var el_name = $('form').find('input[name="name"]');
			var val_name = el_name.val();
			var valid_name = val_name.length;
				el_name.toggleClass('error', !valid_name);
				!valid_name && invalid.push(1);
				// console.log( val_name );

			var el_email = $('form').find('input[name="email"]');
			var val_email = el_email.val();
			var valid_email = val_email.length && IsEmail(val_email);
				el_email.toggleClass('error', !valid_email);
				!valid_email && invalid.push(1);
				// console.log( val_email );
			
			var el_phone = $('form').find('input[name="phone"]');
			var val_phone = el_email.val();
			var valid_phone = val_phone.length; // could use phone number validation
				el_phone.toggleClass('error', !valid_phone);
				!valid_phone && invalid.push(1);
				// console.log( val_email );


			// if any invalid, halt
			if (invalid.length) { 
				//<small class="error">Invalid entry</small> add this below the invalid input
				return; }


			// build object
			var formData = {};
				formData.email 			= $('input[name="email"]').val();
				formData.name 			= $('input[name="name"]').val();
				formData.phone 			= $('input[name="phone"]').val();
				formData.message 		= $('textarea[name="message"]').val();

			$.ajax({
				//url: '/mail.php',
				url: '../mail.php',
				type: 'POST',
				data: $.param(formData),
			})
			.done(function(e,b,c) {
				if (e === 'success') {
					// perform some sort of happy dance
					document.getElementById("form-holder").innerHTML = "";
					document.getElementById("form-holder").innerHTML = '<div class="thank-you">' + '<h2><span>&#xe604;</span>Thank you!</h2>' + '<p>We will get back to you shortly.</p>' + '</div>';
				} else {
					// cry in a corner
				}
			});
		});

});
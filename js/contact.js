// contact.js
$(document).ready(function() {

	// process the form 
	$('#contactform form').submit(function(event) {

		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

        
		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var formData = {
			'Name' 			        : $('input[name=inputName]').val(),
			'Email' 			    : $('input[name=inputEmail]').val(),
           	'Phone' 			    : $('input[name=inputPhone]').val(),
            'inputSubject' 			: $('input[name=inputSubject]').val(),
            'inputMessage' 			: $('textarea[name=inputMessage]').val()
		};
        
        console.log(formData);

		// process the form
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: 'contact.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
				console.log(data); 

				// here we will handle errors and validation messages
				if ( ! data.success) {
					
					// handle errors for name ---------------
					if (data.errors.name) {
						$('#cname-group').addClass('has-error'); // add the error class to show red input
						$('#cname-group label').append('<span class="help-block">' + data.errors.name + '</span>'); // add the actual error message under our input
					}

					// handle errors for email ---------------
					if (data.errors.email) {
						$('#cemail-group').addClass('has-error'); // add the error class to show red input
						$('#cemail-group label').append('<span class="help-block">' + data.errors.email + '</span>'); // add the actual error message under our input
					}
                    
                    // handle errors for phone ---------------
					if (data.errors.phone) {
						$('#cphone-group').addClass('has-error'); // add the error class to show red input
						$('#cphone-group label').append('<span class="help-block">' + data.errors.phone + '</span>'); // add the actual error message under our input
					}

				} else {

					// ALL GOOD! just show the success message!
					$('#contactform form').append('<div class="alert alert-success">' + data.message + '</div>');

					// usually after form submission, you'll want to redirect
					//window.location = '#bottom'; // redirect a user to another page

				}
			})

			// using the fail promise callback
			.fail(function(data) {

				// show any errors
				// best to remove for production
				console.log(data);
			});

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

});

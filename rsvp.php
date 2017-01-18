<?php

$send_to = '{assigned_user_email}';
$clientchoice = $_POST['selectAttending'];
$send_to_client = $_POST['inputEmail'];
$agentname = '{full_name_user}';
$agentphone = '{phone_work_user}';
$agentemail = '{assigned_user_email}';
$booklink = '{website}/booknow.html';

$errors         = array();  	// array to hold validation errors 
$data 			= array(); 		// array to pass back data

// validate the variables ======================================================
	// if any of these variables don't exist, add an error to our $errors array

	if (empty($_POST['inputName']))
		$errors['name'] = 'Name is required.';
	if (empty($_POST['inputEmail']))
		$errors['email'] = 'Email is required.';
   	if (empty($_POST['inputPhone']))
		$errors['phone'] = 'Phone Number is required.';

// return a response ===========================================================

	// if there are any errors in our errors array, return a success boolean of false
	if ( ! empty($errors)) {

		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {

		// if there are no errors process our form, then return a message

    	//If there is no errors, send the email to agent and client
    	if( empty($errors) ) {
            
            $title = htmlspecialchars_decode('{title}',ENT_QUOTES);    
			$subject = $title . ' RSVP form (Bride: {bride_first_name} - Groom: {groom_first_name})';
			$headers = 'From: ' . $send_to . "\r\n" .
			    'Reply-To: ' . $send_to . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

        	$message = 'Name: ' . $_POST['inputName'] . '
            
            Email: ' . $_POST['inputEmail'] . '
            Phone: ' . $_POST['inputPhone'] . '
            Guests: ' . $_POST['selectGuests'] . '
            Attending: ' . $_POST['selectAttending'];

        	$headers = 'From: RSVP Form' . '<' . $send_to . '>' . "\r\n" . 'Reply-To: ' . $_POST['inputEmail'];

        	mail($send_to, $subject, $message, $headers);

            
        //email to client
            $clientsubject = 'Re: {bride_first_name} & {groom_first_name}\'s Wedding';
            $clientheaders = 'From: ' . $send_to . "\r\n" .
                    'Reply-To: ' . $send_to . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            if( $clientchoice =="Yes" ) {
                    
            $clientmessage = 'Hi ' . $_POST['inputName'] .'!' ."\n\n". 'I received your RSVP for {bride_first_name} & {groom_first_name}\'s Wedding! My name is ' .$agentname. ' and I am the Travel Agent who will be handling arrangements for the wedding.'
        
            ."\n\n". 'In order to take advantage of the group discount, please submit a Rooming Form and Payment Form through their wedding website ' .$booklink. '. Please keep in mind that rates are subject to change until your deposit is received.'  
        
            ."\n\n". 'Do you need a customized quote? If so, what are your travel plans? Let me know, so I can get to work on that for you!'  

            ."\n\n\n". 'Thank you!'  
            ."\n\n". $agentname
            ."\n". $agentemail
            ."\n". $agentphone;
            }
            
            else {
                
            $clientmessage = 'Hi ' . $_POST['inputName'] .'!' ."\n\n". 'I received your response that you will not be attending {bride_first_name} & {groom_first_name}\'s Wedding. If your plans change, please feel free to contact me any time, and I would be happy to send you additional information.'

            ."\n\n\n". 'Thank you!'  
            ."\n\n". $agentname
            ."\n". $agentemail
            ."\n". $agentphone;
            }
            $clientheaders = 'From: ' . $agentname . '<' . $send_to . '>' . "\r\n" . 'Reply-To: ' . $send_to;
            mail($send_to_client, $clientsubject, $clientmessage, $clientheaders);       
           
            
            }

		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Thank you!';
	}

	// return all our data to an AJAX call
	echo json_encode($data);
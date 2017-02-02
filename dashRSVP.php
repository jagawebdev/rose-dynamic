<?php
    $clientphone = clean_number($_POST['inputPhone']);      
    if ($_POST['selectAttending'] == "Yes") {$status = "RSVP - YES";} 
    if ($_POST['selectAttending'] == "No") {$status = "RSVP - No";} 
    // get dashboard id
    $dashboard = '{has_dashboard}'; {
    $ch = curl_init('http://dfdash.com/api/UserInfo');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'api-key: H943N9xPnXI1AzPfZ0PT',
    "userid: {$leaderemail}",
    'Content-Type: application/json')                                                                       
    );                                                 
    $result = curl_exec($ch);
    $dashboardInfo = json_decode($result, true);
    if (is_array($dashboardInfo) || is_object($dashboardInfo)){
    $dashboardID = $dashboardInfo['data']['GuidUserId'];
   
    
    //get list of middle section records and check if any emails or phone numbers match, and if so update status for that id
    $ch = curl_init('http://dfdash.com/api/Dashboard/GetClientCSVData/'.$dashboardID);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'api-key: H943N9xPnXI1AzPfZ0PT',
    "userid: {$send_to}",
    'Content-Type: application/json')                                                                       
    );                                                 
    $result = curl_exec($ch);
    $RSVPSectionData = json_decode($result, true);
    if (is_array($RSVPSectionData) || is_object($RSVPSectionData)){
    $matched = false;   
    
    foreach ($RSVPSectionData as $record){                   
    $dashphone = clean_number($record['Phone']);
    if (($record['Email'] == $_POST['inputEmail']) || ($dashphone == $clientphone)) {
    $matched = true;          
    $update_status = 
    '
    {ClientCSVData:
    [
    {
            "Id":"'.$record['Id'].'",              
            "Status":"'.$status.'"
    } 
    ]
    }';      
    $ch = curl_init('http://dfdash.com/api/Dashboard/UpdateClientCSVRecord/'.$dashboardID);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $update_status);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'api-key: H943N9xPnXI1AzPfZ0PT',
    "userid: {$send_to}",
	'Content-Type: application/json',                                                                                
	'Content-Length: ' . strlen($update_status)) 
    );                                                 
    $result = curl_exec($ch);
    $updateresult = json_decode($result, true);      
    break;
    }        
    }
    
    // otherwise add new record     
    if ($matched !== true) {
    $record_data = '    
    {ClientCSVData:
    [
    {
            "Id":"",
            "FullName":"'.$_POST['inputName'].'",
            "Email":"'.$_POST['inputEmail'].'",               
            "Phone":"'.$_POST['inputPhone'].'",   
            "Status":"'.$status.'"
    } 
    ]
    }';    
    $ch = curl_init('http://dfdash.com/api/Dashboard/UpdateClientCSVRecord/'.$dashboardID);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $record_data);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'api-key: H943N9xPnXI1AzPfZ0PT',
    "userid: {$send_to}",
	'Content-Type: application/json',                                                                                
	'Content-Length: ' . strlen($record_data))                                                                       
    );                                                 
    $result = curl_exec($ch);
    }
    }
    }
    }
      

    function clean_number($phone)
    {
    $phone = preg_replace("/[^0-9]/","",$phone);
    $phone = trim($phone);
    if (!(is_numeric($phone))) { 
        // adding random number which will fail comparison
        $phone = "00000000000000";
    }
    if (strlen($phone) == 10) {  
        $phone = "1".$phone;    
    }
    return $phone;
    }
?>
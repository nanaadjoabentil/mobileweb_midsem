<?php
//DISPLAY PHP ERRORS
// error_reporting(0);
error_reporting(E_ALL); ini_set('display_errors', 1);

//INCLUDE APPLICATIONS SCRIPT
include 'ApplicationFunctions.php';

//DEFINE CURRENT DATE
date_default_timezone_set('GMT');
$time = date('Y-m-d H:i:s');
$ussd = new ApplicationFunctions();
$number = $_GET['number'];
$data = $_GET['body'];
$sessionID = $_GET['sessionID'];
$amount = "";
// $reply = "";
// $type = "";

//FUNCTION TO CHECK IF SESSION EXISTS AND THE SESSION COUNT
/*GET SESSION STATE OF THE USER*/
$sess = intval($ussd -> sessionManager($number));

//CREATING LOG
$write = $time . "|Request|" . $number . "|" . $sessionID . "|" . $data ."|".$sess. PHP_EOL;
// file_put_contents('ussd_access.log', $write, FILE_APPEND);

if ($sess == "0") {#NO SESSION WAS FOUND -> DISPLAY WELCOME MENU
    $ussd -> IdentifyUser($number);
    $reply = "Welcome to Insta-Money Transfer" . "\r\n" . "1.  Send Money" . "\r\n" ."2. Exit";
    $type = "1";
  }

else {
  switch($sess) {
        case 1 : #SESSION COUNT =1 #SERVICE LEVEL 1
          // if ($data=='1')
          // {
          //     // // $accountbalance = getAccountBalances($number);
          //     // // $reply = "You have GHS " . $accountbalance . "remaining in your account";
          //     // $reply = "You have x";
          //     // $type = "0";
          //     // $ussd -> deleteSession($number);
          // }
          if ($data=='1')
          {
                $reply = "Send Money" . "\r\n" ."1. To MTN" . "\r\n" ."2. To Vodafone" . "\r\n" ."3. To Airtel". "\r\n" ."4. To Tigo". "\r\n" ."5. Exit";
                $type = "1";
                $ussd -> UpdateTransactionType($number, "transaction_type", "STATEMENT");
              }
          elseif ($data=='2')
          {
              $reply = "Thank you for using Insta-Money transfer";
              $type = "0";
              $ussd -> deleteSession($number);
          }
          break;

    case 2: #SESSION COUNT =2 #SERVICE LEVEL 2
    //get recipient's number and save in a variable
      if( $data=='1')
      {
        $reply = "Enter recipient's number";
        $type = '1';
        $ussd ->UpdateTransactionType($number, "col3", "STATEMENT");
      }
      else if( $data=='2')
      {
        $reply = "Enter recipient's number";
        $type = '1';
        $ussd ->UpdateTransactionType($number, "col3", "STATEMENT");
      }
      else if( $data=='3')
      {
        $reply = "Enter recipient's number";
        $type = '1';
        $ussd ->UpdateTransactionType($number, "col3", "STATEMENT");
      }
      else if( $data=='4')
      {
        $reply = "Enter recipient's number";
        $type = '1';
        $ussd ->UpdateTransactionType($number, "col3", "STATEMENT");
      }
      else if( $data=='5')
      {
        $reply = "Thank you for using Insta-Money Transfer";
        $type = '0';
        $ussd ->deleteSession($number);
      }
      break;

  case 3: #SESSION COUNT 3 SERVICE LEVEL 3
  //get amount from user and save it in a variable
  if ($data=='1')
  {
    $reply = "Enter amount";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col4", "STATEMENT");
  }
  else if( $data=='2')
  {
    $reply = "Enter amount";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col4", "STATEMENT");
  }
  else if( $data=='3')
  {
    $reply = "Enter amount";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col4", "STATEMENT");
  }
  else if( $data=='4')
  {
    $reply = "Enter amount";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col4", "STATEMENT");
  }
  else if( $data=='5')
  {
    $reply = "Thank you for using Insta-Money Transfer";
    $type = '0';
    $ussd ->deleteSession($number);
  }
  break;

  case 4: #SESSION COUNT 4 = SERVICE LEVEL 4
  //CALL amount and number variables and concatenate them with the statement.
  if ($data=='1')
  {
    $reply = "Are you sure you wish to send to ?" . "\r\n" . "y or n ?";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col5", "STATEMENT");
  }
  else if( $data=='2')
  {
    $reply = "Are you sure you wish to send to ?" . "\r\n" . "y or n ?";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col5", "STATEMENT");
  }
  else if( $data=='3')
  {
    $reply = "Are you sure you wish to send to ?" . "\r\n" . "y or n ?";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col5", "STATEMENT");
  }
  else if( $data=='4')
  {
    $reply = "Are you sure you wish to send to ?" . "\r\n" . "y or n ?";
    $type = '1';
    $ussd ->UpdateTransactionType($number, "col5", "STATEMENT");
  }
  else if( $data=='5')
  {
    $reply = "Thank you for using Insta-Money Transfer";
    $type = '0';
    $ussd ->deleteSession($number);
  }
  break;

  //get answer from user - yes or no
  //if yes, continue. if no, exit
  case 5: #SESSION COUNT 5 SERVICE LEVEL 5
  //if yes:
  if ($data=='y')
  {
    $reply = " ";//send status message to both parties;
    $type = '0';
    $ussd->deleteSession($number);
}
  else if( $data=='n')
  {
    $reply = " ";//exit
    $type = '0';
    $ussd ->deleteSession($number);
  }
    break;
}
}

  $response = $number.'|'.$reply.'|'.$sessionID.'|'.$type;
  $write = $time . "|Request_reply|". $response . PHP_EOL;
  // file_put_contents('ussd_access.log', $write, FILE_APPEND);
  echo $response;

  ?>

confirm<?php
require 'database.php';
/**
*This class contains core logic of the USSD application
**/
class ApplicationFunctions {
   public function __construct(){
   }
   public function __destruct(){
   }
   public function IdentifyUser($number){
     $db = Database::getInstance();
     try {
      $stmt = $db->prepare("insert into sessionmanager(number) values (:number)");
      $stmt->bindParam(":number",$number);
      $stmt->execute();
        if($stmt->rowCount() > 0)
        {
           return TRUE;
        }
      }
    catch (PDOException $e) {
      #$e->getMessage();
      return FALSE;
   }
 }
 /**
 * Method to delete a user session
 *@param number
 *@return boolean
 **/
 public function deleteSession($number)
{
   $db = Database::getInstance();
   try {
   $stmt = $db->prepare("Delete FROM sessionmanager where number= :number");
   $stmt->bindParam(":number",$number);
   $stmt->execute();
   if($stmt->rowCount() > 0)
   {
      return TRUE;
   }
  }
  catch (PDOException $e)
    {
     #echo $e->getMessage();
     return FALSE;
   }
 }
 /**
  *Method to reset a users session to the first case. (Delete all of the users records except his number)
  *@param number
  *@return Boolean
**/
   public function deleteAllSession($number)
   {
      $db = Database::getInstance();
      try {
         $stmt = $db->prepare("UPDATE sessionmanager SET transaction_type = NULL where number= :number");
         $stmt->bindParam(":number",$number);
         $stmt->execute();
         if($stmt->rowCount() > 0)
         {
           return TRUE;
         }
       }
       catch (PDOException $e)
       {
         #echo $e->getMessage();
         return FALSE;
       }
     }
  /**
   * Method to update user session with the actual type of transaction or details of the transaction *currently being held
   *@param number, collumn, transaction type
   *@param Boolean
  **/
   public function UpdateTransactionType($number, $col, $trans_type)
   {
      $db = Database::getInstance();
      try
      {
         $stmt = $db->prepare("update sessionmanager set " .$col. " = :trans_type where number = :number");
         $params = array(":number"=>$number,":trans_type"=>$trans_type);
         $stmt->execute($params);
         if($stmt->rowCount() > 0)
         {
            return true;
         }
       }
      catch (PDOException $e)
      {
         #echo $e->getMessage();
         return FALSE;
      }
    }
    /**
    * Method to query specific details from the session manager. (Get value held in a specific column)
    *@param msisdn, specific column to query
    *@return string
   **/
      public function GetTransactionType($number, $col)
      {
         $db = Database::getInstance();
         try
         {
            $stmt = $db->prepare("SELECT " .$col. " FROM  sessionmanager WHERE  number = :number");
            $stmt->bindParam(":number",$number);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res !== FALSE)
            {
               return $res[$col];
            }
          }
         catch (PDOException $e)
         {
            #echo $e->getMessage();
            return NULL;
         }
      }
/**
  *Method to query users session state. checking if the user has an existing session and if so the session count.
  *@param msisdn, specific column to query
  *@return string
**/
  public function sessionManager($number)
    {
      $db = Database::getInstance();
      try
      {
        $stmt = $db->prepare("SELECT (COUNT(number)+ COUNT(transaction_type) +COUNT(network) + COUNT(recipientcol)+ COUNT(amountcol)+ COUNT(confirmcol)) AS counter FROM sessionmanager WHERE number = :number");
        $stmt->bindParam(":number",$number);
        $stmt->execute();
       $res = $stmt->fetch(PDO::FETCH_ASSOC);
       if($res !== FALSE)
       {
          return $res['counter'];
       }
     }
     catch (PDOException $e)
      {
       #echo $e->getMessage();
       return NULL;
     }
    }
  // /**
  // * Method for getting account balances
  // *@param number
  // *@return int
  // **/
  // public function getAccountBalances($number)
  // {
  //   $db = Database::getInstance();
  //   try {
  //     $stmt = $db->prepare("SELECT accountbalance FROM useraccount WHERE number = :number");
  //     $stmt->bindParam(":number, $number");
  //     $stmt->execute();
  //     $res = $stmt->fetch(PDO::FETCH_ASSOC);
  //     if($res !== FALSE)
  //     {
  //       return $res;
  //     }
  //   } catch (Exception $e) {
  //     return NULL;
  //   }
  // }
  public function transactions()
  {
    $db = Database::getInstance();
    try {
      //
    } catch (Exception $e) {
    }
  }

  /**
  * Method to send money through API
  **/
  public function sendMoney()
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      'CURLOPT_URL', "http://pay.npontu.com/api/pay",
      'CURLOPT_RETURNTRANSFER', 1,
      'CURLOPT_POST', 1,
      'CURLOPT_POSTFIELDS', array(
        "amt", "2",
        "number","0547787834",
        "uid","ashesi",
        "pass","ashesi",
        "tp","001",
        "trans_type","debit",
        "msg","test1",
        "vendor","MTN",
        "cbk","http://gmpay.npontu.com/api/tigo"
      )
    ));

    $response = curl_exec($curl);
    return $response;
    var_dump($response);

    curl_close($curl);

  }
}

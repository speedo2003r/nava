<?php

namespace App\Traits;

trait SmsTrait
{
  public function sendSms($phone, $msg, $package = '4jawaly')
  {
    # test mode - for live comment next line

    $data = [
      'username' => 'navaservices',
      'password' => 'ASD123asd',
      'sender'   => 'NAVA',
    ];

    switch ($package) {
      case 'our_sms':
        $this->send_sms_our_sms($phone, $msg, $data);
        break;
      case 'zain':
        $this->send_sms_zain($phone, $msg, $data);
        break;
      case '4jawaly':
        $this->send_4jawaly($phone, $msg, $data);
        break;
      case 'mobily':
        $this->send_sms_mobily($phone, $msg, $data);
        break;
      case 'yammah':
        $this->send_sms_yammah($phone, $msg, $data);
        break;
      case 'hisms':
        $this->send_sms_hisms($phone, $msg, $data);
        break;
      default:
        return false;
    }
  }

  private function send_sms_our_sms($phone, $msg, $data)
  {
    sleep(1);
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $text       = urlencode($msg);
    $to         = '+' . $phone;
    // auth call
    //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=full";
    //لارجاع القيمه json
    $url = "http://www.oursms.net/api/sendsms.php?username=$username&password=$password&numbers=$to&message=$text&sender=$sender&unicode=E&return=json";
    // لارجاع القيمه xml
    //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=xml";
    // لارجاع القيمه string
    //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E";

    // Call API and get return message
    //fopen($url,"r");
    //return $url;
    $ret = file_get_contents($url);
    //echo nl2br($ret);
  }

  private function send_sms_zain($phone, $msg, $data)
  {
    sleep(1);
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg . '   ');

    $link = "https://www.zain.im/index.php/api/sendsms/?user=$username&pass=$password&to=$to&message=$text&sender=$sender";

    /*
          *  return  para      can be     [ json , xml , text ]
          *  username  :  your username on safa-sms
          *  passwpord :  your password on safa-sms
          *  sender    :  your sender name
          *  numbers   :  list numbers delimited by ,     like    966530007039,966530007039,966530007039
          *  message   :  your message text
          */

    /*
          * 100   Success Number
          */

    if (function_exists('curl_init')) {
      $curl = @curl_init($link);
      @curl_setopt($curl, CURLOPT_HEADER, FALSE);
      @curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
      @curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      $source = @curl_exec($curl);
      @curl_close($curl);
      if ($source) {
        return $source;
      } else {
        return @file_get_contents($link);
      }
    } else {
      return @file_get_contents($link);
    }
  }

  private function send_4jawaly($phone, $msg, $data)
  {
//      sleep(1);
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg . '   ');

    $link = "www.4jawaly.net/api/sendsms.php";
    $stringToPost = "username=".$username."&password=".$password."&message=".$text."&numbers=".$to."&sender=".$sender."&unicode=E&return=full";

    /*
          *  return  para      can be     [ json , xml , text ]
          *  username  :  your username on safa-sms
          *  passwpord :  your password on safa-sms
          *  sender    :  your sender name
          *  numbers   :  list numbers delimited by ,     like    966530007039,966530007039,966530007039
          *  message   :  your message text
          */

    /*
          * 100   Success Number
          */
    if (function_exists('curl_init')) {
      $curl = @curl_init($link);
      @curl_setopt($curl, CURLOPT_URL, $link);
      @curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      @curl_setopt($curl, CURLOPT_ENCODING, "UTF-8");
      @curl_setopt($curl, CURLOPT_TIMEOUT, 5);
      @curl_setopt($curl, CURLOPT_POST, 1);
      @curl_setopt($curl, CURLOPT_POSTFIELDS, $stringToPost);
      $source = @curl_exec($curl);
      @curl_close($curl);
      if ($source) {
        return $source;
      } else {
        return @file_get_contents($link);
      }
    } else {
      return @file_get_contents($link);
    }
  }

  private function send_sms_mobily($phone, $msg, $data)
  {
    sleep(1);
    $url        = 'http://api.yamamah.com/SendSMS';
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg);
    $sender     = urlencode($sender);
    $fields   = array(
      "Username"        => $username,
      "Password"        => $password,
      "Tagname"         => $sender,
      "Message"         => $text,
      "RecepientNumber" => $to,
    );
    $fields_string = json_encode($fields);
    //open connection
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
      CURLOPT_POST => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
      CURLOPT_POSTFIELDS => $fields_string
    ));

    $result = curl_exec($ch);
    curl_close($ch);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  private function send_sms_yammah($phone, $msg, $data)
  {
    sleep(1);
    $url        = 'api.yamamah.com/SendSMS';
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg);
    $fields = array(
      "Username" => $username,
      "Password" => $password,
      "Message" => $text,
      "RecepientNumber" => $to, //'00966'.ltrim($numbers,'0'),
      "ReplacementList" => "",
      "SendDateTime" => "0",
      "EnableDR" => False,
      "Tagname" => $sender,
      "VariableList" => "0"
    );

    $fields_string = json_encode($fields);

    $ch = curl_init($url);
    curl_setopt_array($ch, array(
      CURLOPT_POST => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
      CURLOPT_POSTFIELDS => $fields_string
    ));
    $result = curl_exec($ch);
    curl_close($ch);
  }

  private function send_sms_hisms($phone, $msg, $data)
  {
    sleep(1);
    $url        = 'https://www.hisms.ws/api.php?send_sms&';
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg);
    $fields = [
      "username" => $username,
      "password" => $password,
      "numbers"  => $to,
      "sender"   => $sender,
      "message"  => $text,
    ];

    //open connection
    $ch = curl_init($url);
    curl_setopt_array(
      $ch,
      [
        CURLOPT_URL => $url . http_build_query($fields, null, '&'),
        CURLOPT_RETURNTRANSFER => true
      ]
    );

    $result = curl_exec($ch);
    curl_close($ch);
    // echo $result;
  }

  private function send_alfa_cell($phone, $msg)
  {

    $apiKey     = '';
    $sender     = '';
    $url        = 'https://www.alfa-cell.com/api/msgSend.php?apiKey=' . urlencode($apiKey) . '&numbers=' . urlencode($phone) . '&sender=' . urlencode($sender) . '&msg=' . urlencode($msg) . '&timeSend=0&dateSend=0&applicationType=68&domainName=aait.sa&msgId=15176';
    $json       = json_decode(file_get_contents($url), true);

    return $json;
  }
}

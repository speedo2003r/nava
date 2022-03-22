<?php
namespace App\Traits;

use App\Models\Address;
use App\Models\Item;

trait HyperpayTrait{
    public function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }
//    public function pre_checkout($price = null){
//        $item = Item::first();
//        $id = $item['id'];
//        $address = session()->get('address_id') ? Address::find(session()->get('address_id')) : '';
//        $currency = 'SAR';
////        dd($address['email'],auth()->user()['email'],$currency,$address['country_id'],$address['city_id'],$address['state_id'],$address['address'],$address['person_name']);
//        $url = "https://oppwa.com/v1/checkouts";
//        if($address != null){
//            $data = "entityId=8ac9a4cd73e6c4610174640d2e691707" .
//                "&amount=".$price .
//                "&merchantTransactionId=" .generate_code(8).$id.
//                "&currency=".$currency .
//                "&billing.country=".$address['country_id']. // SA
//                "&billing.city=".$address['city_id']. // al reyad
//                "&billing.street1=".$address['address']. // 35 st alryad etc
//                "&paymentType=DB";
//        }else{
//            $data = "entityId=8ac9a4cd73e6c4610174640d2e691707" .
//                "&amount=".$price .
//                "&merchantTransactionId=" .generate_code(8).$id.
//                "&currency=".$currency .
//                "&paymentType=DB";
//        }
//
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization:Bearer OGFjOWE0Y2Q3M2U2YzQ2MTAxNzQ2NDBjNTE3NTE3MDJ8TWZjOFBTWUZQNw=='));
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $responseData = curl_exec($ch);
//        if(curl_errno($ch)) {
//            return curl_error($ch);
//        }
//        curl_close($ch);
//        return json_decode($responseData);
//    }
//    public function payment_status($checkoutId = null){
//            $currency = 'SAR';
//            $url = "https://oppwa.com/v1/checkouts/".$checkoutId."/payment";
//            $url .= "?entityId=8ac9a4cd73e6c4610174640d2e691707";
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Authorization:Bearer OGFjOWE0Y2Q3M2U2YzQ2MTAxNzQ2NDBjNTE3NTE3MDJ8TWZjOFBTWUZQNw=='));
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $responseData = curl_exec($ch);
//            if(curl_errno($ch)) {
//                return curl_error($ch);
//            }
//            curl_close($ch);
//            return json_decode($responseData);
//    }
//    public function pre_checkoutMada($price = null){
//        $item = Item::first();
//        $id = $item['id'];
//        $address = Address::find(session()->get('address_id'));
//        $currency = 'SAR';
//        $url = "https://oppwa.com/v1/checkouts";
//        if($address != null) {
//            $data = "entityId=8ac9a4cd73e6c4610174640e1649170d" .
//                "&amount=" . $price .
//                "&merchantTransactionId=" . generate_code(8) . $id .
//                "&currency=" . $currency .
//                "&billing.country=" . $address['country_id'] . // SA
//                "&billing.city=" . $address['city_id'] . // al reyad
//                "&billing.street1=" . $address['address'] . // 35 st alryad etc
//                "&paymentType=DB";
//        }else{
//            $data = "entityId=8ac9a4cd73e6c4610174640e1649170d" .
//                "&amount=" . $price .
//                "&merchantTransactionId=" . generate_code(8) . $id .
//                "&currency=" . $currency .
//                "&paymentType=DB";
//        }
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization:Bearer OGFjOWE0Y2Q3M2U2YzQ2MTAxNzQ2NDBjNTE3NTE3MDJ8TWZjOFBTWUZQNw=='));
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $responseData = curl_exec($ch);
//        if(curl_errno($ch)) {
//            return curl_error($ch);
//        }
//        curl_close($ch);
//        return json_decode($responseData, true);
//    }
//    public function payment_statusMada($checkoutId = null){
//        $url = "https://oppwa.com/v1/checkouts/".$checkoutId."/payment";
//        $url .= "?entityId=8ac9a4cd73e6c4610174640e1649170d";
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization:Bearer OGFjOWE0Y2Q3M2U2YzQ2MTAxNzQ2NDBjNTE3NTE3MDJ8TWZjOFBTWUZQNw=='));
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $responseData = curl_exec($ch);
//        if(curl_errno($ch)) {
//            return curl_error($ch);
//        }
//        curl_close($ch);
//        return json_decode($responseData, true);
//    }
    public function pre_checkout($price = null){
        $currency = 'SAR';
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac7a4c77cb4f591017cb697f61103f5" .
            "&amount=".$price .
            "&testMode=EXTERNAL" . //test
            "&merchantTransactionId=" .generateCode(8).
            "&customer.email=info@aait.sa".
            "&currency=".$currency .
//            "&merchantTransactionId=".rand(99,999).$id.
//            "&customer.email=".$address['email']. //speedo@gmail.com
//            "&billing.country=".$address['country_id']. // SA
//            "&billing.city=".$address['city_id']. // al reyad
//            "&billing.state=".$address['state_id']. // alreyad
//            "&billing.street1=".$address['address']. // 35 st alryad etc
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc3Y2I0ZjU5MTAxN2NiNjhjZGNmNjAzZWJ8V3d6N3JzOTdadA=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
    public function payment_status($checkoutId = null){
        $url = "https://test.oppwa.com/v1/checkouts/".$checkoutId."/payment";
        $url .= "?entityId=8ac7a4c77cb4f591017cb697f61103f5";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc3Y2I0ZjU5MTAxN2NiNjhjZGNmNjAzZWJ8V3d6N3JzOTdadA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
    public function mada_pre_checkout($price = null){
        $currency = 'SAR';
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac7a4c77cb4f591017cb698841a03f9" .
            "&amount=".$price .
            "&testMode=EXTERNAL" . //test
            "&merchantTransactionId=" .generateCode(8).
            "&customer.email=info@aait.sa".
            "&currency=".$currency .
//            "&merchantTransactionId=".rand(99,999).$id.
//            "&customer.email=".$address['email']. //speedo@gmail.com
//            "&billing.country=".$address['country_id']. // SA
//            "&billing.city=".$address['city_id']. // al reyad
//            "&billing.state=".$address['state_id']. // alreyad
//            "&billing.street1=".$address['address']. // 35 st alryad etc
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc3Y2I0ZjU5MTAxN2NiNjhjZGNmNjAzZWJ8V3d6N3JzOTdadA=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
    public function mada_payment_status($checkoutId = null){
        $url = "https://test.oppwa.com/v1/checkouts/".$checkoutId."/payment";
        $url .= "?entityId=8ac7a4c77cb4f591017cb698841a03f9";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc3Y2I0ZjU5MTAxN2NiNjhjZGNmNjAzZWJ8V3d6N3JzOTdadA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}

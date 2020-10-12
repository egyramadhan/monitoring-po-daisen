<?php

namespace App\Libraries;

use Session;

class TransactionService
{
    private $url;
    private $email;
    private $password;

    public function __construct()
    {
        $this->url = config('erp.url');
        $this->email = config('erp.username');
        $this->password = config('erp.password');
    }

    public function methodlogin()
    {
        $url = $this->url . 'api/method/login?usr=' . $this->email . '&pwd=' . $this->password;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('usr' => $this->email, 'pwd' => $this->password));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error_no != 200) {
        }

        $body = json_decode($response, true);
        if (JSON_ERROR_NONE == json_last_error()) {
        }
        return [
            'error' => false,
            'message' => $body,
        ];
        // use $body
    }
    public function login()
    {
        $url = $this->url . 'api/method/login?usr=' . $this->email . '&pwd=' . $this->password;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('usr' => $this->email, 'pwd' => $this->password));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // common description bellow
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .   '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .   '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        // dd($response);
        $header = curl_getinfo($ch);
        // 200? 404? or something?
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error_no != 200) {
            // do something for login error
            // return or exit
            // dd($response);
        }
        $body = json_decode($response, true);
        if (JSON_ERROR_NONE == json_last_error()) {
            // $response is not valid (as JSON)
            // do something for login error
            // return or exit
        }
        // dd($body);
        return $response;
        // use $body
    }

    public function getProducts()
    {
        $a = static::login();
        $filters = json_encode(array(
            'fields' => '["item_name","item_code","name","standard_rate","stock_uom","item_group"]',
            'filters' => '[["Item","item_group","=","Products"]]'
        ));
        $dataFields = json_encode(["item_name", "item_code", "name", "standard_rate", "stock_uom", "item_group"]);
        $url = $this->url . 'api/resource/Item?';
        $dataFields = array('fields' => $dataFields);
        $dataLimits = array('limit_page_length' => '9999999');
        $q = http_build_query($dataFields);
        $q .= '&' . http_build_query($dataLimits);
        $ch = curl_init($url . $q);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);

        // dd($response);

        // 200? 404? or something?
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        // curl_close($ch);

        $body = json_decode($response, true);

        // return ['data' => $response];
        return $body;
    }

    public function getMaterialRequest()
    {
        static::login();
        $url = $this->url . 'api/resource/Material%20Request?fields=["supplier","schedule_date","name","material_request_type","company","request_by"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        // 200? 404? or something?
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $body = json_decode($response, true);
        // return ['data' => $response];
        return $body;
    }

    public function getMaterialRequestItems($name)
    {
        static::login();
        // $dataFields = json_encode(["item_group", "amount", "qty", "rate", "stock_uom", "item_name", "uom", "description"]);
        $url = $this->url . 'api/resource/Material%20Request/' . $name . '?fields=["parent","item_code","description","qty","uom"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);

        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode($response, true);
        return $body;
    }

    public function getPurchaseOders()
    {
        static::login();
        $url = $this->url . 'api/resource/Purchase%20Order?fields=["name","supplier","transaction_date","schedule_date","material_request"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $body = json_decode($response, true);
        return $body;
    }

    public function getPurchaseOrderItems($name)
    {
        static::login();
        $dataFields = json_encode(["item_group", "amount", "qty", "rate", "stock_uom", "item_name", "uom", "description"]);
        $url = $this->url . 'api/resource/Purchase%20Order/' . $name . '?fields=["item_code","qty","rate",item_name","uom","description"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode($response, true);
        return $body;
    }

    public function getMaterialReceives()
    {
        static::login();
        $url = $this->url . 'api/resource/Purchase%20Receipt?fields=["name","po_no","supplier","supplier_delivery_note","delivery_time","posting_date","posting_time"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $body = json_decode($response, true);
        return $body;
    }

    public function getMaterialReceiveItems($name)
    {
        static::login();
        $dataFields = json_encode(["item_group", "amount", "qty", "rate", "stock_uom", "item_name", "uom", "description"]);
        $url = $this->url . 'api/resource/Purchase%20Receipt/' . $name . '?fields=["purchase_order","item_code","qty","rate","uom","description"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode($response, true);
        return $body;
    }

    public static function getStockItem($username, $password, $name)
    {
        static::login($username, $password);
        $url = self::$url . 'resource/Stock%20Entry/' . $name . '?fields=["item_group","amount","qty","rate","stock_uom","item_name","uom","description","t_warehouse","s_warehouse"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);

        // dd($response);

        // 200? 404? or something?
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode($response, true);

        // dd($body);
        // return ['data' => $response];
        return $body;
    }

    public function login_sso($email, $password)
    {
        $url = $this->url . 'api/method/login?usr=' . $email . '&pwd=' . $password;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('usr' => $email, 'pwd' => $password));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error_no != 200) {
        }

        $body = json_decode($response, true);
        if (JSON_ERROR_NONE == json_last_error()) {
        }
        return [
            'error' => false,
            'message' => $body,
        ];
        // use $body
    }

    public function getItemPrice()
    {
        static::login();
        $url = $this->url . 'api/resource/Item%20Price?fields=["name"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $body = json_decode($response, true);
        return $body;
    }

    public function getItemPriceDetail($name)
    {
        static::login();
        // $dataFields = json_encode(["item_group", "amount", "qty", "rate", "stock_uom", "item_name", "uom", "description"]);
        $url = $this->url . 'api/resource/Item%20Price/' . $name . '?fields=["item_code","description","price_list_rate","currency","creation"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);

        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode($response, true);
        return $body;
    }

    public function getMaterialReturn()
    {
        static::login();
        $url = $this->url . 'api/resource/Purchase%20Receipt?fields=["name","po_no","is_return","supplier","supplier_delivery_note","delivery_time","posting_date","posting_time"]&filters=[["Purchase%20Receipt","is_return","=","1"]]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $body = json_decode($response, true);
        return $body;
    }

    public function getMaterialReturnItems($name)
    {
        static::login();
        $dataFields = json_encode(["item_group", "amount", "qty", "rate", "stock_uom", "item_name", "uom", "description"]);
        $url = $this->url . 'api/resource/Purchase%20Receipt/' . $name . '?fields=["purchase_order","item_code","qty","rate","uom","description"]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $body = json_decode($response, true);
        return $body;
    }

    public function statusClose()
    {
        static::login();
        $url = $this->url . 'api/resource/Purchase%20Order?fields=["name","supplier","transaction_date","schedule_date","material_request"]&filters=[["Purchase%20Order","status","=","Closed"]]&limit_page_length=9999999999999999';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) .  '(cookie cracker yummy)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, (120));
        $response = curl_exec($ch);
        $header = curl_getinfo($ch);
        $error_no = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $body = json_decode($response, true);
        return $body;
    }
}

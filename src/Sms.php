<?php

namespace MilanSahana\MmSms;

class Sms
{
    /**
     * @var string
     */
    private $authKey;
    private $result;

    public function __construct($authKey)
    {
        $this->authKey = $authKey;
    }

    /**
     * @return string|string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string|string $authKey
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;
    }


    public function send($to, $message, $dlt_te_id, $extras = null)
    {
        $result = [];
        //Multiple mobiles numbers separated by comma
        $mobileNumber = trim($to);
        $message = urlencode($message);


        $postData = array(
            'authkey' => $this->authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'DLT_TE_ID' => $dlt_te_id,
            'response' => 'json'
        );

        if(isset($extras['flash']) && (string)$extras['flash'] === '1') {
            $postData['flash'] = 1;
        }

        if(isset($extras['unicode']) && (string)$extras['unicode'] === '1') {
            $postData['unicode'] = 1;
        }

        if(isset($extras['schtime']) && $extras['schtime']) {
            $postData['schtime'] = $extras['schtime'];
        }

        //API URL
        $url = "http://sms1.mailmantra.com/v2/api/send_sms";


        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData)
            //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch)) {
            // echo 'error:' . curl_error($ch);
            $result['status'] = 0;
            $result['message'] = 'Internal Error'; // 'Curl Error..';
            $result['code'] = 'S005';
        }
        else {

            curl_close($ch);

            // {"message":"376466724f44313832333830","type":"success"}
            // {"message":"Authentication failure","type":"error"}
            $output_arr = json_decode($output, true);


            if($output_arr['status'] == 'success' || $output_arr['status'] == '1') {


                $result['status'] = 1;
                $result['message'] = 'SMS send Successfully..';
                $result['code'] = $output_arr['message'];
                //$result['output_arr']=$output_arr;

            }
            else {
                $result['status'] = 0;
                $result['message'] = $output_arr['message'];
                $result['code'] = 'S002';
                //$result['output_arr']=$output_arr;
            }

        }

        $this->result = $result;

        return $this->result;
    }

    public function sendBulk($to, $messages)
    {
        return true;
    }

    public function balance()
    {
        $result = [];
        try {
            $postData = array(
                'authkey' => $this->authKey,
                'response' => 'json',
            );

            //API URL
            $url = "http://sms1.mailmantra.com/v2/api/balance";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


            //get response
            $output = curl_exec($ch); // '{ "type": "success", "message": "abc" }';

            //Print error if any
            if(curl_errno($ch)) {
                // echo 'error:' . curl_error($ch);
                $result['status'] = 0;
                $result['message'] = 'Internal Error'; // 'Curl Error..';
                $result['code'] = 'S005';
                return $result;
            }
            else {
                curl_close($ch);
                $result = json_decode($output, true);
            }
        }
        catch(\Exception $exception) {
            $result['status'] = 0;
            $result['message'] = $exception->getMessage();
        }

        $this->result = $result;

        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }


}
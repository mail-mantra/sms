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


    public function send($to, $message)
    {
        return true;
    }

    public function sendBulk($to, $messages) {
        return true;
    }

    public function balance() {
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
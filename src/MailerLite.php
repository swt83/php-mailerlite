<?php

namespace Travis;

class MailerLite
{
    /**
     * Make an API request.
     *
     * @param   string  $endpoint
     * @param   string  $key
     * @param   string  $type
     * @param   string  $method
     * @param   array   $arguments
     * @param   int     $timeout
     * @return  array
     */
    public static function run($apikey, $type, $method, $arguments = [], $timeout = 30)
    {
        // set endpoint
        $url = 'https://api.mailerlite.com/api/v2/'.$method.'?'.http_build_query($arguments);

        // set headers
        $headers = [
            'X-MailerLite-ApiKey: '.$apikey,
            'Content-Type: application/json',
        ];

        // make curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        if (in_array(strtoupper($type), ['GET', 'POST', 'PUT', 'DELETE']))
        {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arguments));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($type));
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // catch errors...
        if (curl_errno($ch))
        {
            #$errors = curl_error($ch);

            throw new \Exception('Unknown error.');
        }

        // else if NO errors...
        else
        {
            // decode
            $result = json_decode($response);
        }

        // close
        curl_close($ch);

        // catch error...
        if (!$result) throw new \Exception('Invalid reponse.');

        // catch error...
        if ($httpcode >= 400)
        {
            throw new \Exception(ex($result, 'error.message'));
        }

        // return
        return $result;
    }
}
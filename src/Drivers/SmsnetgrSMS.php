<?php

namespace KaramanisWeb\SimpleSMSGreek\Drivers;

use GuzzleHttp\Client;
use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\MakesRequests;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

class SmsnetgrSMS extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive, MakesRequests;

    protected $client;
    protected $username;
    protected $api_password;
    protected $api_token;
    protected $unicode;

    protected $apiBase = 'https://sms.net.gr/index.php/api/do';

    public function __construct(Client $client, $username, $apiPassword, $api_token, $unicode)
    {
        $this->client = $client;
        $this->username = $username;
        $this->api_password = $apiPassword;
        $this->api_token = $api_token;
        $this->unicode = $unicode;
    }

    public function send(OutgoingMessage $message)
    {
        $composeMessage = $message->composeMessage();

        $numbers = implode(',', $message->getTo());
        $numbers = str_replace('+','',$numbers);

        $data = [
            'username' => urlencode($this->username),
            'api_password' => urlencode($this->password),
            'api_token' => urlencode($message->getFrom()),
            'from' => urlencode($message->getFrom()),
            (count($message->getTo()) > 1) ?  'bulklist' : 'to' => urlencode($numbers),
            'is_long' => urlencode((mb_strlen($composeMessage, 'utf8') > 160) ? 1 : 0),
            'message' => urlencode($composeMessage),
            'coding' => urlencode(($this->unicode == true) ? '1' : '0'),
        ];

        $this->buildCall('');
        $this->buildBody($data);

        $response = $this->getRequest();
        $responseBody = $response->getBody();

        if ($this->hasError($responseBody)) {
            $this->handleError($responseBody);
        }
        return $response;
    }

    protected function hasError($body)
    {
        if (str_is('Error:*', $body)){
            return $body;
        }
        return false;
    }

    protected function handleError($body)
    {
        $error = 'An error occurred. Status code: '.$body. ' - ';

        switch ($body) {
            case 'Error: 1101':
                $error .= 'Wrong username.';
                break;
            case 'Error: 1102':
                $error .= 'Wrong api password.';
                break;
            case 'Error: 1103':
                $error .= 'Wrong api token';
                break;
            case 'Error: 1104':
                $error .= 'A request from this ip address has been denied.';
                break;
            case 'Error: 1201':
                $error .= 'You did not specified a phone number.';
                break;
            case 'Error: 1202':
                $error .= 'You did not specified a message text';
                break;
            case 'Error: 1203':
                $error .= 'You have to specify either variable `to` or `bulklist` not both of them';
                break;
        }
        $this->throwNotSentException($error);
    }

}
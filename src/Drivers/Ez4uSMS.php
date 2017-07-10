<?php

namespace KaramanisWeb\SimpleSMSGreek\Drivers;

use GuzzleHttp\Client;
use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\MakesRequests;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

class Ez4uSMS extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive, MakesRequests;

    protected $client;
    protected $username;
    protected $password;
    protected $unicode;

    protected $apiBase = 'http://ez4usms.com/api/http/';

    public function __construct(Client $client, $username, $password, $unicode)
    {
        $this->client = $client;
        $this->username = $username;
        $this->password = $password;
        $this->unicode = $unicode;
    }

    public function send(OutgoingMessage $message)
    {
        $composeMessage = $message->composeMessage();

        $numbers = implode(',', $message->getTo());
        $numbers = str_replace('+','',$numbers);

        $data = [
            'username' => urlencode($this->username),
            'password' => urlencode($this->password),
            'from' => urlencode($message->getFrom()),
            'to' => urlencode($numbers),
            'message' => urlencode($composeMessage),
            'coding' => urlencode($this->unicode ? 'UTF-8' : 'GSM'),
        ];

        $this->buildCall('send.php');
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
        $error = 'An error occurred. Status code: '.$body;
        $this->throwNotSentException($error);
    }

}
<?php

namespace App\Models;

use GuzzleHttp\Client as HttpClient;

class FirebaseClient
{
    const PRIORITY_NORMAL = 'normal';

    private $httpClient;

    private $title;

    private $body;

    private $clickAction;

    private $channelId;

    private $image;

    private $icon;

    private $additionalData;

    private $priority = self::PRIORITY_NORMAL;

    private $fromArray;

    private $fromRaw;

    const API_URI = 'https://fcm.googleapis.com/fcm/send';

    /**
     * FirebaseClient constructor.
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function withTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function withBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function withClickAction($clickAction)
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    public function withImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function withIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function withPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function withAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function fromArray($fromArray)
    {
        $this->fromArray = $fromArray;

        return $this;
    }

    public function fromRaw($fromRaw)
    {
        $this->fromRaw = $fromRaw;

        return $this;
    }

    public function sendNotification($tokens)
    {
        $fields = array(
            'registration_ids' => $this->validateToken($tokens),
            'notification' => ($this->fromArray) ? $this->fromArray : [
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image,
                'icon' => $this->icon,
                'click_action' => $this->clickAction,
                'channelId' => $this->channelId,
            ],
            'data' => $this->additionalData,
            'priority' => $this->priority
        );
        return $this->callApi($fields);
    }

    public function sendMessage($tokens)
    {
        $data = ($this->fromArray) ? $this->fromArray : [
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'icon' => $this->icon
        ];

        $data = $this->additionalData ? array_merge($data, $this->additionalData) : $data;

        $fields = array(
            'registration_ids' => $this->validateToken($tokens),
            'data' => $data,
            'priority' => $this->priority
        );
        return $this->callApi($fields);
    }

    public function send()
    {
        return $this->callApi($this->fromRaw);
    }

    private function callApi($fields)
    {
        if (null == $this->httpClient) {
            throw new \DomainException('Http client must be set');
        }

        $url = self::API_URI;

        $parameters['headers'] = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'key=' . config('firebase.firebase_token'),
        ];

        $parameters['body'] = json_encode($fields);

        $response = $this->httpClient->request('POST', $url ,$parameters);

        return json_decode($response->getBody(),true);
    }

    private function validateToken($tokens)
    {
        if (is_array($tokens)) {
            return $tokens;
        }

        if (is_string($tokens)) {
            return explode(',', $tokens);
        }

        throw new \DomainException('Please pass tokens as array [token1, token2] or as string (use comma as separator if multiple passed).');
    }

    /**
     * @param mixed $channelId
     */
    public function withChannelId($channelId)
    {
        $this->channelId = $channelId;

        return $this;
    }
}

<?php

namespace Affise\Tracking;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PostbackSender
{
    private Client $client;
    protected string $domain;
    protected bool $ssl = true;

    public function __construct(string $domain, bool $ssl = true)
    {
        $this->client = new Client();
        $this->domain = $domain;
        $this->ssl = $ssl;
    }

    /**
     * @param array $options
     * @return bool
     * @throws GuzzleException
     * @throws PostbackInvalidClickIDException
     * @throws PostbackInvalidDomainException
     */
    public function send(array $options = []): bool
    {
        return $this->sendPostback(new Postback($this->domain, $this->ssl, $options));
    }

    /**
     * @param Postback $p
     * @return bool
     * @throws GuzzleException
     * @throws PostbackInvalidClickIDException
     */
    public function sendPostback(Postback $p): bool
    {
        $url = $p->url();
        $resp = $this->client->get($url);
        return $resp->getStatusCode() === 200;
    }
}
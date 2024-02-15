<?php

namespace Affise\Tracking;

class Postback
{
    public const CUSTOM_FIELDS_COUNT = 15;
    protected string $domain = "";
    protected bool $ssl = true;
    protected ?string $clickID = null;
    protected ?string $actionID = null;
    protected ?string $goal = null;
    protected ?float $sum = null;
    protected ?string $IP = null;
    protected ?PostbackStatus $status = null;
    protected ?string $referrer = null;
    protected ?string $comment = null;
    protected ?string $secure = null;
    protected ?string $fbClID = null;
    protected ?string $deviceType = null;
    protected ?string $userID = null;
    /**
     * @var array<string>
     */
    protected ?array $customFields = [];

    protected array $propertyMap = [
        "clickID" => "click_id",
        "actionID" => "action_id",
        "goal" => "goal",
        "sum" => "sum",
        "IP" => "ip",
        "status" => "status",
        "referrer" => "referrer",
        "comment" => "comment",
        "secure" => "secure",
        "fbClID" => "fbclid",
        "deviceType" => "device_type",
        "userID" => "user_id",
        "customFields" => "custom_field",
    ];

    /**
     * @param string $domain
     * @param bool $ssl
     * @param array $options
     * @throws PostbackInvalidDomainException
     */
    public function __construct(string $domain, bool $ssl = true, array $options = [])
    {
        if ($domain === "") {
            throw new PostbackInvalidDomainException();
        }

        $this->domain = $domain;
        $this->ssl = $ssl;

        foreach ($options as $key => $value) {
            if (in_array($key, ["domain", "ssl"])) {
                continue;
            }

            if ($key === "customFields") {
                for ($i = 1; $i <= self::CUSTOM_FIELDS_COUNT; $i++) {
                    if (isset($value[$i])) {
                        $this->customFields[$i] = $value[$i];
                    }
                }
            }

            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return string
     * @throws PostbackInvalidClickIDException
     */
    public function url(): string
    {
        if ($this->clickID === "" || !preg_match('/[0-9a-f]{24}/i', $this->clickID)) {
            throw new PostbackInvalidClickIDException();
        }

        $url = "http" . ($this->ssl ? "s" : "") . "://" . $this->domain . "/postback?";
        $query = [];

        foreach ($this->propertyMap as $key => $param) {
            $query = array_merge($query, $this->mapProperty($key));
        }

        return $url . http_build_query($query);
    }

    protected function mapProperty(string $key): array
    {
        $param = $this->propertyMap[$key] ?? $key;
        $query = [];

        switch ($key) {
            case "status":
                if (is_null($this->status)) {
                    $query[$param] = $this->status->value();
                }
                break;
            case "customFields":
                foreach ($this->customFields as $i => $value) {
                    if (!is_null($value)) {
                        $query[$param . $i] = $value;
                    }
                }
                break;
            default:
                if (!is_null($this->$key)) {
                    $query[$param] = $this->$key;
                }
                break;
        }

        return $query;
    }
}
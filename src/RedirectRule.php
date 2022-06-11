<?php


namespace alexKish\redirectManager;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;

class RedirectRule extends BaseObject implements RedirectRuleInterface
{
    const REDIRECT_STATUS_CODE_MOVED_PERMANENTLY = 301;
    const REDIRECT_STATUS_CODE_MOVED_TEMPORARILY = 302;

    /**
     * Redirect from
     * @var string
     */
    public string $from;

    /**
     * Redirect to
     * @var string
     */
    public string $to;

    /**
     * HTTP status code
     * @var int
     */
    public int $statusCode = self::REDIRECT_STATUS_CODE_MOVED_TEMPORARILY;

    /**
     * Initializes this rule.
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->from === null) {
            throw new InvalidConfigException('RedirectRule::redirectFrom must be set.');
        }
        if ($this->to === null) {
            throw new InvalidConfigException('RedirectRule::redirectTo must be set.');
        }
    }

    /**
     * Checking for compliance with a given url
     * @param string $pathUrl
     * @return bool
     */
    public function compareAddresses(string $pathUrl): bool
    {
        return $this->from === $pathUrl;
    }
}
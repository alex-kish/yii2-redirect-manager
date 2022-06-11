<?php

namespace alexKish\redirectManager;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\ExitException;
use yii\base\InvalidConfigException;

class RedirectManager extends Component implements BootstrapInterface
{

    /**
     * @var array
     */
    public array $rules = [];

    /**
     * @var array the default configuration of Redirect rules. Individual rule configurations
     * specified via [[rules]] will take precedence when the same property of the rule is configured.
     */
    public array $ruleConfig = ['class' => RedirectRule::class];

    /**
     * Initializes RedirectManager.
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!empty($this->rules)) {
            $this->rules = $this->buildRules($this->rules);
        }
    }

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
            if (!Yii::$app->request->isConsoleRequest) {
                $pathUrl = '/' . Yii::$app->request->pathInfo;

                foreach ($this->rules as $rule) {
                    if ($rule->compareAddresses($pathUrl)) {
                        $this->redirect($rule);
                    }
                }
            }
        });
    }

    /**
     * Builds redirect rule objects from the given rule declarations.
     *
     * @param array $ruleDeclarations the rule declarations. Each array element represents a single rule declaration.
     * Please refer to [[rules]] for the acceptable rule formats.
     * @return RedirectRuleInterface[] the rule objects built from the given rule declarations
     * @throws InvalidConfigException if a rule declaration is invalid
     */
    protected function buildRules(array $ruleDeclarations): array
    {
        $builtRules = [];

        foreach ($ruleDeclarations as $key => $rule) {
            if (is_string($rule)) {
                $rule = [
                    'from' => $key,
                    'to' => $rule,
                ];
            }
            if (is_array($rule)) {
                $rule = Yii::createObject(array_merge($this->ruleConfig, $rule));
            }
            if (!$rule instanceof RedirectRuleInterface) {
                throw new InvalidConfigException('Redirect rule class must implement RedirectRuleInterface.');
            }

            $builtRules[] = $rule;
        }

        return $builtRules;
    }

    /**
     * Redirect by UrlRule
     * @throws ExitException
     */
    public function redirect(RedirectRuleInterface $rule)
    {
        Yii::$app->getResponse()->redirect($rule->to, $rule->statusCode);
        Yii::$app->end($rule->statusCode);
    }
}
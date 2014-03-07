<?php

namespace Oro\Bundle\EntityExtendBundle\Migration;

use Psr\Log\AbstractLogger;

class UpdateExtendConfigMigrationArrayLogger extends AbstractLogger
{
    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        $this->messages[] = $message;

        if (isset($context['configs'])) {
            $this->logConfigs($context['configs']);
        }

        // based on PSR-3 recommendations if an Exception object is passed in the context data,
        // it MUST be in the 'exception' key.
        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $this->messages[] = (string)$context['exception'];
        }
    }

    /**
     * @param array  $configs
     * @param string $indent
     */
    protected function logConfigs($configs, $indent = '  ')
    {
        if (!empty($configs)) {
            foreach ($configs as $key => $val) {
                if (is_array($val)) {
                    $this->messages[] = sprintf('%s"%s"', $indent, $key);
                    $this->logConfigs($val, $indent . '  ');
                } else {
                    $this->messages[] = sprintf('%s"%s" = %s', $indent, $key, $this->convertToStr($val));
                }
            }
        }
    }

    /**
     * @param mixed $val
     * @return string
     */
    protected function convertToStr($val)
    {
        if (null === $val) {
            return 'null';
        }
        if (is_string($val)) {
            return sprintf('"%s"', $val);
        }
        if (is_bool($val)) {
            return $val ? 'true' : 'false';
        }

        return (string)$val;
    }
}

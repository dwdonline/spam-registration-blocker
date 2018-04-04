<?php

namespace SamSteele\SpamBlocker\Plugin;

class CreatePlugin
{
    protected $_creationTimer;
    protected $_configHelper;

    public function __construct(
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer,
        \SamSteele\SpamBlocker\Helper\Config $configHelper
    ) {
        $this->_creationTimer = $creationTimer;
        $this->_configHelper = $configHelper;
    }

    /**
     * @param \Magento\Customer\Controller\Account\Create $subject
     * @param mixed $result
     * @return mixed
     */
    public function afterExecute(\Magento\Customer\Controller\Account\Create $subject, $result)
    {
        if ($this->_configHelper->isRegistrationTimerEnabled()) {
            $this->_creationTimer->setStartTime();
        }

        return $result;
    }
}

<?php

namespace SamSteele\SpamBlocker\Plugin;

class AccountManagementPlugin
{
    protected $_spamBlocker;

    public function __construct(
        \SamSteele\SpamBlocker\Api\SpamBlockerInterface $spamBlocker
    ) {
        $this->_spamBlocker = $spamBlocker;
    }

    /**
     * @param \Magento\Customer\Model\AccountManagement $subject
     * @param callable $proceed
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param null $password
     * @param string $redirectUrl
     * @return mixed
     */
    public function aroundCreateAccount(
        \Magento\Customer\Model\AccountManagement $subject,
        callable $proceed,
        \Magento\Customer\Api\Data\CustomerInterface $customer,
        $password = null,
        $redirectUrl = ''
    ) {
    
        if (!$this->_spamBlocker->validate()) {
            $this->_spamBlocker->blockRegistration();
        }

        return $proceed($customer, $password, $redirectUrl);
    }

}

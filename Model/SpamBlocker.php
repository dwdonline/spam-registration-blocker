<?php

namespace SamSteele\SpamBlocker\Model;

use \Magento\Framework\Model\AbstractModel;
use SamSteele\SpamBlocker\Api\SpamBlockerInterface;

class SpamBlocker extends AbstractModel implements SpamBlockerInterface
{
    protected $_logger;
    protected $_messageManager;
    protected $_request;
    protected $_configHelper;
    protected $_creationTimer;
    protected $_honeypot;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Request\Http $request,
        \SamSteele\SpamBlocker\Helper\Config $configHelper,
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer,
        \SamSteele\SpamBlocker\Api\HoneypotInterface $honeypot,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->_logger = $logger;
        $this->_messageManager = $messageManager;
        $this->_request = $request;
        $this->_configHelper = $configHelper;
        $this->_creationTimer = $creationTimer;
        $this->_honeypot = $honeypot;
    }

    /**
     * @return null
     */
    public function validate()
    {
        return $this->validateCreationTime() && $this->validateHoneyPot();
    }

    /**
     * @return boolean
     */
    public function validateCreationTime()
    {

        // @TODO: Check if feature enabled

        $minRegistrationTime = $this->_configHelper->getMinRegistrationTime();

        return $this->_registrationTimer()->getAccountCreationTime() > $minRegistrationTime;
    }

    /**
     * @return boolean
     */
    public function validateHoneypot()
    {
        return !$honeypot->check($this->_configHelper->getHoneyPotFieldName());
    }

    /**
     * @return null
     */
    public function blockRegistration()
    {
        // @TODO: Get params nicer and delegate logging
        $this->_logger->info(implode(', ', (array_slice($this->_request->getParams(), 3, 6))));

        // Return to homepage with error message
        $this->_messageManager->addError($this->_helper->getBlockMessage());
        header('Location: ' . '/');
        exit();
    }

}
<?php

namespace SamSteele\SpamBlocker\Model\SpamBlocker;

use \Magento\Framework\Model\AbstractModel;
use SamSteele\SpamBlocker\Api\CreationTimerInterface;

class CreationTimer extends AbstractModel implements CreationTimerInterface
{
    protected $_helper;
    protected $_dateTime;
    protected $_customerSession;

    public function __construct(
        \SamSteele\SpamBlocker\Helper\Config $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_helper = $helper;
        $this->_dateTime = $dateTime;
        $this->_customerSession = $customerSession;
    }

    /**
     * @return void
     */
    public function setStartTime()
    {
        $this->_customerSession->setRegistrationStartTime($this->_dateTime->timestamp());
    }

    /**
     * @return void
     */
    public function setEndTime()
    {
        $this->_customerSession->setRegistrationEndTime($this->_dateTime->timestamp());
    }

    /**
     * @return integer
     */
    public function getAccountCreationTime()
    {

        // @TODO: Throw exception if values not set

        $registrationStartTime = $this->_customerSession->getRegistrationStartTime();
        $registrationEndTime = $this->_customerSession->getRegistrationEndTime();

        return $registrationEndTime - $registrationStartTime;
    }
}

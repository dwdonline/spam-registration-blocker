<?php

namespace SamSteele\SpamBlocker\Model\SpamBlocker;

use \Magento\Framework\Model\AbstractModel;
use SamSteele\SpamBlocker\Api\HoneypotInterface;

class Honeypot extends AbstractModel implements HoneypotInterface
{
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Request\Http $request
    ){
        $this->_request = $request;
    }

    /**
     * @return boolean
     */
    public function check($honeypotName) 
    {
        return !!$this->_request->getParam($honeypotName);
    }
}

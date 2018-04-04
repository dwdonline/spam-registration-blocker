<?php

namespace SamSteele\SpamBlocker\Api;

interface HoneypotInterface
{
    /**
     * @return boolean
     */
    public function check();

}

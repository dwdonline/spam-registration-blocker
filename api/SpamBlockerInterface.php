<?php

namespace SamSteele\SpamBlocker\Api;

interface SpamBlockerInterface
{
    /**
     * @return boolean
     */
    public function validate();

    /**
     * @return boolean
     */
    public function validateCreationTime();

    /**
     * @return boolean
     */
    public function validateHoneypot();

    /**
     * @return null
     */
    public function blockRegistration();

}

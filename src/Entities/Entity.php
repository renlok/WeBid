<?php

namespace WeBid\Entities;

class Entity
{
    public function __construct() {
        // set createdAt if exists
        if (property_exists($this, 'createdAt')) {
            $this->createdAt = new \DateTime();
        }
    }
}
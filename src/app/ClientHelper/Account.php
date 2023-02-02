<?php

namespace App\ClientHelper;

use Obada\ClientHelper\Account as ChAccount;

class Account {
    public function __construct(protected ChAccount $account) {}

    public static function make(ChAccount $account) : self 
    {
        return new self($account);
    }

    public function __call($method, $arguments) 
    {
        return $this->account->{$method}($arguments);
    }
    
    public function __toString()
    {
        return $this->account->__toString();
    }

    public function getBreadCrumbsAddress() : string
    {
        if (!strlen($this->account->getName())) {
            return $this->getShortAddress();
        }

        return $this->account->getName();
    }

    public function getShortAddress() {
        return shortifyAddress($this->account->getAddress());
    }

    public function getFormattedBalance()
    {
        return number_format($this->account->getBalance(), 2);
    }

    public function getFormattedNftCount()
    {
        return number_format($this->account->getNftCount(), 0, '.', ',');
    }
}
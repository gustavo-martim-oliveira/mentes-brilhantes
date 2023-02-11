<?php

namespace Models\Api;

use Models\Builder;

class Address extends Builder{

    protected $table = 'addresses';

    public function __construct() {
        parent::__construct();
        parent::from($this->table);
    }

}
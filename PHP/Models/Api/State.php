<?php

namespace Models\Api;

use Models\Builder;

class State extends Builder{

    protected $table = 'states';

    public function __construct() {
        parent::__construct();
        parent::from($this->table);
    }

}
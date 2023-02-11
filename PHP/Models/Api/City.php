<?php

namespace Models\Api;

use Models\Builder;

class City extends Builder{

    protected $table = 'cities';

    public function __construct() {
        parent::__construct();
        parent::from($this->table);
    }

}
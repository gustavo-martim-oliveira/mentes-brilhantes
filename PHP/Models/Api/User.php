<?php

namespace Models\Api;

use Models\Builder;

class User extends Builder{

    protected $table = 'users';

    public function __construct() {
        parent::__construct();
        parent::from($this->table);
    }

}
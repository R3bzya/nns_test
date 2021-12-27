<?php

namespace App\Services;

abstract class BaseService
{
    abstract public function run(): bool;
}

<?php

namespace App\Contracts;

interface AuthenticationContract
{
    public function login(): bool;
}
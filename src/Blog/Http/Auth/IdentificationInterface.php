<?php

namespace Galim\Itrvb\Blog\Http\Auth;

use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\User;

interface IdentificationInterface
{
    public function user(Request $request): User;
}
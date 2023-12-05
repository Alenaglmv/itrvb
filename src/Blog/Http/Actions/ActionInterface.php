<?php
namespace Galim\Itrvb\Blog\Http\Actions;

use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}
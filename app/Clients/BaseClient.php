<?php

namespace App\Clients;
use Illuminate\Http\Request;

/**
 * BaseClient class
 */
abstract class BaseClient
{
    /**
     * @var Request $request The request object
     */
    protected $request;

    /**
     * Class constructor
     * @param Request $request The request object
     */
    protected function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Returns JSON
     */
    abstract protected function get();
}

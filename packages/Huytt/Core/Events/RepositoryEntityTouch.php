<?php

namespace Huytt\Core\Events;

use Prettus\Repository\Contracts\RepositoryInterface;

class RepositoryEntityTouch
{
    /**
     * @var string
     */
    protected $action = "touch";

    protected $touchRepositories;
    /**
     * @param string[] $touchRepositories
     */
    public function __construct(array $touchRepositories)
    {
        $this->touchRepositories = $touchRepositories;
    }

    public function getAction() {
        return $this->action;
    }

    public function getTouchRepositories() {
        return $this->touchRepositories;
    }
}

<?php

namespace TypiCMS\Modules\Newsletter\Repositories;

use TypiCMS\Modules\Core\Custom\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Custom\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements NewsletterInterface
{
    public function __construct(NewsletterInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}

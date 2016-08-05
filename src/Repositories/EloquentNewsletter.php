<?php

namespace TypiCMS\Modules\Newsletter\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Custom\Repositories\RepositoriesAbstract;

class EloquentNewsletter extends RepositoriesAbstract implements NewsletterInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}

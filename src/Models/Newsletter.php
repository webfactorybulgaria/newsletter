<?php

namespace TypiCMS\Modules\Newsletter\Models;

use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Newsletter extends Base
{
    use Historable;
    use PresentableTrait;

    protected $table = 'newsletter';

    protected $presenter = 'TypiCMS\Modules\Newsletter\Presenters\ModulePresenter';

    protected $fillable = [
        'email',
    ];

    protected $appends = [];

    /**
     * Get title attribute from translation table
     * and append it to main model attributes.
     *
     * @return string title
     */
    public function getTitleAttribute($value)
    {
        return $value;
    }
}
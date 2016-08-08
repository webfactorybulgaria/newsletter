<?php

namespace TypiCMS\Modules\Newsletter\Models;

use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;

class Newsletter extends Base
{
    use Historable;
    use PresentableTrait;

    protected $table = 'newsletter';

    protected $presenter = 'TypiCMS\Modules\Newsletter\Shells\Presenters\ModulePresenter';

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

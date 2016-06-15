<?php

namespace TypiCMS\Modules\Newsletter\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.newsletter'), function (SidebarGroup $group) {
            $group->id = 'newsletter';
            $group->weight = 20;
            $group->addItem(trans('newsletter::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.newsletter.sidebar.icon', 'icon fa fa-fw fa-envelope');
                $item->weight = config('typicms.newsletter.sidebar.weight');
                $item->route('admin::index-newsletter');
                $item->append('admin::create-newsletter');
                $item->authorize(
                    Gate::allows('newsletter.index')
                );
            });
        });
    }
}

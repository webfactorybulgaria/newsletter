<?php

namespace TypiCMS\Modules\Newsletter\Http\Controllers;

use TypiCMS\Modules\Newsletter\Http\Requests\FormRequest;
use TypiCMS\Modules\Newsletter\Models\Newsletter;
use TypiCMS\Modules\Newsletter\Repositories\NewsletterInterface;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use Excel;

class AdminController extends BaseAdminController
{
    public function __construct(NewsletterInterface $newsletter)
    {
        parent::__construct($newsletter);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('newsletter::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('newsletter::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Newsletter\Models\Newsletter $newsletter
     *
     * @return \Illuminate\View\View
     */
    public function edit(Newsletter $newsletter)
    {
        return view('newsletter::admin.edit')
            ->with(['model' => $newsletter]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Newsletter\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $newsletter = $this->repository->create($request->all());

        return $this->redirect($request, $newsletter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Newsletter\Models\Newsletter         $newsletter
     * @param \TypiCMS\Modules\Newsletter\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Newsletter $newsletter, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $newsletter);
    }

    /**
     * Export all resources into a csv file.
     *
     * @return void
     */
    public function export()
    {
        $subs = $this->repository->all([], true);
        $subscribers = $subs->toArray();

        Excel::create('Subscribers', function($excel) use ($subscribers) {

            $excel->sheet('Subscribers', function($sheet) use ($subscribers) {

                $sheet->fromArray($subscribers);

            });

        })->export('csv');

        //return $this->redirect($request, $newsletter);
    }
}

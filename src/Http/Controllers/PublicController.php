<?php

namespace TypiCMS\Modules\Newsletter\Http\Controllers;

use TypiCMS\Modules\Newsletter\Http\Requests\FormRequest;
use TypiCMS\Modules\Newsletter\Repositories\NewsletterInterface;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use VNewsletter;

class PublicController extends BasePublicController
{
    protected $form;

    public function __construct(NewsletterInterface $newsletter)
    {
        parent::__construct($newsletter);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function form()
    {
        return view('newsletter::public.form');
    }

    /**
     * Display a page when form is sent.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function sent()
    {
        if (session('success')) {
            return view('newsletter::public.sent');
        }

        return redirect(url('/'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function store(FormRequest $request)
    {
        $data = [];
        foreach ($request->all() as $key => $value) {
            $data[$key] = strip_tags($value);
        }

        VNewsletter::subscribe($data['email']);

        $newsletter = $this->repository->create($data);

        event('NewNewsletterRequest', [$newsletter]);

        return redirect()->route(config('app.locale').'.newsletter.sent')
            ->with('success', true);
    }
}

<?php

namespace TypiCMS\Modules\Newsletter\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Newsletter\Models\Newsletter;
use TypiCMS\Modules\Newsletter\Repositories\NewsletterInterface as Repository;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use VNewsletter;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $model = $this->repository->create(Request::all());
        $error = $model ? false : true;

        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $updated = $this->repository->update(Request::all());

        return response()->json([
            'error' => !$updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Newsletter\Models\Newsletter $newsletter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Newsletter $newsletter)
    {
        VNewsletter::unsubscribe($newsletter->email);

        $deleted = $this->repository->delete($newsletter);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}

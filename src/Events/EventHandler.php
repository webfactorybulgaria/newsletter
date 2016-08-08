<?php

namespace TypiCMS\Modules\Newsletter\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;

class EventHandler
{
    public function onCreate(Model $model)
    {
        $webmaster = config('typicms.webmaster_email');

        // Send a mail to visitor
        Mail::send('newsletter::mails.message-to-visitor', ['model' => $model], function (Message $message) use ($model, $webmaster) {
            $subject = '['.TypiCMS::title().'] ';
            $subject .= trans('newsletter::global.Thank you for your newsletter request');
            $message->from($webmaster)->to($model->email)->subject($subject);
        });

        // Send a mail to webmaster
        Mail::send('newsletter::mails.message-to-webmaster', ['model' => $model], function (Message $message) use ($model, $webmaster) {
            $subject = '['.TypiCMS::title().'] ';
            $subject .= trans('newsletter::global.New newsletter request');
            $message->from($model->email)->to($webmaster)->subject($subject);
        });
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     *
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('NewNewsletterRequest', 'TypiCMS\Modules\Newsletter\Shells\Events\EventHandler@onCreate');
    }
}

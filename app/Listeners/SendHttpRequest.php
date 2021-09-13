<?php

namespace App\Listeners;

use App\Events\MessagePublished;
use App\Models\Topic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendHttpRequest implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessagePublished  $event
     * @return void
     */
    public function handle(MessagePublished $event)
    {
        //fetching the topic
        $topic = Topic::where('id', $event->topic)->first();
        if ($topic){
            //getting each subscribers under the topic
            foreach ($topic->subscribers as $subscriber){
                try {
                    //sending an http request to all endpoints
                    Http::post($subscriber->url, [
                        'topic' => $topic->topic,
                        'data' => $event->msg,
                    ]);
                } catch (\Throwable $th) {

                }
            }
//            return response()->json('Done', 200);
        }
    }
}

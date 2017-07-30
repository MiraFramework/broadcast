<?php

namespace Mira\Broadcast;

class Broadcast
{
    public static function channel($channel)
    {
        $pusher = new \Pusher\Pusher(
            getenv('pusher_key'),
            getenv('pusher_secret'),
            getenv('pusher_default_app')
        );

        $class = new static;
        $class->pusher = $pusher;
        $class->channel = $channel;
        return $class;
    }

    public function event($event)
    {
        $this->event = $event;
        return $this;
    }

    public function data($array)
    {
        $this->data = $array;
        return $this;
    }

    public function send()
    {
        return $this->pusher->trigger($this->channel, $this->event, $this->data);
    }

    public function app($app)
    {
        if (is_string($app)) {
            $app = getenv('pusher_app_'.$app);
        }
        $this->pusher = new \Pusher\Pusher(
            getenv('pusher_key'),
            getenv('pusher_secret'),
            $app
        );
        return $this;
    }

    
}

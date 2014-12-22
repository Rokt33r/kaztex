<?php namespace Kaztex\Core\Event;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Log\Writer;

class EventDispatcher {

    /**
     * @var Dispatcher|Writer
     */
    protected $event, $log;

    /**
     * @param Dispatcher $event
     * @param Writer $log
     */
    public function __construct(Dispatcher $event, Writer $log){
        $this->event = $event;
        $this->log = $log;
    }

    /**
     * Dispatch with a event dto
     * @param $event
     */
    public function dispatch($event){
        $eventName = $this->getEventName($event);

        $this->event->fire($eventName, $event);

        $this->log->info("{$eventName} was fired");
    }

    /**
     * @param $event
     * @return mixed
     */
    protected function getEventName($event){
        return str_replace('\\', '.', get_class($event));
    }
}
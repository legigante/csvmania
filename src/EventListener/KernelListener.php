<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class KernelListener
{

    /**
     * KernelListener constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        // sticky locale
        $request = $event->getRequest();
        $locale = $request->getSession()->get('_locale', 'en');
        $request->setLocale($locale);
    }

}
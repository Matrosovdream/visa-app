<?php

namespace App\View\Composers;

use App\Services\GlobalsService;
use Illuminate\View\View;

class GlobalsComposer
{
    public function __construct(private GlobalsService $globals) {}

    public function compose(View $view): void
    {
        $globals = $this->globals->getGlobals();

        $candidates = [
            'languages'      => fn () => $this->globals->getLanguages(),
            'menuTop'        => fn () => $this->globals->getMenuTop(),
            'currencies'     => fn () => $this->globals->getCurrencies(),
            'countries'      => fn () => $this->globals->getCountries(),
            'activeLanguage' => fn () => $this->globals->getActiveLanguage(),
            'activeCurrency' => fn () => $this->globals->getActiveCurrency(),
            'siteSettings'   => fn () => $globals['siteSettings'] ?? null,
        ];

        // Don't clobber data the controller already passed in. E.g. the
        // dashboard.countries.index view receives a paginator called
        // $countries from its controller — we must not overwrite it with
        // the globals collection.
        $existing = $view->getData();
        foreach ($candidates as $key => $resolver) {
            if (!array_key_exists($key, $existing)) {
                $view->with($key, $resolver());
            }
        }
    }
}

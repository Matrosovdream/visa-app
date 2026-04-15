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

        $view->with([
            'languages'      => $this->globals->getLanguages(),
            'menuTop'        => $this->globals->getMenuTop(),
            'currencies'     => $this->globals->getCurrencies(),
            'countries'      => $this->globals->getCountries(),
            'activeLanguage' => $this->globals->getActiveLanguage(),
            'activeCurrency' => $this->globals->getActiveCurrency(),
            'siteSettings'   => $globals['siteSettings'] ?? null,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    private function authProps()
    {
        return [
            'canLogin' => auth()->guest(),
            'canRegister' => auth()->guest(),
        ];
    }

    public function contact()
    {
        return Inertia::render('StaticPages/Contact', $this->authProps());
    }

    public function faq()
    {
        return Inertia::render('StaticPages/Faq', $this->authProps());
    }

    public function alerts()
    {
        return Inertia::render('StaticPages/Alerts', $this->authProps());
    }

    public function policies()
    {
        return Inertia::render('StaticPages/Policies', $this->authProps());
    }

    public function destinations()
    {
        return Inertia::render('Destinations', $this->authProps());
    }
    public function stopover()
    {
        return Inertia::render('Stopover', $this->authProps());
    }

    public function addons()
    {
        return Inertia::render('AddOns', $this->authProps());
    }


}



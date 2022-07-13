<?php

namespace App\Controllers;

use Exception;
use Directions\Directions;

class PageController
{

    /**
     * @return int
     * @throws Exception
     */
    public function index(): int
    {

        $title = 'Расчет стоимости доставки';

        $directions = new Directions();
        $cities = $directions->get_cities();

        return view('pages.index',
            compact( 'title', 'cities')
        );
    }


    /**
     * @return int
     */
    public function page_404(): int
    {
        $title = '404';
        return view('404', compact('title'));
    }
}

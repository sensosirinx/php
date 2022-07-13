<?php

namespace Directions;

use XLSXReader;

class Directions
{
    /**
     * @var array
     */
    private array $data;

    public function __construct()
    {
        $this->data = $this->build_data();
    }

    /**
     * @return array
     */
    private function build_data (): array
    {
        $xlsx = new XLSXReader('../table.russia.xlsx');
        $sheets = $xlsx->getSheetNames();
        return $xlsx->getSheetData($sheets[1]);
    }

    /**
     * @return array
     */
    public function get_data(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function get_cities (): array
    {
        return $this->data[0];
    }

}

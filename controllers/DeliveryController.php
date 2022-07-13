<?php

namespace App\Controllers;

use App\App\App;
use Directions\Directions;
use Exception;

class DeliveryController
{

    /**
     * @var array
     */
    private array $delivery_services = [];
    private array $data = [];
    private int $delivery_type = 0;


    /**
     * @return void
     * @throws Exception
     */
    public function fast (): void
    {
        $this->delivery_type = 1;
        $this->init();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function slow (): void
    {
        $this->delivery_type = 2;
        $this->init();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function init(): void
    {
        $this->data = $this->get_data();
        if (count($this->data) === 0) {
            $title = '404';
            view('404',
                compact('title')
            );
            return;
        } elseif (!$this->data['source_kladr'] or !$this->data['target_kladr']) {
            $this->error_message('Не выбраны пункты доставки');
            return;
        } elseif (!$this->data['weight']) {
            $this->error_message('Не выбран вес посылки');
            return;
        }

        if (isset($this->data['delivery_service'])) {
            $this->delivery_services = DeliveryServiceController::get_service($this->data['delivery_service']);
        } else {
            $this->delivery_services = DeliveryServiceController::get_all_services();
        }

        if (count($this->delivery_services) > 0) {

            $itog = $this->build_itog();
            view('result',
                compact( 'itog')
            );

        } else {
            $this->error_message('Отсутствует транспортная компания');
        }

    }

    /**
     * @return array
     * @throws Exception
     */
    private function build_itog (): array
    {
        $itog = [];
        foreach ($this->delivery_services as $service) {
            $route = $this->build_route($this->data['source_kladr'], $this->data['target_kladr']);
            $delivery_price = DeliveryServiceController::get_price($route, $this->data['weight'], $service->data);
            if ($this->delivery_type === 1) {
                $result = $this->build_fast_price($route, $service->data['kms_day'], $delivery_price);
            } else {
                $result = $this->build_slow_price($delivery_price);
            }
            $itog[] = $result;
        }
        return $itog;
    }

    /**
     * @param int $route
     * @param int $kms_day
     * @param array $delivery
     * @return array
     */
    private function build_fast_price (int $route, int $kms_day, array $delivery): array
    {
        $days = DeliveryServiceController::get_days($route, $kms_day);
        return [
            "price" => $delivery['price'],
            "period" => $days,
            "error" => ''
        ];
    }

    /**
     * @param array $delivery
     * @return array
     */
    private function build_slow_price (array $delivery): array
    {
        $base_cost = App::get('config')['base_cost'];
        $itog_price = $delivery['price'] + $base_cost;
        $coefficient = round($itog_price/$base_cost, 2);
        return [
            "coefficient" => $coefficient,
            "date" => $delivery['date'],
            "error" => ''
        ];
    }

    /**
     * Строим маршрут. Возвращаем кол-во километров между населенными пунктами
     * @param string $from
     * @param string $to
     * @return int
     */
    private function build_route (string $from, string $to): int
    {
        $directions = new Directions();
        $data = $directions->get_data();
        $cities = $data[0];
        $source_kladr = [];
        $target_kladr = [];
        foreach ($cities as $key => $val) {
            if ($from === $val) {
                $source_kladr['id'] = $key;
                $source_kladr['name'] = $val;
            }
            if ($to === $val) {
                $target_kladr['id'] = $key;
                $target_kladr['name'] = $val;
            }
        }
        $min_route = App::get('config')['min_km']; // Минимальный километраж
        if (count($source_kladr) > 0 and count($target_kladr) > 0) {
            $route = intval($data[$source_kladr['id']][$target_kladr['id']]);
            if ($route < $min_route) {
                $route = $min_route;
            }
            return $route;
        }
        return $min_route;
    }

    /**
     * @param string|null $message
     * @return void
     */
    private function error_message (string $message = null): void
    {
        $itog = [
            "price"=> 0,
            "date"=> '',
            "error"=> $message
        ];
        view('result',
            compact('itog')
        );
    }

    /**
     * @return array
     */
    private function get_data (): array
    {
        $data = [];
        if (isset($_GET['source_kladr'])) {
            $data['source_kladr'] = htmlentities(htmlspecialchars(trim($_GET['source_kladr'])));
        }
        if (isset($_GET['target_kladr'])) {
            $data['target_kladr'] = htmlentities(htmlspecialchars(trim($_GET['target_kladr'])));
        }
        if (isset($_GET['weight'])) {
            $data['weight'] = doubleval($_GET['weight']);
        }
        if (isset($_GET['delivery_service'])) {
            $data['delivery_service'] = htmlentities(htmlspecialchars(trim($_GET['delivery_service'])));
        }
        return $data;
    }

}

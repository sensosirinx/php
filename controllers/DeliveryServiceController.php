<?php

namespace App\Controllers;

use App\App\App;
use App\Models\DeliveryService;
use DateTime;
use Exception;

class DeliveryServiceController
{

    /**
     * @param string|null $name
     * @return array
     */
    public static function get_service (string $name=null) : array
    {
        $where = '';
        if ($name) {
            $where = "WHERE name='{$name}'";
        }
        return App::get('db')->query("SELECT * FROM delivery_services {$where}", DeliveryService::class);
    }

    /**
     * @return array
     */
    public static function get_all_services (): array
    {
        return self::get_service();
    }

    /**
     * @param int $route
     * @param int $weight
     * @param array $service
     * @return array
     * @throws Exception
     */
    public static function get_price (int $route, int $weight, array $service): array
    {
        $price_km = self::build_price_km($route, $service['tariff_km']);
        $price_kg = self::build_price_kg($weight, $service['tariff_kg']);
        $price = $price_kg + $price_km;
        $days = self::get_days($route, $service['kms_day']);
        $today = date("Y-m-d");
        $date = new DateTime($today);
        $date->modify('+'.$days.' day');
        $date = $date->format('Y-m-d');
        return [
            'price' => floatval($price),
            'date' => $date,
            'error' => ''
        ];
    }

    /**
     * @param int $route
     * @param int $tariff
     * @return int
     */
    public static function build_price_km (int $route, float $tariff): int
    {
        return ceil($route * $tariff); // прайс = кол-во километров * стоимость за 1 км
    }

    /**
     * @param int $weight
     * @param float $tariff
     * @return int
     */
    public static function build_price_kg (int $weight, float $tariff): int
    {
        return ceil($weight * $tariff); // прайс = кол-во киллограмм * стоимость за 1 кг
    }

    /**
     * @param int $route
     * @param int $kms_day
     * @return int
     */
    public static function get_days (int $route, int $kms_day): int
    {
        $days = ceil($route/$kms_day);
        $now_hours = (int) date("H");
        if ($now_hours > 18) {
            $days++;
        }
        return $days;
    }

}

<?php

namespace App\Models;


class DeliveryService
{
    private int $id;
    private string $name;
    private float $tariff_km; // тариф стоимость в рублях за 1 км
    private float $tariff_kg; // тариф стоимость в рублях за 1 кг груза
    private int $kms_day; // кол-во километров в день
    public array $data;

    public function __construct()
    {
        $this->data = $this->get_service_data();
    }

    /**
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function get_name(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function get_tariff_km(): float
    {
        return $this->tariff_km;
    }

    /**
     * @return float
     */
    public function get_tariff_kg(): float
    {
        return $this->tariff_kg;
    }

    /**
     * @return int
     */
    public function get_kms_day(): int
    {
        return $this->kms_day;
    }

    /**
     * @return array
     */
    private function get_service_data(): array
    {
        return [
            "id" =>  $this->id,
            "name" =>  $this->name,
            "tariff_km" =>  $this->tariff_km,
            "tariff_kg" =>  $this->tariff_kg,
            "kms_day" => $this->kms_day
        ];
    }

}

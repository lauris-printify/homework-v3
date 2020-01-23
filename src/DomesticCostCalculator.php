<?php


namespace App;


use App\Entity\Orders;
use App\Interfaces\IProductsRepository;

class DomesticCostCalculator
{
    const FIRST_MUG_SHIPPING = 200;
    const CONSECUTIVE_MUG_SHIPPING = 100;
    const FIRST_T_SHIRT_SHIPPING = 100;
    const CONSECUTIVE_T_SHIRT_SHIPPING = 50;
    const EXPRESS_SHIPPING = 1000;

    private $repository;

    public function __construct(IProductsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function calculate(int $id_user, array $line_items): array
    {
        $production_cost = 0;
        $shipping_cost = 0;

        foreach ($line_items as $line_item)
        {
            $id = $line_item[Orders::PRODUCT_ID];
            $quantity = $line_item[Orders::PRODUCT_QUANTITY];

            $product = $this->repository->getById($id_user, $id);

            if ($product->getType() === ProductTypeValidator::MUG)
            {
                $production_cost += $product->getCost();
                $shipping_cost += self::FIRST_MUG_SHIPPING;
                $quantity--;
                $production_cost += $product->getCost() * $quantity;
                $shipping_cost += self::CONSECUTIVE_MUG_SHIPPING * $quantity;
            }
            elseif ($product->getType() === ProductTypeValidator::TSHIRT)
            {
                $production_cost += $product->getCost();
                $shipping_cost += self::FIRST_T_SHIRT_SHIPPING;
                $quantity--;
                $production_cost += $product->getCost() * $quantity;
                $shipping_cost += self::CONSECUTIVE_T_SHIRT_SHIPPING * $quantity;
            }
        }

        return [
            Orders::ORDER_PRODUCTION_COST => $production_cost,
            Orders::ORDER_SHIPPING_COST => $shipping_cost,
            Orders::ORDER_TOTAL_COST => $production_cost + $shipping_cost
        ];
    }

    public function calculate_express(int $id_user, array $line_items): array
    {
        $production_cost = 0;
        $shipping_cost = 0;

        foreach ($line_items as $line_item)
        {
            $id = $line_item[Orders::PRODUCT_ID];
            $quantity = $line_item[Orders::PRODUCT_QUANTITY];

            $product = $this->repository->getById($id_user, $id);

            if ($product->getType() === ProductTypeValidator::MUG)
            {
                $production_cost += $product->getCost();
                $shipping_cost += self::EXPRESS_SHIPPING;
                $quantity--;
                $production_cost += $product->getCost() * $quantity;
                $shipping_cost += self::EXPRESS_SHIPPING * $quantity;
            }
            elseif ($product->getType() === ProductTypeValidator::TSHIRT)
            {
                $production_cost += $product->getCost();
                $shipping_cost += self::EXPRESS_SHIPPING;
                $quantity--;
                $production_cost += $product->getCost() * $quantity;
                $shipping_cost += self::EXPRESS_SHIPPING * $quantity;
            }
        }

        return [
            Orders::ORDER_PRODUCTION_COST => $production_cost,
            Orders::ORDER_SHIPPING_COST => $shipping_cost,
            Orders::ORDER_TOTAL_COST => $production_cost + $shipping_cost
        ];
    }
}
<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Data\Quote;

/**
 * Shipping method full code
 */
class ShippingMethodFullCode
{
    /**
     * Parse
     * 
     * @param string $value
     * @return array
     */
    public function parse($value)
    {
        $valuePieces = explode('_', $value);
        return [array_shift($valuePieces), implode('_', $valuePieces)];
    }

    /**
     * Generate
     * 
     * @param string $carrierCode
     * @param string $methodCode
     * @return string
     */
    public function generate($carrierCode, $methodCode)
    {
        return $carrierCode.'_'.$methodCode;
    }
}
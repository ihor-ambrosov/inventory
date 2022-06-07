<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales;

/**
 * Source item interface
 */
interface SourceItemInterface
{
    /**
     * Get SKU
     * 
     * @return string
     */
    public function getSku(): string;

    /**
     * Set SKU
     * 
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku);

    /**
     * Get source code
     * 
     * @return string
     */
    public function getSourceCode(): string;

    /**
     * Set source code
     * 
     * @param string $sourceCode
     * @return $this
     */
    public function setSourceCode(string $sourceCode);

    /**
     * Get quantity
     * 
     * @return float
     */
    public function getQuantity(): float;

    /**
     * Set quantity
     * 
     * @param float $quantity
     * @return $this
     */
    public function setQuantity(float $quantity);

    /**
     * Get is salable
     * 
     * @return float
     */
    public function getIsSalable(): bool;

    /**
     * Set is salable
     * 
     * @param bool $isSalable
     * @return $this
     */
    public function setIsSalable(bool $isSalable);

    /**
     * Check if is salable
     * 
     * @return float
     */
    public function isSalable(): bool;
}
<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryReservationCli;

/**
 * Salable quantity inconsistency
 */
class SalableQuantityInconsistency extends \Magento\InventoryReservationCli\Model\SalableQuantityInconsistency
{
    /**
     * Source code
     * 
     * @var string
     */
    private $sourceCode;

    /**
     * Get source code
     * 
     * @return string
     */
    public function getSourceCode(): string
    {
        return $this->sourceCode;
    }

    /**
     * Set source code
     *
     * @param string $sourceCode
     */
    public function setSourceCode(string $sourceCode): void
    {
        $this->sourceCode = $sourceCode;
    }
}
<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Api;

/**
 * Current source provider interface
 */
interface CurrentSourceProviderInterface
{
    /**
     * Set source code
     * 
     * @param string|null $sourceCode
     * @return void
     */
    public function setSourceCode(string $sourceCode = null): void;

    /**
     * Get source code
     * 
     * @return string|null
     */
    public function getSourceCode(): ?string;
}
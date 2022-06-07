<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Current source provider
 */
class CurrentSourceProvider implements \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
{
    /**
     * Source code
     * 
     * @var string|null
     */
    private $sourceCode;

    /**
     * Set source code
     * 
     * @param string|null $sourceCode
     * @return void
     */
    public function setSourceCode(string $sourceCode = null): void
    {
        $this->sourceCode = $sourceCode;
    }

    /**
     * Get source code
     * 
     * @return string|null
     */
    public function getSourceCode(): ?string
    {
        return $this->sourceCode;
    }
}
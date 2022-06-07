<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Config\Config\Structure;

/**
 * Abstract element configuration controller plugin
 */
class AbstractElement
{
    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
    )
    {
        $this->currentSourceProvider = $currentSourceProvider;
    }

    /**
     * After is visible
     * 
     * @param \Magento\Config\Model\Config\Structure\AbstractElement $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsVisible(
        \Magento\Config\Model\Config\Structure\AbstractElement $subject,
        $result
    )
    {
        if (!$result) {
            return false;
        }
        $sourceCode = (string) $this->currentSourceProvider->getSourceCode();
        $data = $subject->getData();
        if (
            ($sourceCode && !$this->getDataFlag($data, 'enabledForSource')) || 
            (!$sourceCode && $this->getDataFlag($data, 'enabledForSourceOnly'))
        ) {
            return false;
        }
        return true;
    }

    /**
     * Get data flag
     * 
     * @param array $data
     * @param string $key
     * @return bool
     */
    private function getDataFlag(array $data, string $key): bool
    {
        return array_key_exists($key, $data)? $data[$key] === 'true' : false;
    }
}
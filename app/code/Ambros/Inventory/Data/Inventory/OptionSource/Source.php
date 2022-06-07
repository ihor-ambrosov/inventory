<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Data\Inventory\OptionSource;

/**
 * Source option source
 */
class Source implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Get sources
     * 
     * @var \Ambros\InventoryCommon\Model\GetSources
     */
    private $getSources;

    /**
     * Options
     * 
     * @var array
     */
    private $options;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\GetSources $getSources
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\GetSources $getSources
    )
    {
        $this->getSources = $getSources;
    }
    
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }
        $this->options = [];
        foreach ($this->getSources->execute() as $source) {
            $this->options[] = [
                'label' => $source->getName(),
                'value' => $source->getSourceCode(),
            ];
        }
        return $this->options;
    }
}
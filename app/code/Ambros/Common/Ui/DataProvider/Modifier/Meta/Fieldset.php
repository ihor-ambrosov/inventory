<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta;

/**
 * Field set UI data provider meta
 */
class Fieldset extends \Ambros\Common\Ui\DataProvider\Modifier\Meta\Component
{
    
    /**
     * Create
     * 
     * @param array $config
     * @param array $children
     * @return array
     */
    public function create(array $config = [], array $children = []): array
    {
        return parent::create(
            array_merge(
                [
                    'componentType' => \Magento\Ui\Component\Form\Fieldset::NAME,
                    'label' => '',
                    'collapsible' => true,
                    'opened' => false,
                    'visible' => true,
                    'sortOrder' => 0,
                ],
                $config
            ),
            $children
        );
    }
    
}
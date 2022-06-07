<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta;

/**
 * Container UI data provider meta
 */
class Container extends \Ambros\Common\Ui\DataProvider\Modifier\Meta\Component
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
                    'componentType' => \Magento\Ui\Component\Container::NAME,
                    'formElement' => \Magento\Ui\Component\Container::NAME,
                    'breakLine' => 'false',
                ],
                $config
            ),
            $children
        );
    }
    
}
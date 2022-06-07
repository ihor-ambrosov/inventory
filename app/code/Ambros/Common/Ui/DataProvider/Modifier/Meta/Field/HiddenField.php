<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta\Field;

/**
 * Hidden field UI data provider meta
 */
class HiddenField extends \Ambros\Common\Ui\DataProvider\Modifier\Meta\Field
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
                    'formElement' => \Magento\Ui\Component\Form\Element\Hidden::NAME,
                    'dataType' => \Magento\Ui\Component\Form\Element\DataType\Number::NAME,
                ],
                $config
            ),
            $children
        );
    }
    
}
<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta\Field;

/**
 * Boolean field UI data provider meta
 */
class BooleanField extends \Ambros\Common\Ui\DataProvider\Modifier\Meta\Field
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
                    'formElement' => \Magento\Ui\Component\Form\Element\Checkbox::NAME,
                    'dataType' => \Magento\Ui\Component\Form\Element\DataType\Number::NAME,
                    'prefer' => 'toggle',
                    'valueMap' => [ 'false' => '0', 'true' => '1', ],
                ],
                $config
            ),
            $children
        );
    }
    
}
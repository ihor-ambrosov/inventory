<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta\Field;

/**
 * Date field UI data provider meta
 */
class DateField extends \Ambros\Common\Ui\DataProvider\Modifier\Meta\Field
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
                    'component' => 'Magento_Ui/js/form/element/date',
                    'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                    'dataType' => \Magento\Ui\Component\Form\Element\DataType\Date::NAME,
                    'additionalClasses' => 'admin__field-small admin__field-date',
                    'dateFormat' => 'y-MM-dd',
                ],
                $config
            ),
            $children
        );
    }
    
}
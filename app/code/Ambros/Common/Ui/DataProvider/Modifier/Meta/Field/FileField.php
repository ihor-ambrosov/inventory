<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta\Field;

/**
 * File field UI data provider meta
 */
class FileField extends \Ambros\Common\Ui\DataProvider\Modifier\Meta\Component
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
                    //'formElement' => 'fileUploader',
                    //'componentType' => 'fileUploader',
                    'formElement' => 'input',
                    'componentType' => 'field',
                    'component' => 'Ambros_Common/js/components/file-uploader',
                    'elementTmpl' => 'Ambros_Common/components/file-uploader',
                ],
                $config
            ),
            $children
        );
    }
    
}
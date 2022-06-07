<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Common\Ui\DataProvider\Modifier\Meta;

/**
 * Component UI data provider meta
 */
class Component
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
        $meta = [
            'arguments' => [
                'data' => [
                    'config' => $config,
                ],
            ],
        ];
        if (!empty($children)) {
            $meta['children'] = $children;
        }
        return $meta;
    }
    
}
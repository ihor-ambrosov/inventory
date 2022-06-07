<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryImportExport\Import\Validator;

/**
 * Price validator
 */
class PriceValidator implements \Magento\InventoryImportExport\Model\Import\Validator\ValidatorInterface
{
    /**
     * Validation result factory
     * 
     * @var \Magento\Framework\Validation\ValidationResultFactory
     */
    private $validationResultFactory;
    
    /**
     * Constructor
     * 
     * @param \Magento\Framework\Validation\ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        \Magento\Framework\Validation\ValidationResultFactory $validationResultFactory
    )
    {
        $this->validationResultFactory = $validationResultFactory;
    }
    
    /**
     * @inheritdoc
     */
    public function validate(array $rowData, int $rowNumber)
    {
        $errors = [];
        if (isset($rowData['price']) && $rowData['price'] && !is_numeric($rowData['price'])) {
            $errors[] = __('Invalid price');
        }
        return $this->validationResultFactory->create([ 'errors' => $errors, ]);
    }
}
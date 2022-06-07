<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\Quote;

/**
 * Quote address wrapper factory
 */
class AddressFactory
{
    /**
     * Wrapper factory
     * 
     * @var \Ambros\Common\DataObject\WrapperFactory
     */
    private $wrapperFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @return void
     */
    public function __construct(\Ambros\Common\DataObject\WrapperFactory $wrapperFactory)
    {
        $this->wrapperFactory = $wrapperFactory;
    }

    /**
     * Create
     * 
     * @param \Magento\Quote\Api\Data\AddressInterface $quoteAddress
     * @return \Ambros\Inventory\Wrapper\Model\Quote\Quote\Address
     */
    public function create(
        \Magento\Quote\Api\Data\AddressInterface $quoteAddress
    ): \Ambros\Inventory\Wrapper\Model\Quote\Quote\Address
    {
        return $this->wrapperFactory->create(
            $quoteAddress,
            \Ambros\Inventory\Wrapper\Model\Quote\Quote\Address::class
        );
    }
}
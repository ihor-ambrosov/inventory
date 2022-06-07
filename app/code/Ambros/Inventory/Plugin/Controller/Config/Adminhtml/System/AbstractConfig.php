<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Controller\Config\Adminhtml\System;

/**
 * Abstract configuration controller plugin
 */
class AbstractConfig
{
    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
    )
    {
        $this->currentSourceProvider = $currentSourceProvider;
    }

    /**
     * Before dispatch
     * 
     * @param \Magento\Config\Controller\Adminhtml\System\AbstractConfig $subject
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function beforeDispatch(
        \Magento\Config\Controller\Adminhtml\System\AbstractConfig $subject,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->currentSourceProvider->setSourceCode($request->getParam('source') ?? null);
    }
}
<?php
declare(strict_types=1);

namespace Hrb\ResetUserFilters\Controller\Adminhtml\User;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\ResourceConnection;

/**
 * Class ResetFilters
 *
 * Controller for resetting admin user filters.
 */
class ResetFilters extends Action
{
    /**
     * Constructor for ResetFilters
     *
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        protected ResourceConnection $resourceConnection,
        protected RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $userId = $this->getRequest()->getParam('user_id');
        if ($userId) {
            $connection = $this->resourceConnection->getConnection();
            $connection->delete('ui_bookmark', ['user_id = ?' => $userId]);
            $this->messageManager->addSuccessMessage(__('Filters have been reset.'));
        } else {
            $this->messageManager->addErrorMessage(__('User ID is missing.'));
        }
        $resultRedirect = $this->redirectFactory->create();
        return $resultRedirect->setPath('adminhtml/user/edit', ['user_id' => $userId]);
    }
}

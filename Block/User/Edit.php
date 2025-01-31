<?php
declare(strict_types=1);

namespace Hrb\ResetUserFilters\Block\User;

use Magento\User\Block\User\Edit as MagentoEdit;

/**
 * Class Edit
 *
 * Block for user edit functionality, including reset filters.
 */
class Edit extends MagentoEdit
{
    /**
     * Initialize the block and add buttons
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $deleteFilterConfirmMsg = __("Are you sure you want to delete the user's filter?");
        $this->addButton(
            'reset_filters',
            [
                'label' => __('Reset Filters'),
                'class' => 'action-default scalable',
                'onclick' => sprintf(
                    "deleteConfirm('%s', '%s')",
                    $this->escapeJs($this->escapeHtml($deleteFilterConfirmMsg)),
                    $this->getResetFiltersUrl()
                ),
            ]
        );
    }

    /**
     * Return the URL for resetting filters for the user
     *
     * @return string
     */
    public function getResetFiltersUrl(): string
    {
        return $this->getUrl('resetuserfilters/user/resetfilters', ['user_id' => $this->getObjectId()]);
    }
}

<?php
/**
 * Copyright © 2015 W3D. All rights reserved.
 */

namespace W3development\Exportorders\Model;

class ExportOrder extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('W3development\ExportOrder\Model\ResourceModel\ExportOrder');
    }
}

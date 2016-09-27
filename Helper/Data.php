<?php
/**
 * @author W3D Team
 * @copyright Copyright (c) 2016 W3D
 * @package W3D_Exportorders
 */
namespace W3D\Exportorders\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterfac
     */
    protected $_scopeConfig;

    CONST FORMAT      = 'w3d_exportorder/general/format';
    CONST CRON_LABEL = 'w3d_exportorder/general/cron_label';
    CONST FOLDER_PATH  = 'w3d_exportorder/general/folder_path';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);

        $this->_scopeConfig = $scopeConfig;
    }

    public function getFormat(){
        return $this->_scopeConfig->getValue(self::FORMAT);
    }

    public function getCronLabel(){
        return $this->_scopeConfig->getValue(self::CRON_LABEL);
    }

    public function getFolderPath(){
        return $this->_scopeConfig->getValue(self::FOLDER_PATH);
    }
}


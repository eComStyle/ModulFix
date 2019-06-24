<?php
/*
 *   *********************************************************************************************
 *      Please retain this copyright header in all versions of the software.
 *      Bitte belassen Sie diesen Copyright-Header in allen Versionen der Software.
 *
 *      Copyright (C) Josef A. Puckl | eComStyle.de
 *      All rights reserved - Alle Rechte vorbehalten
 *
 *      This commercial product must be properly licensed before being used!
 *      Please contact info@ecomstyle.de for more information.
 *
 *      Dieses kommerzielle Produkt muss vor der Verwendung ordnungsgemäß lizenziert werden!
 *      Bitte kontaktieren Sie info@ecomstyle.de für weitere Informationen.
 *   *********************************************************************************************
 */

namespace Ecs\ModulFix\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Module\Module;
use Ecs\ModulFix\Core\Events;

class ModuleMain extends ModuleMain_parent
{

    protected $_aModuleVars = ['aModuleControllers', 'aModuleEvents', 'aModuleExtensions', 'aModuleFiles', 'aModulePaths', 'aModules', 'aModuleTemplates', 'aModuleVersions'];

    public function render()
    {
        $ret = parent::render();

        if (Registry::getConfig()->getRequestParameter("moduleId")) {
            $sModuleId = Registry::getConfig()->getRequestParameter("moduleId");
        } else {
            $sModuleId = $this->getEditObjectId();
        }
        $oModule = oxNew(Module::class);
        if (!$oModule->load($sModuleId)) {
            $this->_cleanShopConfVar($sModuleId);
        }
        return $ret;
    }

    /* Seen at: https://gist.github.com/KristianH/b9a2a795252a56e63696bbf61f72f9d9 */
    protected function _cleanShopConfVar($sModuleId)
    {
        foreach ($this->_aModuleVars as $ShopConfVarName) {
            $ShopConfVar = Registry::getConfig()->getShopConfVar($ShopConfVarName);
            if (isset($ShopConfVar[$sModuleId])) {
                unset($ShopConfVar[$sModuleId]);
                Registry::getConfig()->saveShopConfVar("aarr", $ShopConfVarName, $ShopConfVar);
            }
        }
        $Events = oxNew(Events::class);
        $Events->onActivate();
        Registry::getUtilsView()->addErrorToDisplay('ECS_THIS_MODULE_FIXED');
    }
}

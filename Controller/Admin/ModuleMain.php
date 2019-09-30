<?php
/*    Please retain this copyright header in all versions of the software
 *
 *    Copyright (C) Josef A. Puckl | eComStyle.de
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see {http://www.gnu.org/licenses/}.
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

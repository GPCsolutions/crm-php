<?php
/* Copyright (C) 2003      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2009 Regis Houssin        <regis@dolibarr.fr>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * \defgroup   externalsite     Module externalsite
 * \brief      Module to include an external web site/tools into Dolibarr menu and into a frame page.
 * \file       htdocs/core/modules/modExternalSite.class.php
 * \ingroup    externalsite
 * \brief      Description and activation file for module ExternalSite
 */

include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 * 	Description and activation class for module ExternalSite
 */
class modExternalSite extends DolibarrModules
{

    /**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
     */
	function __construct($db)
	{
		parent::__construct($db);

		// Id for module (must be unique).
		// Use here a free id.
		$this->numero = 100;

		// Family can be 'crm','financial','hr','projects','product','technic','other'
		// It is used to sort modules in module setup page
		$this->family = "other";
		// Module label (no space allowed), used if translation string 'ModuleXXXName' not found (where XXX is value of numeric property 'numero' of module)
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description used if translation string 'ModuleXXXDesc' not found (XXX is id value)
		$this->description = "Include any external web site into Dolibarr menus and view it into a Dolibarr frame.";
		// Possible values for version are: 'development', 'experimental', 'dolibarr' or version
		$this->version = 'dolibarr';
		// Key used in llx_const table to save module status enabled/disabled (XXX is id value)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Where to store the module in setup page (0=common,1=interface,2=other)
		$this->special = 1;
		// Name of png file (without png) used for this module
		$this->picto='bookmark';
		// Call to inside lang's file
		$this->langfiles = array("@externalsite");

		// Data directories to create when module is enabled
		$this->dirs = array();

		// Config pages. Put here list of php page names stored in admmin directory used to setup module
		$this->config_page_url = array("externalsite.php@externalsite");

		// Dependencies
		$this->depends = array();		// List of modules id that must be enabled if this module is enabled
		$this->requiredby = array();	// List of modules id to disable if this one is disabled

		// Constants
		$this->const = array();			// List of parameters

		// Boxes
		$this->boxes = array();			// List of boxes
		$r=0;

		// Add here list of php file(s) stored in core/boxes that contains class to show a box.
		// Example:
        //$this->boxes[$r][1] = "myboxa.php";
    	//$r++;
        //$this->boxes[$r][1] = "myboxb.php";
    	//$r++;

		// Permissions
		$this->rights_class = 'externalsite';	// Permission key
		$this->rights = array();		// Permission array used by this module

        // Menus
		//------
		$r=0;

		$this->menu[$r]=array('fk_menu'=>0,
													'type'=>'top',
													'titre'=>'ExternalSites',
													'mainmenu'=>'externalsite',
													'url'=>'/externalsite/frames.php',
													'langs'=>'other',
													'position'=>100,
													'perms'=>'',
													'enabled'=>'$conf->externalsite->enabled',
													'target'=>'',
													'user'=>0
													);
		$r++;

	}

	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
     */
	function init($options='')
  	{
    	$sql = array();

    	return $this->_init($sql,$options);
  	}

    /**
	 *		Function called when module is disabled.
	 *      Remove from database constants, boxes and permissions from Dolibarr database.
	 *		Data directories are not deleted
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
     */
    function remove($options='')
    {
		$sql = array();

		return $this->_remove($sql,$options);
    }

}

?>
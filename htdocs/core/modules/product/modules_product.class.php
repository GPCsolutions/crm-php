<?php
/* Copyright (C) 2003-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2004      Eric Seigne          <eric.seigne@ryxeo.com>
 * Copyright (C) 2005-2012 Regis Houssin        <regis@dolibarr.fr>
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
 * or see http://www.gnu.org/
 */


/**
 *	    \class      ModeleProductCode
 *		\brief  	Parent class for product code generators
 */
abstract class ModeleProductCode
{
    var $error='';

    /**     Renvoi la description par defaut du modele de numerotation
     *
     *		@param	Translate	$langs		Object langs
     *      @return string      			Texte descripif
     */
    function info($langs)
    {
        $langs->load("bills");
        return $langs->trans("NoDescription");
    }

    /**     Renvoi nom module
     *
     *		@param	Translate	$langs		Object langs
     *      @return string      			Nom du module
     */
    function getNom($langs)
    {
        return $this->nom;
    }


    /**     Renvoi un exemple de numerotation
     *
     *		@param	Translate	$langs		Object langs
     *      @return string      			Example
     */
    function getExample($langs)
    {
        $langs->load("bills");
        return $langs->trans("NoExample");
    }

    /**     Test si les numeros deja en vigueur dans la base ne provoquent pas de
     *      de conflits qui empechera cette numerotation de fonctionner.
     *
     *      @return     boolean     false si conflit, true si ok
     */
    function canBeActivated()
    {
        return true;
    }

    /**
     *  Return next value available
     *
     *	@param	Product		$objproduct		Object product
     *	@param	int			$type		Type
     *  @return string      			Value
     */
    function getNextValue($objproduct=0,$type=-1)
    {
        global $langs;
        return $langs->trans("Function_getNextValue_InModuleNotWorking");
    }


    /**     Return version of module
     *
     *      @return     string      Version
     */
    function getVersion()
    {
        global $langs;
        $langs->load("admin");

        if ($this->version == 'development') return $langs->trans("VersionDevelopment");
        if ($this->version == 'experimental') return $langs->trans("VersionExperimental");
        if ($this->version == 'dolibarr') return DOL_VERSION;
        return $langs->trans("NotAvailable");
    }

    /**
     *  Renvoi la liste des modeles de numérotation
     *
     *  @param	DoliDB	$db     			Database handler
     *  @param  string	$maxfilenamelength  Max length of value to show
     *  @return	array						List of numbers
     */
    static function liste_modeles($db,$maxfilenamelength=0)
    {
        $liste=array();
        $sql ="";

        $resql = $db->query($sql);
        if ($resql)
        {
            $num = $db->num_rows($resql);
            $i = 0;
            while ($i < $num)
            {
                $row = $db->fetch_row($resql);
                $liste[$row[0]]=$row[1];
                $i++;
            }
        }
        else
        {
            return -1;
        }
        return $liste;
    }

    /**
     *      Return description of module parameters
     *
     *      @param	Translate	$langs      Output language
     *		@param	Product		$product	Product object
     *		@param	int			$type		-1=Nothing, 0=Customer, 1=Supplier
     *		@return	string					HTML translated description
     */
    function getToolTip($langs,$product,$type)
    {
        global $conf;

        $langs->load("admin");

        $s='';
        if ($type == -1) $s.=$langs->trans("Name").': <b>'.$this->nom.'</b><br>';
        if ($type == -1) $s.=$langs->trans("Version").': <b>'.$this->getVersion().'</b><br>';
        if ($type == 0)  $s.=$langs->trans("ProductCodeDesc").'<br>';
        if ($type == 1)  $s.=$langs->trans("ServiceCodeDesc").'<br>';
        if ($type != -1) $s.=$langs->trans("ValidityControledByModule").': <b>'.$this->getNom($langs).'</b><br>';
        $s.='<br>';
        $s.='<u>'.$langs->trans("ThisIsModuleRules").':</u><br>';
        if ($type == 0)
        {
            $s.=$langs->trans("RequiredIfProduct").': ';
            if (! empty($conf->global->MAIN_COMPANY_CODE_ALWAYS_REQUIRED) && ! empty($this->code_null)) $s.='<strike>';
            $s.=yn(!$this->code_null,1,2);
            if (! empty($conf->global->MAIN_COMPANY_CODE_ALWAYS_REQUIRED) && ! empty($this->code_null)) $s.='</strike> '.yn(1,1,2).' ('.$langs->trans("ForcedToByAModule",$langs->transnoentities("yes")).')';
            $s.='<br>';
        }
        if ($type == 1)
        {
            $s.=$langs->trans("RequiredIfService").': ';
            if (! empty($conf->global->MAIN_COMPANY_CODE_ALWAYS_REQUIRED) && ! empty($this->code_null)) $s.='<strike>';
            $s.=yn(!$this->code_null,1,2);
            if (! empty($conf->global->MAIN_COMPANY_CODE_ALWAYS_REQUIRED) && ! empty($this->code_null)) $s.='</strike> '.yn(1,1,2).' ('.$langs->trans("ForcedToByAModule",$langs->transnoentities("yes")).')';
            $s.='<br>';
        }
        if ($type == -1)
        {
            $s.=$langs->trans("Required").': ';
            if (! empty($conf->global->MAIN_COMPANY_CODE_ALWAYS_REQUIRED) && ! empty($this->code_null)) $s.='<strike>';
            $s.=yn(!$this->code_null,1,2);
            if (! empty($conf->global->MAIN_COMPANY_CODE_ALWAYS_REQUIRED) && ! empty($this->code_null)) $s.='</strike> '.yn(1,1,2).' ('.$langs->trans("ForcedToByAModule",$langs->transnoentities("yes")).')';
            $s.='<br>';
        }
        $s.=$langs->trans("CanBeModifiedIfOk").': ';
        $s.=yn($this->code_modifiable,1,2);
        $s.='<br>';
        $s.=$langs->trans("CanBeModifiedIfKo").': '.yn($this->code_modifiable_invalide,1,2).'<br>';
        $s.=$langs->trans("AutomaticCode").': '.yn($this->code_auto,1,2).'<br>';
        $s.='<br>';
        if ($type == 0 || $type == -1)
        {
            $nextval=$this->getNextValue($product,0);
            if (empty($nextval)) $nextval=$langs->trans("Undefined");
            $s.=$langs->trans("NextValue").($type == -1?' ('.$langs->trans("Product").')':'').': <b>'.$nextval.'</b><br>';
        }
        if ($type == 1 || $type == -1)
        {
            $nextval=$this->getNextValue($product,1);
            if (empty($nextval)) $nextval=$langs->trans("Undefined");
            $s.=$langs->trans("NextValue").($type == -1?' ('.$langs->trans("Service").')':'').': <b>'.$nextval.'</b>';
        }
        return $s;
    }

	/**
	 *   Check if mask/numbering use prefix
	 *
	 *   @return	int		0=no, 1=yes
	 */
    function verif_prefixIsUsed()
    {
        return 0;
    }

}

?>
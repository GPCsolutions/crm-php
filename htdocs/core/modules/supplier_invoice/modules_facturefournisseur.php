<?php
/* Copyright (C) 2010	Juanjo Menent	<jmenent@2byte.es>
 * Copyright (C) 2012	Regis Houssin	<regis@dolibarr.fr>
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
 *		\file       htdocs/core/modules/supplier_invoice/modules_facturefournisseur.php
 *      \ingroup    facture fournisseur
 *      \brief      File that contain parent class for supplier invoices models
 */
require_once DOL_DOCUMENT_ROOT.'/core/class/commondocgenerator.class.php';


/**
 *	Parent class for supplier invoices models
 */
abstract class ModelePDFSuppliersInvoices extends CommonDocGenerator
{
	var $error='';


	/**
	 *  Return list of active generation modules
	 *
     *  @param	DoliDB	$db     			Database handler
     *  @param  string	$maxfilenamelength  Max length of value to show
     *  @return	array						List of numbers
	 */
	static function liste_modeles($db,$maxfilenamelength=0)
	{
		global $conf;

		$type='invoice_supplier';
		$liste=array();

		include_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
		$liste=getListOfModels($db,$type,$maxfilenamelength);

		return $liste;
	}

}

/**
 *	Create a document onto disk according to template module.
 *
 *	@param	    DoliDB		$db  			Database handler
 *	@param	    Object		$object			Object supplier invoice
 *	@param	    string		$modele			Force template to use ('' to not force)
 *	@param		Translate	$outputlangs	Object lang a utiliser pour traduction
 *  @param      int			$hidedetails    Hide details of lines
 *  @param      int			$hidedesc       Hide description
 *  @param      int			$hideref        Hide ref
 *  @return     int         				0 if KO, 1 if OK
 */
function supplier_invoice_pdf_create($db, $object, $modele, $outputlangs, $hidedetails=0, $hidedesc=0, $hideref=0)
{
	global $conf, $user, $langs;

	$langs->load("suppliers");

	$error=0;

	// Increase limit for PDF build
    $err=error_reporting();
    error_reporting(0);
    @set_time_limit(120);
    error_reporting($err);

    $srctemplatepath='';

	// Positionne le modele sur le nom du modele a utiliser
	if (! dol_strlen($modele))
	{
		if (! empty($conf->global->INVOICE_SUPPLIER_ADDON_PDF))
		{
			$modele = $conf->global->INVOICE_SUPPLIER_ADDON_PDF;
		}
		else
		{
		    $modele = 'canelle';
		}
	}

    // If selected modele is a filename template (then $modele="modelname:filename")
	$tmp=explode(':',$modele,2);
    if (! empty($tmp[1]))
    {
        $modele=$tmp[0];
        $srctemplatepath=$tmp[1];
    }

	// Search template files
	$file=''; $classname=''; $filefound=0;
	$dirmodels=array('/');
	if (is_array($conf->modules_parts['models'])) $dirmodels=array_merge($dirmodels,$conf->modules_parts['models']);
	foreach($dirmodels as $reldir)
	{
		foreach(array('doc','pdf') as $prefix)
		{
			$file = $prefix."_".$modele.".modules.php";

			// On verifie l'emplacement du modele
			$file=dol_buildpath($reldir."core/modules/supplier_invoice/pdf/".$file,0);
			if (file_exists($file))
			{
				$filefound=1;
				$classname=$prefix.'_'.$modele;
				break;
			}
		}
		if ($filefound) break;
	}

	// Charge le modele
	if ($filefound)
	{
		require_once $file;

		$obj = new $classname($db,$object);

		// We save charset_output to restore it because write_file can change it if needed for
		// output format that does not support UTF8.
		$sav_charset_output=$outputlangs->charset_output;
		if ($obj->write_file($object, $outputlangs, $srctemplatepath, $hidedetails, $hidedesc) > 0)
		{
			$outputlangs->charset_output=$sav_charset_output;

			// we delete preview files
        	require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
			dol_delete_preview($object);

			// Appel des triggers
			include_once DOL_DOCUMENT_ROOT . '/core/class/interfaces.class.php';
			$interface=new Interfaces($db);
			$result=$interface->run_triggers('SUPPLIER_INVOICE_BUILDDOC',$object,$user,$langs,$conf);
			if ($result < 0) { $error++; $this->errors=$interface->errors; }
			// Fin appel triggers

			return 1;
		}
		else
		{
			$outputlangs->charset_output=$sav_charset_output;
			dol_syslog("Erreur dans supplier_invoice_pdf_create");
			dol_print_error($db,$obj->error);
			return 0;
		}
	}
	else
	{
		print $langs->trans("Error")." ".$langs->trans("ErrorFileDoesNotExists",$file);
		return 0;
	}
}

?>
<?php
/* Copyright (C) 2012	Regis Houssin	<regis@dolibarr.fr>
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
 *  \file       htdocs/product/admin/product_tools.php
 *  \ingroup    product
 *  \brief      Setup page of product module
 */

// TODO We must add a confirmation on button because this will make a mass change
// TODO Should also change table product_price for price levels

require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/product.lib.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

$langs->load("admin");
$langs->load("products");

// Security check
if (! $user->admin) accessforbidden();

$action = GETPOST('action','alpha');
$oldvatrate=GETPOST('oldvatrate');
$newvatrate=GETPOST('newvatrate');
//$price_base_type=GETPOST('price_base_type');

$objectstatic = new Product($db);


/*
 * Actions
 */

if ($action == 'convert')
{
	$error=0;

	if ($oldvatrate == $newvatrate)
	{
		$langs->load("errors");
		setEventMessage($langs->trans("ErrorNewVaueCantMatchOldValue"),'errors');
		$error++;
	}

	if (! $error)
	{
		$db->begin();

		$sql = 'SELECT rowid';
		$sql.= ' FROM '.MAIN_DB_PREFIX.'product';
		$sql.= ' WHERE entity IN ('.getEntity('product',1).')';
		$sql.= " AND tva_tx = '".$db->escape($oldvatrate)."'";
		//$sql.= ' AND price_base_type = "'..'"';
		//print $sql;

		$resql=$db->query($sql);
		if ($resql)
		{
			$num = $db->num_rows($resql);

			$i = 0; $nbrecordsmodified=0;
			while ($i < $num)
			{
				$obj = $db->fetch_object($resql);

				$ret=$objectstatic->fetch($obj->rowid);
				if ($ret > 0)
				{
					$price_base_type = $objectstatic->price_base_type;	// Get price_base_type of product/service to keep the same for update
					if ($price_base_type == 'TTC')
					{
						$newprice=price2num($objectstatic->price_ttc,'MU');    // Second param must be MU (we want a unit price so 'MU'. If unit price was on 4 decimal, we must keep 4 decimals)
						$newminprice=$objectstatic->price_min_ttc;
					}
					else
					{
						$newprice=price2num($objectstatic->price,'MU');    // Second param must be MU (we want a unit price so 'MU'. If unit price was on 4 decimal, we must keep 4 decimals)
						$newminprice=$objectstatic->price_min;
					}
					if ($newminprice > $newprice) $newminprice=$newprice;
					$newvat=str_replace('*','',$newvatrate);
					$newnpr=$objectstatic->recuperableonly;
					$newlevel=0;

					$ret=$objectstatic->updatePrice($objectstatic->id, $newprice, $price_base_type, $user, $newvat, $newminprice, $newlevel, $newnpr);
					if ($ret < 0) $error++;
					else $nbrecordsmodified++;

					// FIXME Now update all price levels. Call $objectstatic->updatePrice( as many times than exisitng price_level

				}

				$i++;
			}

			if (! $error)
			{
				if ($nbrecordsmodified > 0) setEventMessage($langs->trans("RecordsModified",$nbrecordsmodified));
				else setEventMessage($langs->trans("NoRecordFound"),'warnings');
				$db->commit();
			}
			else
			{
				setEventMessage($langs->trans("Error"),'errors');
				$db->rollback();
			}
		}
	}
}

/*
 * View
 */

$title = $langs->trans('ModulesSystemTools');

llxHeader('',$title);

print_fiche_titre($title,'','setup');

print $langs->trans("ProductVatMassChangeDesc").'<br><br>';

$form=new Form($db);
$var=true;

print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="convert" />';

print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Parameters").'</td>'."\n";
print '<td align="right" width="60">'.$langs->trans("Value").'</td>'."\n";
print '</tr>'."\n";

$var=!$var;
print '<tr '.$bc[$var].'>'."\n";
print '<td>'.$langs->trans("OldVATRates").'</td>'."\n";
print '<td width="60" align="right">'."\n";
print $form->load_tva('oldvatrate', $oldvatrate);
print '</td>'."\n";
print '</tr>'."\n";

$var=!$var;
print '<tr '.$bc[$var].'>'."\n";
print '<td>'.$langs->trans("NewVATRates").'</td>'."\n";
print '<td width="60" align="right">'."\n";
print $form->load_tva('newvatrate', $newvatrate);
print '</td>'."\n";
print '</tr>'."\n";

/*
$var=!$var;
print '<tr '.$bc[$var].'>'."\n";
print '<td>'.$langs->trans("PriceBaseTypeToChange").'</td>'."\n";
print '<td width="60" align="right">'."\n";
print $form->load_PriceBaseType($price_base_type);
print '</td>'."\n";
print '</tr>'."\n";
*/

print '</table>';
print '</div>';

// Boutons actions
print '<div class="tabsAction">';
print '<input type="submit" id="convert_vatrate" name="convert_vatrate" value="'.$langs->trans("MassConvert").'" class="button" />';
print '</div>';

print '</form>';


llxFooter();

$db->close();
?>
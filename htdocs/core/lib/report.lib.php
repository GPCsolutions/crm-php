<?php
/* Copyright (C) 2008-2012	Laurent Destailleur	<eldy@users.sourceforge.net>
 * Copyright (C) 2012		Regis Houssin		<regis@dolibarr.fr>
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
 *  \file       	htdocs/core/lib/report.lib.php
 *  \brief      	Set of functions for reporting
 */


/**
*    Show header of a VAT report
*
*    @param		string	$nom            Name of report
*    @param 	string	$variante       Link for alternate report
*    @param 	string	$period         Period of report
*    @param 	string	$periodlink     Link to switch period
*    @param 	string	$description    Description
*    @param 	date	$builddate      Date generation
*    @param 	string	$exportlink     Link for export or ''
*    @param		array	$moreparam		Array with list of params to add into form
*    @return	void
*/
function report_header($nom,$variante,$period,$periodlink,$description,$builddate,$exportlink='',$moreparam=array())
{
	global $langs, $hselected;

	print "\n\n<!-- debut cartouche rapport -->\n";

	$h=0;
	$head[$h][0] = $_SERVER["PHP_SELF"];
	$head[$h][1] = $langs->trans("Report");
	$head[$h][2] = 'report';

	dol_fiche_head($head, $hselected);

	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	foreach($moreparam as $key => $value)
	{
	     print '<input type="hidden" name="'.$key.'" value="'.$value.'">';
	}
	print '<table width="100%" class="border">';

	// Ligne de titre
	print '<tr>';
	print '<td valign="top" width="110">'.$langs->trans("ReportName").'</td>';
	if (! $variante) print '<td colspan="3">';
	else print '<td>';
	print $nom;
	if ($variante) print '</td><td colspan="2">'.$variante;
	print '</td>';
	print '</tr>';

	// Ligne de la periode d'analyse du rapport
	print '<tr>';
	print '<td>'.$langs->trans("ReportPeriod").'</td>';
	if (! $periodlink) print '<td colspan="3">';
	else print '<td>';
	if ($period) print $period;
	if ($periodlink) print '</td><td colspan="2">'.$periodlink;
	print '</td>';
	print '</tr>';

	// Ligne de description
	print '<tr>';
	print '<td valign="top">'.$langs->trans("ReportDescription").'</td>';
	print '<td colspan="3">'.$description.'</td>';
	print '</tr>';

	// Ligne d'export
	print '<tr>';
	print '<td>'.$langs->trans("GeneratedOn").'</td>';
	if (! $exportlink) print '<td colspan="3">';
	else print '<td>';
	print dol_print_date($builddate);
	if ($exportlink) print '</td><td>'.$langs->trans("Export").'</td><td>'.$exportlink;
	print '</td></tr>';

	print '<tr>';
	print '<td colspan="4" align="center"><input type="submit" class="button" name="submit" value="'.$langs->trans("Refresh").'"></td>';
	print '</tr>';

	print '</table>';

	print '</form>';

	print '</div>';
	print "\n<!-- fin cartouche rapport -->\n\n";
}

?>
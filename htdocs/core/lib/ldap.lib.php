<?php
/* Copyright (C) 2006 Laurent Destailleur  <eldy@users.sourceforge.net>
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
 * \file       htdocs/core/lib/ldap.lib.php
 * \brief      Ensemble de fonctions de base pour le module LDAP
 * \ingroup    ldap
 */

/**
 * Initialize the array of tabs for customer invoice
 *
 * @return	array					Array of head tabs
 */
function ldap_prepare_head()
{
	global $langs, $conf, $user;
	$langs->load("ldap");

	// Onglets
	$head=array();
	$h = 0;

	$head[$h][0] = DOL_URL_ROOT."/admin/ldap.php";
	$head[$h][1] = $langs->trans("LDAPGlobalParameters");
	$head[$h][2] = 'ldap';
	$h++;

	if (! empty($conf->global->LDAP_SYNCHRO_ACTIVE))
	{
		$head[$h][0] = DOL_URL_ROOT."/admin/ldap_users.php";
		$head[$h][1] = $langs->trans("LDAPUsersSynchro");
		$head[$h][2] = 'users';
		$h++;
	}

	if (! empty($conf->global->LDAP_SYNCHRO_ACTIVE))
	{
		$head[$h][0] = DOL_URL_ROOT."/admin/ldap_groups.php";
		$head[$h][1] = $langs->trans("LDAPGroupsSynchro");
		$head[$h][2] = 'groups';
		$h++;
	}

	if (! empty($conf->societe->enabled) && ! empty($conf->global->LDAP_CONTACT_ACTIVE))
	{
		$head[$h][0] = DOL_URL_ROOT."/admin/ldap_contacts.php";
		$head[$h][1] = $langs->trans("LDAPContactsSynchro");
		$head[$h][2] = 'contacts';
		$h++;
	}

	if (! empty($conf->adherent->enabled) && ! empty($conf->global->LDAP_MEMBER_ACTIVE))
	{
		$head[$h][0] = DOL_URL_ROOT."/admin/ldap_members.php";
		$head[$h][1] = $langs->trans("LDAPMembersSynchro");
		$head[$h][2] = 'members';
		$h++;
	}

	return $head;
}


/**
 *  Show button test LDAP synchro
 *
 *  @param	string	$butlabel		Label
 *  @param	string	$testlabel		Label
 *  @param	string	$key			Key
 *  @param	string	$dn				Dn
 *  @param	string	$objectclass	Class
 *  @return	void
 */
function show_ldap_test_button($butlabel,$testlabel,$key,$dn,$objectclass)
{
	global $langs, $conf, $user;
	//print 'key='.$key.' dn='.$dn.' objectclass='.$objectclass;

	print '<br>';
	if (! function_exists("ldap_connect"))
	{
		print '<a class="butActionRefused" href="#" title="'.$langs->trans('LDAPFunctionsNotAvailableOnPHP').'">'.$butlabel.'</a>';
	}
	else if (empty($conf->global->LDAP_SERVER_HOST))
	{
		print '<a class="butActionRefused" href="#" title="'.$langs->trans('LDAPSetupNotComplete').'">'.$butlabel.'</a>';
	}
	else if (empty($key) || empty($dn) || empty($objectclass))
	{
		$langs->load("errors");
		print '<a class="butActionRefused" href="#" title="'.$langs->trans('ErrorLDAPSetupNotComplete').'">'.$butlabel.'</a>';
	}
	else
	{
		print '<a class="butAction" href="'.$_SERVER["PHP_SELF"].'?action='.$testlabel.'">'.$butlabel.'</a>';
	}
	print '<br><br>';
}


/**
 * Show a LDAP array into an HTML output array.
 *
 * @param	string	$result	    Array to show. This array is already encoded into charset_output
 * @param   int		$level		Level
 * @param   int		$count		Count
 * @param   string	$var		Var
 * @param   int		$hide		Hide
 * @param   int		$subcount	Subcount
 * @return  int
 */
function show_ldap_content($result,$level,$count,$var,$hide=0,$subcount=0)
{
	global $bc, $conf;

	$count--;
	if ($count == 0) return -1;	// To stop loop
	if (! is_array($result)) return -1;

	foreach($result as $key => $val)
	{
		if ("$key" == "objectclass") continue;
		if ("$key" == "count") continue;
		if ("$key" == "dn") continue;
		if ("$val" == "objectclass") continue;

		$lastkey[$level]=$key;

		if (is_array($val))
		{
			$hide=0;
			if (! is_numeric($key))
			{
				$var=!$var;
				print '<tr '.$bc[$var].' valign="top">';
				print '<td>';
				print $key;
				print '</td><td>';
				if (strtolower($key) == 'userpassword') $hide=1;
			}
			show_ldap_content($val,$level+1,$count,$var,$hide,$val["count"]);
		}
		else if ($subcount)
		{
			$subcount--;
			$newstring=dol_htmlentitiesbr($val);
			if ($hide) print preg_replace('/./i','*',$newstring);
			else print $newstring;
			print '<br>';
		}
		if ("$val" != $lastkey[$level] && !$subcount) print '</td></tr>';
	}
	return 1;
}

?>
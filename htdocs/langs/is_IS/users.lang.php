<?php
/* Copyright (C) 2012	Regis Houssin	<regis.houssin@capnetworks.com>
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

$users = array(
		'CHARSET' => 'UTF-8',
		'UserCard' => 'Notandi kort',
		'ContactCard' => 'Hafðu kort',
		'GroupCard' => 'Group kort',
		'NoContactCard' => 'Engin kort meðal tengiliðir',
		'Permission' => 'Heimild',
		'Permissions' => 'Heimildir',
		'EditPassword' => 'Breyta lykilorði',
		'SendNewPassword' => 'Endurfæða og senda lykilorð',
		'ReinitPassword' => 'Endurfæða lykilorð',
		'PasswordChangedTo' => 'Lykilorð breytt í: %s',
		'SubjectNewPassword' => 'Nýja lykilorðið fyrir Dolibarr',
		'AvailableRights' => 'Laus leyfi',
		'OwnedRights' => 'Eigandi heimildir',
		'GroupRights' => 'Group heimildir',
		'UserRights' => 'Notandi heimildir',
		'UserGUISetup' => 'Notandi sýna skipulag',
		'DisableUser' => 'Slökkva',
		'DisableAUser' => 'Slökkva notanda',
		'DeleteUser' => 'Eyða',
		'DeleteAUser' => 'Eyða notanda',
		'DisableGroup' => 'Slökkva',
		'DisableAGroup' => 'Slökkva á hóp',
		'EnableAUser' => 'Virkja notanda',
		'EnableAGroup' => 'Virkja hóp',
		'DeleteGroup' => 'Eyða',
		'DeleteAGroup' => 'Eyða hópi',
		'ConfirmDisableUser' => 'Ertu viss um að þú viljir gera <b>notanda %s ?</b>',
		'ConfirmDisableGroup' => 'Ertu viss um að þú viljir gera <b>hóp %s ?</b>',
		'ConfirmDeleteUser' => 'Ertu viss um að þú viljir eyða <b>notanda %s ?</b>',
		'ConfirmDeleteGroup' => 'Ertu viss um að þú viljir eyða <b>hópnum %s ?</b>',
		'ConfirmEnableUser' => 'Ertu viss um að þú viljir gera <b>notanda %s ?</b>',
		'ConfirmEnableGroup' => 'Ertu viss um að þú viljir gera <b>hóp %s ?</b>',
		'ConfirmReinitPassword' => 'Ertu viss um að þú viljir búa til nýtt lykilorð fyrir <b>notandann %s ?</b>',
		'ConfirmSendNewPassword' => 'Ertu viss um að þú viljir búa til og senda nýtt lykilorð fyrir <b>notandann %s ?</b>',
		'NewUser' => 'Nýr notandi',
		'CreateUser' => 'Búa til notanda',
		'SearchAGroup' => 'Leita hóp',
		'SearchAUser' => 'Leita notanda',
		'LoginNotDefined' => 'Innskráning er ekki skilgreind.',
		'NameNotDefined' => 'Nafnið er ekki skilgreind.',
		'ListOfUsers' => 'Notendalisti',
		'Administrator' => 'Stjórnandi',
		'SuperAdministrator' => 'Super Administrator',
		'SuperAdministratorDesc' => 'Stjórnandi með öllum réttindum',
		'AdministratorDesc' => 'Stjórnandi aðila',
		'DefaultRights' => 'Default heimildir',
		'DefaultRightsDesc' => 'Veldu hér <u>sjálfgefið</u> leyfi sem eru sjálfkrafa veitt <u>ný búin</u> notandi (Fara á kortið notandi til breytinga á leyfi núverandi notenda).',
		'DolibarrUsers' => 'Dolibarr notendur',
		'LastName' => 'Nafn',
		'FirstName' => 'Fornafn',
		'ListOfGroups' => 'Listi yfir alla hópa',
		'NewGroup' => 'Nýr hópur',
		'CreateGroup' => 'Búa til hóp',
		'RemoveFromGroup' => 'Fjarlægja úr hópi',
		'PasswordChangedAndSentTo' => 'Lykilorð breyst og sendur <b>til %s .</b>',
		'PasswordChangeRequestSent' => 'Beiðni um að breyta lykilorðinu <b>fyrir %s </b> sent <b>til %s .</b>',
		'MenuUsersAndGroups' => 'Notendur & Groups',
		'LastGroupsCreated' => 'Last %s  búinn til hópa',
		'LastUsersCreated' => 'Last %s  notendur skapa',
		'ShowGroup' => 'Sýna hópur',
		'ShowUser' => 'Sýna notanda',
		'NonAffectedUsers' => 'Non áhrif notendur',
		'UserModified' => 'Notandi breytt hefur verið',
		'GroupModified' => 'Group breytt hefur verið',
		'PhotoFile' => 'Photo skrá',
		'UserWithDolibarrAccess' => 'Notandi með Dolibarr aðgang',
		'ListOfUsersInGroup' => 'Notendalisti í þessum hópi',
		'ListOfGroupsForUser' => 'Listi yfir alla hópa fyrir þennan notanda',
		'UsersToAdd' => 'Notendur að bæta við þennan hóp',
		'GroupsToAdd' => 'Hópar til að bæta við þessa notanda',
		'NoLogin' => 'Engin tenging',
		'LinkToCompanyContact' => 'Hlekkur til þriðja aðila / samband',
		'LinkedToDolibarrMember' => 'Tengill á meðlimur',
		'LinkedToDolibarrUser' => 'Tengill á Dolibarr notanda',
		'LinkedToDolibarrThirdParty' => 'Tengill á Dolibarr þriðja aðila',
		'CreateDolibarrLogin' => 'Búa til notanda',
		'CreateDolibarrThirdParty' => 'Búa til þriðja aðila',
		'LoginAccountDisable' => 'Reikningur óvirkur, setja nýja tenging til að virkja hana.',
		'LoginAccountDisableInDolibarr' => 'Reikningur óvirkur í Dolibarr.',
		'LoginAccountDisableInLdap' => 'Reikningur gerður óvirkur á léninu.',
		'UsePersonalValue' => 'Nota persónulega gildi',
		'GuiLanguage' => 'Viðmótstungumál',
		'InternalUser' => 'Innri notandi',
		'MyInformations' => 'gögn mín',
		'ExportDataset_user_1' => 'notendur Dolibarr og eignir',
		'DomainUser' => 'Lén notanda %s',
		'Reactivate' => 'Endurvekja',
		'CreateInternalUserDesc' => 'Þetta form gerir þér kleift að creat notanda innri fyrirtæki þitt / grunni. Til creat ytri notanda (viðskiptavinur, birgir, ...), nota hnappinn \'Stofna Dolibarr notandi\' af kort samband þriðja aðila.',
		'InternalExternalDesc' => '<b>Innri</b> notandi er notandi sem er hluti af þínu fyrirtæki / stofnun. <br> <b>Ytri</b> notandi er a viðskiptavinur, birgir eða öðrum. <br><br> Í báðum tilfellum, leyfi skilgreinir réttindi á Dolibarr, einnig ytri notendur geta haft mismunandi matseðill framkvæmdastjóri en innri notanda (Sjá Heim - Skipulag - Skoða)',
		'PermissionInheritedFromAGroup' => 'Heimild veitt vegna þess að arfur frá einni í hópnum notanda.',
		'Inherited' => 'Arf',
		'UserWillBeInternalUser' => 'Búið notandi vilja vera innri notanda (vegna þess að ekki tengd við ákveðna þriðja aðila)',
		'UserWillBeExternalUser' => 'Búið notandi vilja vera ytri notandi (vegna þess að tengjast ákveðnum þriðja aðila)',
		'IdPhoneCaller' => 'Auðkenni sími sem hringir',
		'UserLogged' => 'User %s  tengdur',
		'UserLogoff' => 'Notandi %s Útskráning',
		'NewUserCreated' => 'User %s  búinn til',
		'NewUserPassword' => 'Lykilorð breyta fyrir %s',
		'EventUserModified' => 'User %s  breytt',
		'UserDisabled' => 'User %s  fatlaðra',
		'UserEnabled' => 'User %s  virkjaður',
		'UserDeleted' => 'User %s  eytt',
		'NewGroupCreated' => 'Group %s  búinn til',
		'GroupModified' => 'Group breytt hefur verið',
		'GroupDeleted' => 'Group %s  eytt',
		'ConfirmCreateContact' => 'Ertu viss um að þú viljir búa til Dolibarr reikning fyrir þennan tengilið?',
		'ConfirmCreateLogin' => 'Ertu viss um að þú viljir búa til Dolibarr reikning fyrir þennan notanda?',
		'ConfirmCreateThirdParty' => 'Ertu viss um að þú viljir búa til þriðja aðila fyrir þennan notanda?',
		'LoginToCreate' => 'Innskráning til að búa til',
		'NameToCreate' => 'Nafn þriðja aðila til að stofna',
		'YourRole' => 'hlutverk þín',
		'YourQuotaOfUsersIsReached' => 'kvóta þinn af virkum notendum er náð!',
		'NbOfUsers' => 'Nb notendur',
		'DontDowngradeSuperAdmin' => 'Aðeins superadmin getur lækkunar a superadmin',
		'NewDatabase' => 'Nouvelle base de données',
		'CreateDatabase' => 'Créer la base de données',
		'ListOfDatabases' => 'Liste des bases de données',
		'ListOfUsersInDatabase' => 'Liste des utilisateurs liés à la base de données',
		'ListOfRolesInDatabase' => 'Liste des groupes liés à la base de données',
		'DeleteADatabase' => 'Suppression d\'une database',
		'ConfirmDatabase' => 'Êtes-vous sûr de vouloir supprimer la base de données <b>%s</b> ?',
		'NonAffectedGroupsDatabase' => 'Groupes non affectés à la base de données',
		'NonAffectedUsersDatabase' => 'Utilisateurs non affectés à la base de données',
		'Collaborators' => 'Collaborateurs',
		'Profiles' => 'Profils collaborateurs'
);
?>
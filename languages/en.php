<?php
/**
 * Elgg Alumni english language translation
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

$english = array(
	// General/Built In

	// Menus
	'admin:users:alumni' => 'Alumni',

	// Admin Settings
	'alumni:admin:role' => 'Alumni Role',
	'alumni:admin:general' => 'General Settings',
	'alumni:admin:googleauth' => 'Google Authorization',
	'alumni:admin:googleauthdesc' => 'In order to modify user information the following admin user:<br /><br />  %s  <br /><br />must update their authorization to the Google Spot app to include the admin SDK/directory scopes.',
	'alumni:admin:updateauth' => 'Update Google Authorization',

	// Error messages
	'alumni:error:nogoogleadmin' => 'Notice: there is no google admin account set for the alumni plugin!',
	'alumni:error:alumniset' => 'There was an error setting this user as an alumni: %s',
	'alumni:error:alumniremove' => 'There was an error removing this from alumni: %s',

	// Success messages
	'alumni:success:alumniset' => 'User Google Account has been updated',
	'alumni:success:alumniremove' => 'User Google Account has been reverted',

	// General labels
	'alumni:label:alumniusers' => 'Alumni Users',
	'alumni:label:noresults' => 'No results',
	'alumni:label:makealumni' => 'Make Alumni',
	'alumni:label:removealumni' => 'Remove Alumni',

	// Notifications

	// River
);

add_translation('en',$english);

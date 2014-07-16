<?php
/**
 * Elgg Alumni admin settings
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

// Get plugin settings
$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');

// If we don't have an admin username, try to pull it from the googleapps plugin
if (!$google_admin_username) {	
	$google_admin_username = elgg_get_plugin_setting('google_admin_username', 'googleapps');
}

// Get site roles
$roles = get_roles(0);
$roles_options = array();

foreach($roles as $role) {
	$roles_options[$role->guid] = $role->title;
}

// Label/Inputs
$alumni_role_label = elgg_echo('alumni:admin:role');
$alumni_role_input = elgg_view('input/dropdown', array(
	'name' => 'params[alumni_role]',
	'options_values' => $roles_options,
	'value' => $alumni_role,
));

// General module
$general_title = elgg_echo('alumni:admin:general');

$general_body = <<<HTML
	<div>
		<label>$alumni_role_label</label><br />
		$alumni_role_input
	</div><br />
HTML;

echo elgg_view_module('inline', $general_title, $general_body);

$google_auth_title = elgg_echo('alumni:admin:googleauth');
$google_auth_desc = elgg_echo('alumni:admin:googleauthdesc', array(strtoupper(elgg_get_plugin_setting('google_admin_username', 'googleapps'))));
$google_auth_form = elgg_view('forms/alumni/directory_auth');

$google_auth_body = <<<HTML
	<div>
		<label>$google_auth_desc</label>
	</div><br />
	$google_auth_form
HTML;

echo elgg_view_module('inline', $google_auth_title, $google_auth_body);



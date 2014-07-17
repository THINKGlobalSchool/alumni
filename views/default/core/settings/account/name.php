<?php
/**
 * Elgg Alumni user settings name override
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

$user = elgg_get_page_owner_entity();

$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');

if ($user) {
	$title = elgg_echo('user:name:label');
	$content = elgg_echo('name') . ': ';

	$input_options = array(
		'name' => 'name',
		'value' => $user->name,
	);

	if (!elgg_is_admin_logged_in() && roles_is_member($alumni_role, $user->guid)) {
		$input_options['DISABLED'] = 'DISABLED';
	}

	$content .= elgg_view('input/text', $input_options);
	echo elgg_view_module('info', $title, $content);

	// need the user's guid to make sure the correct user gets updated
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
}

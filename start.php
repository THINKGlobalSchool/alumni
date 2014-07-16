<?php
/**
 * Elgg Alumni Plugin start.php
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

elgg_register_event_handler('init','system','alumni_init');

/**
 * Init
 */
function alumni_init() {
	// Register/load library
	elgg_register_library('elgg:alumni', elgg_get_plugins_path() . 'alumni/lib/alumni.php');
	elgg_load_library('elgg:alumni');

	// Pagesetup event handler
	elgg_register_event_handler('pagesetup', 'system', 'alumni_pagesetup');

	// Handle users removed from alumni role
	elgg_register_event_handler('add','role','alumni_add_user_event_listener', 600);
	
	// Handle users added to alumni role
	elgg_register_event_handler('remove','role','alumni_remove_user_event_listener', 600);	

	// Extend hover menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'alumni_user_hover_menu_setup');

	// Actions
	$action_base = elgg_get_plugins_path() . "alumni/actions/alumni";
	elgg_register_action('alumni/directory_auth', "$action_base/directory_auth.php", 'admin');
}

/**	
 * Pagesetup event handler
 * 
 * @return NULL
 */
function alumni_pagesetup() {
	// Admin items
	if (elgg_in_context('admin')) {
		elgg_register_admin_menu_item('administer', 'alumni', 'users');
	}
}

/**
 * Listens to a role add event and adds a user to the roles's ACL
 */
function alumni_add_user_event_listener($event, $object_type, $object) {
	$role = $object['role'];
	$user = $object['user'];

	$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');

	// Check if we're assiging this user to the alumni role
	if ($alumni_role == $role->guid) {
		if (alumni_set($user)) {
			system_message(elgg_echo('alumni:success:alumniset'));
		}
	}
	
	return TRUE;	
}

/**
 * Listens to a role remove event and removes a user from the todo's access control
 */
function alumni_remove_user_event_listener($event, $object_type, $object) {
	$role = $object['role'];
	$user = $object['user'];

	$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');

	// Check if we're removing this user to the alumni role
	if ($alumni_role == $role->guid) {
		if (alumni_remove($user)) {
			system_message(elgg_echo('alumni:success:alumniremove'));
		}
	}
	return TRUE;
}

/**
 * Extend the user hover menu
 */
function alumni_user_hover_menu_setup($hook, $type, $return, $params) {
	$user = $params['entity'];
	$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');
	
	if (roles_is_member($alumni_role, $user->guid)) {
		$options = array(
			'name' => 'remove_alumni_role_' . $alumni_role,
			'text' => elgg_echo('alumni:label:removealumni'),
			'href' => elgg_add_action_tokens_to_url("action/roles/removeuser?user_guid={$user->guid}&role_guid={$alumni_role}"),
			'section' => 'admin',
		);
		$return[] = ElggMenuItem::factory($options);
	} else {
		$options = array(
			'name' => 'add_alumni_role_' . $alumni_role,
			'text' => elgg_echo('alumni:label:makealumni'),
			'href' => elgg_add_action_tokens_to_url("action/roles/adduser?members[]={$user->guid}&role_guid={$alumni_role}"),
			'section' => 'admin',
		);
		$return[] = ElggMenuItem::factory($options);
	}
	
	return $return;
}

<?php
/**
 * Elgg Alumni admin management
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

// Alumni list module
$alumni_title = elgg_echo('alumni:label:alumniusers');

$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');

$alumni_users = elgg_list_entities_from_relationship(array(
	'relationship' => ROLE_RELATIONSHIP,
	'relationship_guid' => $alumni_role,
	'inverse_relationship' => TRUE,
	'types' => 'user',
	'limit' => 15,
	'pagination' => TRUE
));

if (!$alumni_users) {
	$alumni_users = elgg_echo('alumni:label:noresults');
}

$alumni_module = elgg_view_module('inline', $alumni_title, $alumni_users);

echo $alumni_module;
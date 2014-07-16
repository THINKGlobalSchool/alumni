<?php
/**
 * Elgg Alumni directory auth form
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

$user = elgg_get_logged_in_user_entity();
$admin_user = elgg_get_plugin_setting('google_admin_username', 'googleapps');

if ($user->username = $admin_user) {
	echo elgg_view('input/button', array(
		'value' => elgg_echo('alumni:admin:updateauth'),
		'id' => 'alumni-auth-update'
	));

	$action_url = elgg_add_action_tokens_to_url(elgg_normalize_url('action/alumni/directory_auth'));

	$script = <<<JAVASCRIPT
		<script type='text/javascript'>
			$(document).ready(function() {
				$('#alumni-auth-update').click(function(event) {
					window.location.href = '$action_url';
				});
			});
		</script>
JAVASCRIPT;

	echo $script;
}

<?php
/**
 * Elgg Alumni user icon extension
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

$alumni_role = elgg_get_plugin_setting('alumni_role', 'alumni');
$user = elgg_extract('entity', $vars, elgg_get_logged_in_user_entity());

if (roles_is_member($alumni_role, $user->guid)) {

	$url = $user->getURL();
	$img_url = elgg_normalize_url('mod/alumni/graphics');

	$css = <<<CSS
		<style type='text/css'>
			.elgg-avatar a[href="$url"] img {

			}

			.elgg-avatar.elgg-avatar-large a[href="$url"]:before, 
			.elgg-avatar.elgg-avatar-medium a[href="$url"]:before {
				position: absolute;
				content: '';
				display: block;
				background-position: 1px 1px;
				box-shadow: 0px 0px 5px #000;
			}

			.elgg-avatar.elgg-avatar-large a[href="$url"]:before {
				background: url("$img_url/alumni30px.jpg") no-repeat scroll #FFFFFF;
				width: 30px; /* image width */
				height: 30px; /* image height */
				top: 5px;
				right: 6px;
			}

			.elgg-avatar.elgg-avatar-medium a[href="$url"]:before {
				background: url("$img_url/alumni20px.jpg") no-repeat scroll #FFFFFF;
				width: 15px; /* image width */
				height: 15px; /* image height */
				background-size: 15px 15px;
				top: 3px;
				right: 4px;
			}

		</style>
CSS;
	echo $css;
}
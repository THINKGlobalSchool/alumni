<?php
/**
 * Elgg Alumni directory auth update action
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

$state = md5(rand());

// Almost identical to login, but set a seperate session var to enable connecting
_elgg_services()->session->set('google_connect_account', TRUE);
_elgg_services()->session->set('google_login_state', $state);
_elgg_services()->session->set('google_connect_alt_forward', elgg_normalize_url('admin/plugin_settings/alumni'));

$client = googleapps_get_client();
$client->addScope("https://www.googleapis.com/auth/admin.directory.user");
$client->addScope("https://www.googleapis.com/auth/admin.directory.user.readonly");
$client->setState($state);

$authUrl = $client->createAuthUrl();

forward($authUrl);
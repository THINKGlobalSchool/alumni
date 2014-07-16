<?php
/**
 * Elgg Alumni Plugin helper lib
 *
 * @package alumni
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.org
 */

// @TODO document

define('ALUMNI_DOMAIN', 'alumni.thinkglobalschool.com');
define('ALUMNI_DEFAULT_DOMAIN', 'thinkglobalschool.com');

function alumni_get_new_aliases() {
	return array(
		'alumni.thinkglobalschool.org',
		'alumni.tgs.org'
	);
}

function alumni_set($user) {
	if (!elgg_instanceof($user, 'user')) {
		return FALSE;
	}

	elgg_load_library('gapc:Client');
	elgg_load_library('gapc:Directory');

	$client = googleapps_get_client();
	$access_token = googleapps_get_admin_tokens();

	$client->setAccessToken($access_token);

	$service = new Google_Service_Directory($client);

	try {
		$user_resource = $service->users->get($user->email);
	} catch (Exception $e) {
		register_error(elgg_echo('alumni:error:alumniset', array($e->getMessage())));
		return FALSE;
	}

	$user_id = $user_resource->getId();

	$username = substr($user_resource->getPrimaryEmail(), 0, strpos($user_resource->getPrimaryEmail(), '@'));

	$email_update_data = array(
		'primaryEmail' => "{$username}@" . ALUMNI_DOMAIN
	);

	try {
		$service->users->update($user_id, $email_update_data);

		$service->users_aliases->delete($user_id, "{$username}@" . ALUMNI_DEFAULT_DOMAIN);

		foreach (alumni_get_new_aliases() as $alias) {
			$new_alias = new Google_Service_Directory_Alias();
			$new_alias->setAlias("{$username}@{$alias}");
			$service->users_aliases->insert($user_id, $new_alias);
		}

		$user->email = $email_update_data['primaryEmail'];
		$user->save();
	} catch (Exception $e) {
		register_error(elgg_echo('alumni:error:alumniset', array($e->getMessage())));
		return FALSE;
	}

	return TRUE;
}

function alumni_remove($user) {
	if (!elgg_instanceof($user, 'user')) {
		return FALSE;
	}

	elgg_load_library('gapc:Client');
	elgg_load_library('gapc:Directory');

	$client = googleapps_get_client();
	$access_token = googleapps_get_admin_tokens();

	$client->setAccessToken($access_token);

	$service = new Google_Service_Directory($client);

	try {
		$user_resource = $service->users->get($user->email);
	} catch (Exception $e) {
		register_error(elgg_echo('alumni:error:alumniset', array($e->getMessage())));
		return FALSE;
	}

	$user_id = $user_resource->getId();

	$username = substr($user_resource->getPrimaryEmail(), 0, strpos($user_resource->getPrimaryEmail(), '@'));

	$email_update_data = array(
		'primaryEmail' => "{$username}@" . ALUMNI_DEFAULT_DOMAIN
	);

	try {
		$service->users->update($user_id, $email_update_data);
		
		$service->users_aliases->delete($user_id, "{$username}@" . ALUMNI_DOMAIN);

		foreach (alumni_get_new_aliases() as $alias) {
			$service->users_aliases->delete($user_id, "{$username}@{$alias}");
		}
		
		$user->email = $email_update_data['primaryEmail'];
		$user->save();
	} catch (Exception $e) {
		register_error(elgg_echo('alumni:error:alumniset', array($e->getMessage())));
		return FALSE;
	}

	return TRUE;
}
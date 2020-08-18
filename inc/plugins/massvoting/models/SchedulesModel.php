<?php
namespace Plugins\MassVoting;

// Disable direct access
if (!defined('APP_VERSION'))
    die("Yo, what's up?");

/**
 * Schedules model
 *
 * @version 1.5
 * @author Nextpost.tech (https://nextpost.tech)
 *
 */
class SchedulesModel extends \DataList
{
	/**
	 * Initialize
	 */
	public function __construct()
	{
		$this->setQuery(\DB::table(TABLE_PREFIX."hypervote_schedule"));
	}
}

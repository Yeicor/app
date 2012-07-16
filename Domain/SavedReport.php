<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class SavedReport
{
	/**
	 * @var string
	 */
	private $reportName;
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var Report_Usage
	 */
	private $usage;
	/**
	 * @var Report_ResultSelection
	 */
	private $selection;
	/**
	 * @var Report_GroupBy
	 */
	private $groupBy;

	/**
	 * @var Report_Range
	 */
	private $range;

	/**
	 * @var Report_Filter
	 */
	private $filter;

	/**
	 * @var Date
	 */
	private $dateCreated;

	public function __construct($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$this->reportName = $reportName;
		$this->userId = $userId;
		$this->usage = $usage;
		$this->selection = $selection;
		$this->groupBy = $groupBy;
		$this->range = $range;
		$this->filter = $filter;
		$this->dateCreated = Date::Now();
	}

	/**
	 * @return Date
	 */
	public function DateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @return Report_Usage
	 */
	public function Usage()
	{
		return $this->usage;
	}

	/**
	 * @return Report_ResultSelection
	 */
	public function Selection()
	{
		return $this->selection;
	}

	/**
	 * @return Report_GroupBy
	 */
	public function GroupBy()
	{
		return $this->groupBy;
	}

	/**
	 * @return Report_Range
	 */
	public function Range()
	{
		return $this->range;
	}

	/**
	 * @return Date
	 */
	public function RangeStart()
	{
		return $this->range->Start();
	}

	/**
	 * @return Date
	 */
	public function RangeEnd()
	{
		return $this->range->End();
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->filter->ResourceId();
	}

	/**
	 * @return int|null
	 */
	public function ScheduleId()
	{
		return $this->filter->ScheduleId();
	}

	/**
	 * @return int|null
	 */
	public function UserId()
	{
		return $this->filter->UserId();
	}

	/**
	 * @return int|null
	 */
	public function GroupId()
	{
		return $this->filter->GroupId();
	}

	/**
	 * @return int|null
	 */
	public function AccessoryId()
	{
		return $this->filter->AccessoryId();
	}

	/**
	 * @return string
	 */
	public function ReportName()
	{
		return $this->reportName;
	}

	/**
	 * @return int
	 */
	public function OwnerId()
	{
		return $this->userId;
	}

	/**
	 * @param Date $date
	 */
	public function WithDateCreated(Date $date)
	{
		$this->dateCreated = $date;
	}

	/**
	 * @param int $reportId
	 */
	public function WithId($reportId)
	{
		$this->reportId = $reportId;
	}

	/**
	 * @static
	 * @param string $reportName
	 * @param int $userId
	 * @param Date $dateCreated
	 * @param string $serialized
	 * @param int $reportId
	 * @return SavedReport
	 */
	public static function FromDatabase($reportName, $userId, Date $dateCreated, $serialized, $reportId)
	{
		$savedReport = ReportSerializer::Deserialize($reportName, $userId, $serialized);
		$savedReport->WithDateCreated($dateCreated);
		$savedReport->WithId($reportId);
		return $savedReport;
	}
}

class ReportSerializer
{
	/**
	 * @static
	 * @param SavedReport $report
	 * @return string
	 */
	public static function Serialize(SavedReport $report)
	{
		$template = 'usage=%s;selection=%s;groupby=%s;range=%s;range_start=%s;range_end=%s;resourceid=%s;scheduleid=%s;userid=%s;groupid=%s;accessoryid=%s';

		return sprintf($template,
			$report->Usage(),
			$report->Selection(),
			$report->GroupBy(),
			$report->Range(),
			$report->RangeStart()->ToDatabase(),
			$report->RangeEnd()->ToDatabase(),
			$report->ResourceId(),
			$report->ScheduleId(),
			$report->UserId(),
			$report->GroupId(),
			$report->AccessoryId());
	}

	/**
	 * @static
	 * @param string $reportName
	 * @param int $userId
	 * @param string $serialized
	 * @return SavedReport
	 */
	public static function Deserialize($reportName, $userId, $serialized)
	{
		$values = array();
		$pairs = explode(';', $serialized);
		foreach ($pairs as $pair)
		{
			$keyValue = explode('=', $pair);

			$values[$keyValue[0]] = $keyValue[1];
		}

		return new SavedReport($reportName, $userId, self::GetUsage($values), self::GetSelection($values), self::GetGroupBy($values), self::GetRange($values), self::GetFilter($values));
	}

	/**
	 * @static
	 * @param array $values
	 * @return Report_Usage
	 */
	private static function GetUsage($values)
	{
		if (array_key_exists('usage', $values))
		{
			return new Report_Usage($values['usage']);
		}
		else
		{
			return new Report_Usage(Report_Usage::RESOURCES);
		}
	}

	/**
	 * @static
	 * @param array $values
	 * @return Report_ResultSelection
	 */
	private static function GetSelection($values)
	{
		if (array_key_exists('selection', $values))
		{
			return new Report_ResultSelection($values['selection']);
		}
		else
		{
			return new Report_ResultSelection(Report_ResultSelection::FULL_LIST);
		}
	}

	/**
	 * @static
	 * @param array $values
	 * @return Report_GroupBy
	 */
	private static function GetGroupBy($values)
	{
		if (array_key_exists('groupby', $values))
		{
			return new Report_GroupBy($values['groupby']);
		}
		else
		{
			return new Report_GroupBy(Report_GroupBy::NONE);
		}
	}

	/**
	 * @static
	 * @param array $values
	 * @return Report_Range
	 */
	private static function GetRange($values)
	{
		if (array_key_exists('range', $values))
		{
			$start = $values['range_start'];
			$end = $values['range_end'];

			$startDate = empty($start) ? Date::Min() : Date::FromDatabase($start);
			$endDate = empty($end) ? Date::Max() : Date::FromDatabase($end);

			return new Report_Range($values['range'], $startDate, $endDate);
		}
		else
		{
			return Report_Range::AllTime();
		}
	}

	/**
	 * @static
	 * @param array $values
	 * @return Report_Filter
	 */
	private static function GetFilter($values)
	{
		$resourceId = $values['resourceid'];
		$scheduleId = $values['scheduleid'];
		$userId = $values['userid'];
		$groupId = $values['groupid'];
		$accessoryId = $values['accessoryid'];

		return new Report_Filter($resourceId, $scheduleId, $userId, $groupId, $accessoryId);
	}
}

?>
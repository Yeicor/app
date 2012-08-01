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

class CannedReportTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testGetsHighestCountResourcesAllTime()
	{
		$report = new CannedReport(CannedReport::RESOURCE_COUNT_ALLTIME, $this->fakeUser);
		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectCount()
				->OfResources()
				->GroupByResource();

		$this->assertEquals($expected, $builder);
	}

	public function testGetsHighestCountResourcesThisWeek()
	{
		$report = new CannedReport(CannedReport::RESOURCE_COUNT_THISWEEK, $this->fakeUser);
		$builder = $report->GetBuilder();

		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->fakeUser->Timezone);
		$expected = new ReportCommandBuilder();
		$expected->SelectCount()
				->OfResources()
				->Within($range->Start(), $range->End())
				->GroupByResource();

		$this->assertEquals($expected, $builder);
	}

	public function testGetsHighestCountResourcesThisMonth()
	{
		$report = new CannedReport(CannedReport::RESOURCE_COUNT_THISMONTH, $this->fakeUser);
		$builder = $report->GetBuilder();

		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->fakeUser->Timezone);
		$expected = new ReportCommandBuilder();
		$expected->SelectCount()
				->OfResources()
				->Within($range->Start(), $range->End())
				->GroupByResource();

		$this->assertEquals($expected, $builder);
	}

	public function testGetsHighestTimeResourcesAllTime()
	{
		$report = new CannedReport(CannedReport::RESOURCE_TIME_ALLTIME, $this->fakeUser);
		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectTime()
				->OfResources()
				->GroupByResource();

		$this->assertEquals($expected, $builder);
	}

	public function testGetsHighestTimeResourcesThisWeek()
	{
		$report = new CannedReport(CannedReport::RESOURCE_TIME_THISWEEK, $this->fakeUser);
		$builder = $report->GetBuilder();

		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->fakeUser->Timezone);
		$expected = new ReportCommandBuilder();
		$expected->SelectTime()
				->OfResources()
				->Within($range->Start(), $range->End())
				->GroupByResource();

		$this->assertEquals($expected, $builder);
	}

	public function testGetsHighestTimeResourcesThisMonth()
	{
		$report = new CannedReport(CannedReport::RESOURCE_TIME_THISMONTH, $this->fakeUser);
		$builder = $report->GetBuilder();

		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->fakeUser->Timezone);
		$expected = new ReportCommandBuilder();
		$expected->SelectTime()
				->OfResources()
				->Within($range->Start(), $range->End())
				->GroupByResource();

		$this->assertEquals($expected, $builder);
	}

	public function testGetsTopUsersByTimeReservedAllTime()
	{
		$report = new CannedReport(CannedReport::USER_TIME_ALLTIME, $this->fakeUser);

		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectTime()
				->OfResources()
				->GroupByUser()
				->LimitedTo(20);

		$this->assertEquals($expected, $builder);
	}

	public function testGetsTopUsersByTimeReservedThisWeek()
	{
		$report = new CannedReport(CannedReport::USER_TIME_THISWEEK, $this->fakeUser);

		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->fakeUser->Timezone);
		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectTime()
				->OfResources()
				->GroupByUser()
				->Within($range->Start(), $range->End())
				->LimitedTo(20);

		$this->assertEquals($expected, $builder);
	}

	public function testGetsTopUsersByTimeReservedThisMonth()
	{
		$report = new CannedReport(CannedReport::USER_TIME_THISMONTH, $this->fakeUser);

		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->fakeUser->Timezone);
		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectTime()
				->OfResources()
				->GroupByUser()
				->Within($range->Start(), $range->End())
				->LimitedTo(20);

		$this->assertEquals($expected, $builder);
	}

	public function testGetsTopUsersByCountAllTime()
	{
		$report = new CannedReport(CannedReport::USER_COUNT_ALLTIME, $this->fakeUser);

		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectCount()
				->OfResources()
				->GroupByUser()
				->LimitedTo(20);

		$this->assertEquals($expected, $builder);
	}

	public function testGetsTopUsersByCountThisWeek()
	{
		$report = new CannedReport(CannedReport::USER_COUNT_THISWEEK, $this->fakeUser);

		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->fakeUser->Timezone);
		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectCount()
				->OfResources()
				->GroupByUser()
				->Within($range->Start(), $range->End())
				->LimitedTo(20);

		$this->assertEquals($expected, $builder);
	}

	public function testGetsTopUsersByCountThisMonth()
	{
		$report = new CannedReport(CannedReport::USER_COUNT_THISMONTH, $this->fakeUser);

		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->fakeUser->Timezone);
		$builder = $report->GetBuilder();

		$expected = new ReportCommandBuilder();
		$expected->SelectCount()
				->OfResources()
				->GroupByUser()
				->Within($range->Start(), $range->End())
				->LimitedTo(20);

		$this->assertEquals($expected, $builder);
	}
}

?>
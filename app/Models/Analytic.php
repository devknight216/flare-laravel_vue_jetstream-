<?php

namespace App\Models;

use stdClass;
use Google\Client;
use League\Flysystem\Filesystem;
use Google\Service\AnalyticsData;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Adapter\Local;
use Illuminate\Database\Eloquent\Model;
use Google\Service\AnalyticsData\Metric;
use Illuminate\Support\Facades\Validator;
use Google\Service\AnalyticsData\DateRange;
use Google\Service\AnalyticsData\Dimension;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use Google\Service\AnalyticsData\RunReportRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analytic extends Model
{
    protected $casts = [
        'click' => 'array',
        'first_visit' => 'array',
        'page_view' => 'array',
        'scroll' => 'array',
        'session_start' => 'array',
        'user_engagement' => 'array',
    ];
    protected $fillable = ['period', 'click', 'first_visit', 'page_view', 'scroll', 'session_start', 'user_engagement'];
    use HasFactory;

    public function updateAnalytics($period = '7daysAgo')
    {


        $analytic = Analytic::where('period', $period)->first();
        if ($period && $analytic) {
            $analytics = $this->fetchAnalytics($period);
            $analytic->update([
                'click' => json_decode(json_encode($analytics->click), true),
                'first_visit' => json_decode(json_encode($analytics->first_visit), true),
                'page_view' => json_decode(json_encode($analytics->page_view), true),
                'scroll' => json_decode(json_encode($analytics->scroll), true),
                'session_start' => json_decode(json_encode($analytics->session_start), true),
                'user_engagement' => json_decode(json_encode($analytics->user_engagement), true),
            ]);
        }
        $analytics = $this->fetchAnalytics($period);
        $analytic = Analytic::firstOrCreate(['period' => $period], [
            'click' => json_decode(json_encode($analytics->click), true),
            'first_visit' => json_decode(json_encode($analytics->first_visit), true),
            'page_view' => json_decode(json_encode($analytics->page_view), true),
            'scroll' => json_decode(json_encode($analytics->scroll), true),
            'session_start' => json_decode(json_encode($analytics->session_start), true),
            'user_engagement' => json_decode(json_encode($analytics->user_engagement), true),
        ]);
        return $analytic;
    }

    public function fetchAnalytics($period = '7daysAgo')
    {
        $path = storage_path('app/analytics/service-account-credentials.json');

        $filesystemAdapter = new Local(storage_path('app/cache/fs'));
        $filesystem        = new Filesystem($filesystemAdapter);

        $cache = new FilesystemCachePool($filesystem);

        // Create and configure a new client object.
        $client = new Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($path);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $client->setCache($cache);

        $analytics = new AnalyticsData($client);

        $property = "properties/263785500";
        // Create the DateRange object.
        $dateRange = new DateRange();
        $dateRange->setStartDate($period);
        $dateRange->setEndDate("today");

        // Create the Metrics object.
        $metrics = [
            new Metric(['name' => 'userEngagementDuration']),
            new Metric(['name' => 'eventCount']),
        ];

        // Create the Dimensions object.
        $dimensions = [
            new Dimension(['name' => 'eventName']),
            new Dimension(['name' => 'pageLocation']),
        ];

        $request = new RunReportRequest();
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($metrics));
        $request->setDimensions($dimensions);
        $opt_params = array(
            'alt' => "json"
        );


        $report = $analytics->properties->runReport($property, $request, $opt_params);

        // $headers = [];
        // foreach ($report->getDimensionHeaders() as $header) {
        //     array_push($headers, $header->getName());
        // }
        // foreach ($report->getMetricHeaders() as $header) {
        //     array_push($headers, $header->getName());
        // }

        $values = new stdClass;
        foreach ($report->getRows() as $row) {

            $eventName = $row->getDimensionValues()[0]->getValue();
            $location = $row->getDimensionValues()[1]->getValue();

            if (!isset($values->$eventName)) {
                $values->$eventName = new stdClass;
            }
            if (!isset($values->$eventName->$location)) {
                $values->$eventName->$location = new stdClass;
            }

            $values->$eventName->$location->userEngagementDuration = $row->getMetricValues()[0]->getValue();
            $values->$eventName->$location->eventCount = $row->getMetricValues()[1]->getValue();
        }


        return $values;
    }
}
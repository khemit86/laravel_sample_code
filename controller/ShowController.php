<?php

    namespace App\Http\Controllers;

    use App\Models\Employee;
    use App\Models\Show;
    use App\Models\Schedule;
    use App\Models\Job;
    use \DateTime;
    use Illuminate\Support\Facades\DB;

    class ShowController extends Controller
    {

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index($channel, $day, $is_late = '', Show $show)
        {

            $date = date('Y-m-d', strtotime($day));

            $start_time  = '08:00:00';
            $end_time    = '15:00:00';

            if ($is_late == 'late_shift') {
                $start_time  = '16:00:00';
                $end_time    = '23:59:00';
            }

            if ($channel == 'hse24') {

                $show = $show->listShows(['channel_code' => 'ATV'], $date, $start_time, $end_time)->get()->toArray();

            } else if ($channel == 'hse24_extra') {

                $show = $show->listShows(['channel_code' => 'DIG'], $date, $start_time, $end_time)->get()->toArray();

            } else if ($channel == 'sonder') {

                $show = $show->listShows(['channel_code' => 'SONDER'], $date, $start_time, $end_time)->get()->toArray();

            } else {

                $show = $show->listShows(['live_flag' => 1], $date, $start_time, $end_time)->get()->toArray();
            }

            if ($is_late == 'late_shift') {

                return view('shows.shows', ['show' => $show, 'date' => $day, 'channel' => $channel, 'day' => $day, 'is_late' => true]);

            } else {

                return view('shows.shows', ['show' => $show, 'date' => $day, 'channel' => $channel, 'day' => $day, 'endTime' => $end_time]);

            }
        }


        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function show($channel, $day, $id, Employee $employee, Show $show)
        {
			
            $channel_code = $employee->checkForConditions($channel,
                ['hse24', 'hse24_extra', 'hse24_trend'],
                ['HSE24', 'Extra', 'Trend'], '');

            $show = $show->where(['id' => $id])->first();
            if (!empty($show)) {
                $show = $show->toArray();
            } else {
                return 'Show Not Found';
            }

            $start_date_time = date('Y-m-d H:i', strtotime($show['start_datetime']));
            $end_date_time = date('Y-m-d h:i:s', strtotime($start_date_time . "+1 hour"));


            $schedules = Schedule::where(DB::raw("(DATE_FORMAT(activity_time_start,'%Y-%m-%d %H:%i'))"), '<=', $start_date_time)
                ->where(DB::raw("(DATE_FORMAT(activity_time_end,'%Y-%m-%d %H:%i'))"), '>=', $start_date_time)
                ->with(['jobs' => function ($query) {
                $query->select(['jobs.id', 'jobs.name', 'jobs.channel', 'jobs.jobtype_id', 'jobs.subcategory', 'jobs.show_overview', 'jobs.detailed_view_of_employees', 'jobs.planning_unit_id'])
                    ->where('show_overview', 'x');
            }])
            ->with('employees')->get()->toArray();
            $schedules_data = array();

            if (!empty($schedules)) {

                foreach ($schedules as $key => $value) {
                    if (!empty($value['jobs']) && $channel_code == $value['jobs']['channel'] && $value['jobs']['show_overview'] == 'x') {

                        $result_array['activity_id'] = $value['activity_id'];
                        $result_array['time_start_date'] = $value['activity_time_start'];
                        $result_array['time_start'] = $value['activity_time_start'];
                        $result_array['time_end_date'] = $value['activity_time_end'];
                        $result_array['time_end'] = $value['activity_time_end'];
                        $result_array['firstname'] = $value['employees']['firstname'];
                        $result_array['lastname'] = $value['employees']['lastname'];
                        $result_array['job_name'] = $value['jobs']['name'];
						if(!empty($result_array['job_name']) && !empty($show['producer']) && $show['producer'] == $result_array['firstname']." ".$result_array['lastname']){
							$show['producer'] = '';
						}
						if(!empty($result_array['job_name']) && !empty($show['bimi']) && $show['bimi'] == $result_array['firstname']." ".$result_array['lastname']){
							$show['bimi'] = '';
						}
                        $result_array['jobtype_id'] = $value['jobs']['jobtype_id'];
                        $result_array['channel'] = $value['jobs']['channel'];
                        $result_array['subcategory'] = $value['jobs']['subcategory'];
						
                        $result_array['detailed_view_of_employees'] = $value['jobs']['detailed_view_of_employees'];
                        $result_array['show_overview'] = $value['jobs']['show_overview'];
                        $schedules_data[] = $result_array;
                    }

                }

            }
            $schedules_data = collect($schedules_data)->sortBy('job_name')->all();
            return view('shows.show-details', ['show' => $show, 'channel' => $channel, 'day' => $day, 'date' => $day, 'schedules_data' => $schedules_data]);
        }

    }

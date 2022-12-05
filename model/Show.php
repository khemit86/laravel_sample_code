<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use PhpParser\Node\Expr\Array_;

    /**
 * App\Models\Show
 *
 * @property int $id
 * @property int $channel_id
 * @property int $employee_id
 * @property string $channel_code
 * @property string|null $name
 * @property string|null $slug
 * @property string $start_datetime
 * @property int $live_flag
 * @property string|null $studio
 * @property string|null $set
 * @property string|null $host_name
 * @property string|null $producer_name
 * @property string|null $bimi_name
 * @property string|null $guest
 * @property string|null $model_name
 * @property string $angebot_des_tages
 * @property string $joker_der_woche
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $bimi
 * @property-read mixed $experte
 * @property-read mixed $model
 * @property-read mixed $moderation
 * @property-read mixed $producer
 * @method static \Illuminate\Database\Eloquent\Builder|Show listChannel($value, $date)
 * @method static \Illuminate\Database\Eloquent\Builder|Show listShows($value, $date, $startTime, $endTime)
 * @method static \Illuminate\Database\Eloquent\Builder|Show newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Show newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Show query()
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereAngebotDesTages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereBimiName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereChannelCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereHostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereJokerDerWoche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereLiveFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereProducerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereSet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereStartDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereStudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Show extends Model
    {

        protected $appends = ['moderation', 'experte', 'producer', 'bimi', 'model'];

        protected $fillable = [
            'id', 'channel_id', 'channel_code', 'name', 'live_flag', 'start_datetime',
            'studio', 'set', 'host_name', 'producer_name',
            'bimi_name', 'guest', 'angebot_des_tages', 'joker_der_woche', 'model_name'
        ];

        public function getModerationAttribute()
        {
            if (!empty($this->host_name)) {
                $data = array();
                $data['host_name'] = json_decode($this->host_name);
                if (isset($data['host_name'][0])) {
                    $firstName = (isset($data['host_name'][0]->f_name)) ? $data['host_name'][0]->f_name : '';
                    $lastName = (isset($data['host_name'][0]->l_name)) ? $data['host_name'][0]->l_name : '';
                    return $firstName . ' ' . $lastName;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }

        public function getExperteAttribute()
        {
            if (!empty($this->guest)) {
                $data = array();
                $data['guest'] = json_decode($this->guest);
                if (isset($data['guest'][0])) {
                    $firstName = (isset($data['guest'][0]->f_name)) ? $data['guest'][0]->f_name : '';
                    $lastName = (isset($data['guest'][0]->l_name)) ? $data['guest'][0]->l_name : '';
                    return $firstName . ' ' . $lastName;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }

        public function getProducerAttribute()
        {
            if (!empty($this->producer_name)) {
                $data = array();
                $data['producer_name'] = json_decode($this->producer_name);
                if (isset($data['producer_name'][0])) {
                    $firstName = (isset($data['producer_name'][0]->f_name)) ? $data['producer_name'][0]->f_name : '';
                    $lastName = (isset($data['producer_name'][0]->l_name)) ? $data['producer_name'][0]->l_name : '';
                    return $firstName . ' ' . $lastName;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }

        public function getBimiAttribute()
        {
            if (!empty($this->bimi_name)) {
                $data = array();
                $data['bimi_name'] = json_decode($this->bimi_name);
                if (isset($data['bimi_name'][0])) {
                    $firstName = (isset($data['bimi_name'][0]->f_name)) ? $data['bimi_name'][0]->f_name : '';
                    $lastName = (isset($data['bimi_name'][0]->l_name)) ? $data['bimi_name'][0]->l_name : '';
                    return $firstName . ' ' . $lastName;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }

        public function getModelAttribute()
        {
            if (!empty($this->model_name)) {
                $data = array();
                $data['model_name'] = json_decode($this->model_name);

                if (!empty($data['model_name'])) {

                    foreach($data['model_name'] as $key=>$val){
                        //$firstName = (isset($data['model_name'][0]->f_name)) ? $data['model_name'][0]->f_name : '';
                        //$lastName = (isset($data['model_name'][0]->l_name)) ? $data['model_name'][0]->l_name : '';
                        $firstName = $val->f_name;
                        $lastName = $val->l_name;
                        $model_name[] = $firstName . ' ' . $lastName;

                    }
                    return $model_name;
                } else {
                    //return '';
                    return $this->model_name;
                }
            } else {
                return '';
            }
        }

   public function old_getModelAttribute()
    {
        if (!empty($this->model_name)) {
            $data = array();
            $data['model_name'] = json_decode($this->model_name);
           /* echo "<pre>";
           print_r($data); die();*/
            $model_name = array();
            foreach( $data['model_name'] as $key => $value) {
                //echo "<pre>";
                //print_r($value);die();
                if (isset($data['model_name'])) {
                    $firstName = (isset($data['model_name']->f_name)) ? $data['model_name']->f_name : '';
                    $lastName = (isset($data['model_name']->l_name)) ? $data['model_name']->l_name : '';

                    return $firstName . ' ' . $lastName;
                } else {
                    //return '';
                    return $this->model_name;
                }
            }
        } else {
            return '';
        }
    }

        /**
         * @param $query
         * @param array $value
         * @param $date
         * @param $startTime
         * @param $endTime
         * @return mixed
         */
        public function scopeListShows($query,  $value = [], $date, $startTime, $endTime)
        {
            $shows_list = $query->where($value)
                ->whereNotIn('live_flag', [0])
                ->whereDate('start_datetime', '=', $date)
                ->where('start_datetime', '>=', $date . ' ' . $startTime)
                ->where('start_datetime', '<=', $date . ' ' . $endTime)
                ->groupBy('start_datetime')
                ->orderBy('start_datetime','ASC');
            //->orderBy('name','ASC');

            return $shows_list;
        }

        /**
         * @param $query
         * @param array $value
         * @param $date
         * @return mixed
         */
        public function scopeListChannel($query,  $value = [], $date)
        {
            $list_channel = $query->where($value)
                ->whereNotIn('live_flag', [0])
                ->whereDate('start_datetime', '=', $date);

            return $list_channel;
        }

    }

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Log;
use App\Http\Controllers\TaxWebAPITestController;
use DateTime;

class getCorpInfoByDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getCorpInfoByDay {IndicatedDay} {PeriodDays}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get the company information for {PeriodDays} from the indicated date{IndicatedDay}.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $IndicatedDay = $this->argument('IndicatedDay');
        $PeriodDays = $this->argument('PeriodDays');

        $message =
        [
            'Timing' => 'getCorpInfoByDay.handle',
            'IndicatedDay' => $IndicatedDay,
            'PeriodDays' => $PeriodDays,
        ];
        Log::notice($message);

        $DT_tgt_date = new DateTime($IndicatedDay);
        $ctrl_TaxWebAPITest = new TaxWebAPITestController();

        for($i=0;$i<$PeriodDays;$i++){
            sleep(8);

            if($i){
                $DT_tgt_date->modify('+1 day');
                $StartDay = $DT_tgt_date->format('Y-m-d');
                $DT_tgt_date->modify('+1 day');
                $EndDay = $DT_tgt_date->format('Y-m-d');
            }else{
                $StartDay = $DT_tgt_date->format('Y-m-d');
                $DT_tgt_date->modify('+1 day');
                $EndDay = $DT_tgt_date->format('Y-m-d');
            }
            echo('StartDay:' . $StartDay."\n");
            echo('EndDay  :' . $EndDay."\n");
        $res = $ctrl_TaxWebAPITest->tgt_date_get_IF($StartDay, $EndDay);
    }

        return 0;
    }
}

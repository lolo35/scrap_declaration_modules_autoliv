<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Requests;
use Exception;
use App\Models\Lines;

class getLines extends Command
{
    protected $url = "https://autoliv-eu2.leading2lean.com/api/1.0/";
    protected $auth = "ZjbBpxIq0qUYRoEOZkJYlNrEJL5Egkgh";
    protected $site = 15;
    protected $fields = "id,site,code,areacode,area,description";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'l2l:lines {--zone=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets lines from l2l for a given zone';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info("Fetching lines from L2L");
            $lines = $this->getLines();
            $this->info("Line fetching successfull");
            $this->info("Saving lines to DB");
            foreach($lines as $line) {
                $this->saveLinesToDB($line);
                if(!strpos($line->code, "indirect")){
                    $this->info("Line " . $line->code . " saved successfully");
                }
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function getLines(){
        try {
            $url = $this->url . "lines/?auth=" . $this->auth . "&site=" . $this->site . "&active=true&fields=" . $this->fields . "&areacode=" . $this->option('zone');
            $request = Requests::get($url);
            $response = json_decode($request->body, false);
            if(!$response->success) {
                throw new Exception($response->error);
            }
            return $response->data;
        } catch (Exception $e) {
            throw new Exception("error => " . $e->getMessage() . " on line => " . $e->getLine() . " in file => " . $e->getFile());
        }
    }

    private function saveLinesToDB($line){
        try {
            if(!strpos($line->code, "indirect")){
                Lines::updateOrCreate(
                    [
                        'line_id' => $line->id
                    ],
                    [
                        'zone' => $line->areacode,
                        'linecode' => $line->code
                    ]
                );
            }
        } catch (Exception $e) {
            throw new Exception("error => " . $e->getMessage() . " on line => " . $e->getLine() . " in file => " . $e->getFile());
        }
    }
}

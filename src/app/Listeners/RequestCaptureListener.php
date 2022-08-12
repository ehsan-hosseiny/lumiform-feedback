<?php

namespace App\Listeners;

use App\Models\RequestLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mockery\Exception;

class RequestCaptureListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $data = $event->data;
        if ( strlen( $data[ 'response' ] ) > 14039 )
        {
            $data[ 'response' ] = 'TRUNCATED_'.$this->truncate( $data[ 'response' ], 14040, '_TRUNCATED' );
        }
        RequestLog::create(
            $data
        );
    }

    private function truncate($string, $length=100, $append="&hellip;") {
      $string = trim($string);
      if(strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
      }
      return $string;
    }
}

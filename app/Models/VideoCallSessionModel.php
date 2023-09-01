<?php 

// app/Models/VideoCallSessionModel.php

namespace App\Models;

use CodeIgniter\Model;

class VideoCallSessionModel extends Model
{
    protected $table = 'video_call_sessions';
    protected $primaryKey = 'sessionid';
    protected $allowedFields = ['sessionid', 'starttime', 'receivetime', 'endtime', 'duration', 'callerid', 'receiverid'];

    public function createSession($callerid, $receiverid)
    {
        $data = [
            'callerid' => $callerid,
            'receiverid' => $receiverid,
            'starttime' => date('Y-m-d H:i:s') // Current server datetime
        ];

        $this->insert($data);
        return $this->getInsertID();
    }

    public function startSession($sessionid)
    {
        // Get the current server datetime as endtime
        $data = [
            'receivetime' => date('Y-m-d H:i:s'),
        ];

        $this->update($sessionid, $data);
    }

    public function endSession($sessionid)
    {
        // Get the current server datetime as endtime
        $endtime = date('Y-m-d H:i:s');

        // Calculate duration (difference between endtime and receivetime)
        $session = $this->find($sessionid);
        $duration = strtotime($endtime) - strtotime($session['receivetime']);

        $data = [
            'endtime' => $endtime,
            'duration' => $duration
        ];

        $this->update($sessionid, $data);
    }
}

<?php
namespace DataWarehouse\Query\Cloud\Statistics;

/*
* @author Rudra Chakraborty
* @date 02-20-2018
*
* Summation of Average Wallduration per VM
*/
class ReleasedSessionsCountStatistic extends \DataWarehouse\Query\Cloud\Statistic
{
    public function __construct($query_instance = null)
    {
        parent::__construct(
            'COALESCE(SUM(jf.num_sessions_ended), 0)',
            'cloud_num_sessions_ended_released',
            'Number of Sessions Ended (Released)',
            'Number of Sessions',
            0
        );
    }

    public function getInfo()
    {
        return 'The total number of sessions that were ended and were no longer blocking resources on a cloud resource. A session releases resources when shelved or terminated on a cloud resource.<br/>
        <b>Blocking:</b> Resource blocking is defined as maintaining reservation of cloud resources (CPUs, Memory, Storage Space).<br>
        <b>Session:</b> A session is defined as a discrete run of a virtual machine (VM) on a cloud resource; i.e. any start and stop of a VM. For example, if a single VM is stopped and restarted ten times in a given day, this would be counted as ten sessions for that day.<br/>
        <b>Start:</b> A session start event is defined as the initial creation, resume from pause/suspension, or unshelving of a VM. In the event that no such event has been collected, the first heartbeat event (e.g. a state report) is treated as the start of a new session.<br/>
        <b>Stop:</b> A session stop event is defined as a pause, shelving, suspension, or termination event of a VM.';
    }
}

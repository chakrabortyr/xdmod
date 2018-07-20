<?php
/**
 * @package OpenXdmod\ComponentTests
 * @author Rudra Chakraborty <rudracha@buffalo.edu>
 */

namespace ComponentTests\ETL;

use ETL\Ingestor\CloudStateReconstructorTransformIngestor;

/**
 * Test Cloud State FSM
 */

class CloudStateReconstructorTransformIngestorTest extends \PHPUnit_Framework_TestCase
{
    private $valid_event = array(
        "instance_id" => 2343,
        "event_time_utc" => "2018-02-06 17:09:01",
        "event_type_id" => 2,
        "start_event_id" => -1,
        "end_time" => -1,
        "end_event_id" => -1
    );

    private $invalid_event = array(
        "instance_id" => 2343,
        "event_time_utc" => "2018-02-06 17:09:01",
        "event_type_id" => 29,
        "start_event_id" => -1,
        "end_time" => -1,
        "end_event_id" => -1
    );

    private $zero_event = array(
        "instance_id" => 0,
        "event_time_utc" => 0,
        "event_type_id" => 0,
        "start_event_id" => 0,
        "end_time" => 0,
        "end_event_id" => 0
    );

    private $fsm;

    public function __construct() {
        $this->fsm = new CloudStateReconstructorTransformIngestor();
    }

    protected function testValidTransformation() {
        $this->assertEquals($this->valid_event, $this->fsm::transform($this->valid_event, 1));
    }

    protected function testInvalidTransformation() {
        $this->assertEquals(array(), $this->fsm::transform($this->invalid_event, 1));
    }

    protected function testZeroTransformation() {
        $this->assertEquals(null, $this->fsm::transform($this->zero_event, 1));
    }
}

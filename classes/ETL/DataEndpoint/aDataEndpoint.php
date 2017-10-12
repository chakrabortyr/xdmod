<?php
/* ==========================================================================================
 * Abstract helper class that provides functionality to support the implementation of iDataEndpoint.
 * Developers are not required to extend this class but it will make life easier.
 *
 * @author Steve Gallo <smgallo@buffalo.edu>
 * @date 2015-10-15
 * ==========================================================================================
 */

// Flesh this out so we have support for 4 endpoints. The handle should use the PDO classes or a
// file or curl handle.

namespace ETL\DataEndpoint;

use ETL\aEtlObject;
use ETL\DataEndpoint\iDataEndpoint;
use Exception;
use Log;

abstract class aDataEndpoint extends aEtlObject
{
    // The endpoint type (e.g., mysql, pdo, file, url)
    protected $type;

    // A handle to the actual class or file descriptor that implements the endpoint
    protected $handle;

    // A unique key that can be used to identify this endpoint. Typically some combination of type and
    // name.
    protected $key;

    // Default separator used in key generation.
    protected $keySeparator = '|';

    // The currently-available index for default keys generated by this class.
    private static $currentUniqueKeyIndex = 0;

    /* ------------------------------------------------------------------------------------------
     * @see iDataEndpoint::__construct()
     * ------------------------------------------------------------------------------------------
     */

    public function __construct(DataEndpointOptions $options, Log $logger = null)
    {
        parent::__construct($logger);

        $requiredKeys = array("name", "type");
        $this->verifyRequiredConfigKeys($requiredKeys, $options);

        $messages = array();
        $propertyTypes = array(
            'name' => 'string',
            'type' => 'string'
        );

        if ( ! \xd_utilities\verify_object_property_types($options, $propertyTypes, $messages, true) ) {
            $this->logAndThrowException("Error verifying options: " . implode(", ", $messages));
        }

        $this->type = $options->type;
        $this->setName($options->name);

    }  // __construct()

    // ------------------------------------------------------------------------------------------
    // Accessors

    /* @see iDataEndpoint::getType() */

    public function getType()
    {
        return $this->type;
    }  // getType()

    /* @see iDataEndpoint::getKey() */

    public function getKey()
    {
        return $this->key;
    }  // getKey()

    /* @see iDataEndpoint::getHandle() */

    public function getHandle()
    {
        return ( null !== $this->handle ? $this->handle : $this->connect() );
    }  // getHandle()

    /* ------------------------------------------------------------------------------------------
     * By default, do nothing unless the underlying endpoint driver specifies a quoting method.
     *
     * @see iDataEndpoint::quote()
     *
     * ------------------------------------------------------------------------------------------
     */

    public function quote($str)
    {
        return $str;
    }  // quote()

    /* ------------------------------------------------------------------------------------------
     * By default we return false but the child class should override this based on a specific type of
     * endpoint.
     *
     * @see iDataEndpoint::isSameServer()
     * ------------------------------------------------------------------------------------------
     */

    public function isSameServer(iDataEndpoint $cmp)
    {
        return false;
    }

    /**
     * Generate and store a unique data endpoint key.
     *
     * This may be used by aDataEndpoint subclasses that either don't have or
     * don't have a way to identify reusable endpoints.
     */
    protected function generateUniqueKey()
    {
        $keyIndex = self::$currentUniqueKeyIndex++;
        $this->key = "DataEndpoint{$keyIndex}";
    }

    /**
     * See iDataEndpoint::connect()
     */

    abstract public function connect();
}  // abstract class aDataEndpoint

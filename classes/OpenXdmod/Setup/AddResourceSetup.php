<?php
/**
 * @author Jeffrey T. Palmer <jtpalmer@buffalo.edu>
 */

namespace OpenXdmod\Setup;

/**
 * Resources setup sub-step for adding resources.
 */
class AddResourceSetup extends SetupItem
{

    /**
     * Main resources setup
     *
     * @var ResourcesSetup
     */
    protected $parent;

    /**
     * @inheritdoc
     */
    public function __construct(Console $console, ResourcesSetup $parent)
    {
        parent::__construct($console);

        $this->parent = $parent;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->console->displaySectionHeader('Add A New Resource');

        $this->console->displayMessage(<<<"EOT"
The resource name you enter should match the name used by your resource
manager.  This is the resource name that you will need to specify during
the shredding process.  If you are using Slurm this must match the
cluster name used by Slurm.
EOT
        );
        $this->console->displayBlankLine();

        $resource = $this->console->prompt('Resource Name:');
        $name     = $this->console->prompt('Formal Name:');

        $this->console->displayBlankLine();
        $this->console->displayMessage(<<<"EOT"
The number of nodes and processors are used to determine resource
utilization.
EOT
        );
        $this->console->displayBlankLine();

        $type = $this->console->prompt('What type of resource is this?', '1', array('1', '2'));
        if (empty($type) || !is_numeric($type)) { $type = 1; }

        $nodes = $this->console->prompt('How many nodes does this resource have?');
        if (empty($nodes) || !is_numeric($nodes)) { $nodes = 1; }

        $cpus = $this->console->prompt('How many total processors (cpu cores) does this resource have?');
        if (empty($cpus) || !is_numeric($cpus)) { $cpus = 1; }

        $ppn = $cpus / $nodes;

        $this->parent->addResource(
            array(
                'resource'   => $resource,
                'name'       => $name,
                'processors' => (int)$cpus,
                'nodes'      => (int)$nodes,
                'ppn'        => (int)$ppn,
                'type'       => (int)$type
            )
        );
    }
}

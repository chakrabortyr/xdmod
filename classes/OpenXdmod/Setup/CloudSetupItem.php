<?php

namespace OpenXdmod\Setup;

class CloudSetupItem extends SetupItem
{
    /**
     * Options for this setup action.
     *
     * @var array
     */
    private $options;

    /**
     * @inheritdoc
     */
    public function __construct(Console $console, array $options = array())
    {
        parent::__construct($console);

        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->console->displaySectionHeader('Cloud Metrics Installation');

        $this->console->displayMessage("Installing Cloud Metrics...");
        $this->console->displayBlankLine();
    }
}

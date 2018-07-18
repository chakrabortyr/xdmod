<?php

namespace OpenXdmod\Setup;

class CloudSetup extends SubMenuSetupItem
{
    /**
     * This setup menu.
     *
     * @var Menu
     */
    protected $menu;

    /**
     * True if setup should quit.
     *
     * @var bool
     */
    protected $quit;

    /**
     * @inheritdoc
     */
    public function __construct(Console $console)
    {
        parent::__construct($console);

        $items = array(
            new MenuItem('i', 'Install Cloud Metrics', new CloudSetupItem($console, $this)),
            new MenuItem('q', 'Quit Cloud Metrics Setup', new SubMenuQuitSetup($console, $this))
        );

        $this->menu = new Menu($items, $this->console, 'Cloud Metrics Setup');
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->quit = false;

        while (!$this->quit) {
            $this->menu->display();
        }
    }

    /**
     * Call to exit the menu on the next cycle.
     */
    public function quit()
    {
        $this->quit = true;
    }

    /**
     * No options to save data for this submenu
     */
    public function save()
    {
    }
}
<?php

namespace Portal\Factories;

use Psr\Container\ContainerInterface;
use Portal\Controllers\DisplayStagesController;

class DisplayStagesControllerFactory
{
    /**
     * Instantiates DisplayStagesController with dependencies.
     *
     * @param ContainerInterface $container
     *
     * @return DisplayStagesController.
     */
    public function __invoke(ContainerInterface $container) : DisplayStagesController
    {
        $renderer = $container->get('renderer');
        $stageModel = $container->get('StageModel');
        return new DisplayStagesController($renderer, $stageModel);
    }
}

<?php


namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Portal\Controllers\EditStageController;
use Portal\Models\StageModel;

class EditStageControllerTest extends TestCase
{
    /**
     * Tests the controller constructor and checks the class type of the output
     *
     * @return void
     */
    public function testConstruct()
    {
        $stageModel = $this->createMock(StageModel::class);
        $case = new EditStageController($stageModel);
        $expected = EditStageController::class;

        $this->assertInstanceOf($expected, $case);
    }
}

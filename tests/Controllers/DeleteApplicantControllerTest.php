<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Portal\Controllers\DeleteApplicantController;
use Portal\Models\ApplicantModel;

class DeleteApplicantControllerTest extends TestCase
{
    /**
     * Tests the controller constructor and checks the class type of the output
     *
     * @return void
     */
    public function testConstruct()
    {
        $applicantModel = $this->createMock(ApplicantModel::class);

        $case = new DeleteApplicantController($applicantModel);
        $expected = DeleteApplicantController::class;
        $this->assertInstanceOf($expected, $case);
    }
}

<?php

namespace Portal\Controllers;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;
use Slim\Views\PhpRenderer;
use Portal\Models\ApplicantModel;

class DisplayApplicantsController
{
    private $renderer;
    private $applicantModel;

    /**
     * DisplayApplicantsController constructor.
     *
     * @param PhpRenderer $renderer
     *
     * @param ApplicantModel $applicantModel
     */
    public function __construct(PhpRenderer $renderer, ApplicantModel $applicantModel)
    {
        $this->renderer = $renderer;
        $this->applicantModel = $applicantModel;
    }

    /**
     * Renders applicant data on the front end in displayApplicants.phtml.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return \Psr\Http\Message\ResponseInterface.
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $params = [];
        $sortValue = $request->getQueryParam('sort');
        $params['sort'] = $sortValue;

        switch ($sortValue) {
            case 'dateAsc':
                $params['data'] = $this->applicantModel->sortApplicants('dateAsc');
                break;

            case 'dateDesc':
                $params['data'] = $this->applicantModel->sortApplicants('dateDesc');
                break;

            case 'cohortAsc':
                $params['data'] = $this->applicantModel->sortApplicants('cohortAsc');
                break;

            case 'cohortDesc':
                $params['data'] = $this->applicantModel->sortApplicants('cohortDesc');
                break;

            default:
                $params['data'] = $this->applicantModel->getAllApplicants();
        }
        return $this->renderer->render($response, 'displayApplicants.phtml', $params);
    }
}

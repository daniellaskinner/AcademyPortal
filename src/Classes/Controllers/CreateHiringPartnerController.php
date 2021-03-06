<?php

namespace Portal\Controllers;

use Portal\Entities\HiringPartnerEntity;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Portal\Models\HiringPartnerModel;

class CreateHiringPartnerController
{
    public $hiringPartnerModel;
    public $renderer;

    /**
     * CreateHiringPartnerController constructor.
     *
     * @param $hiringPartnerModel
     */
    public function __construct(HiringPartnerModel $hiringPartnerModel)
    {
        $this->hiringPartnerModel = $hiringPartnerModel;
    }


    /**
     * Uses hiring partner model to add hiring partners with a try/catch for any errors.
     *
     * @param Request $request HTTP request
     * @param Response $response HTTP response
     * @param array $args
     *
     * @return Response HTTP response with redirect
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $newHiringPartner = $request->getParsedBody();
        $data = [
            'success' => false,
            'message' => 'Error!',
            'data' => []
        ];
        $statusCode = 400;

        try {
            $hiringPartner = $this->hiringPartnerModel->createNewHiringPartner(
                $newHiringPartner['name'],
                $newHiringPartner['companySize'],
                $newHiringPartner['techStack'],
                $newHiringPartner['postcode'],
                $newHiringPartner['phoneNumber'],
                $newHiringPartner['companyUrl']
            );
            if (!empty($hiringPartner) && $hiringPartner instanceof HiringPartnerEntity) {
                $result = $this->hiringPartnerModel->addHiringPartner($hiringPartner);
            }
        } catch (\Exception $exception) {
            $data['message'] = $exception->getMessage();
        }

        if (isset($result) && $result) {
            $data = [
                'success' => true,
                'message' => 'Hiring Partner Added to the db',
                'data' => []
            ];
            $statusCode = 200;
        }
        return $response->withJson($data, $statusCode);
    }
}

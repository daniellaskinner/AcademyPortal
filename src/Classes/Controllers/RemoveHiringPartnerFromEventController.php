<?php

namespace Portal\Controllers;

use Portal\Entities\HiringPartnerEntity;
use Portal\Models\EventModel;
use Slim\Http\Request;
use Slim\Http\Response;

class RemoveHiringPartnerFromEventController
{
    private $eventModel;

    public function __construct(EventModel $eventModel)
    {
        $this->eventModel = $eventModel;
    }

    /**
     * Calls a method to remove hiring partner from the event
     *
     * and responds with Json success message
     *
     * @param Request $request HTTP request
     * @param Response $response HTTP response
     * @param array $args The arguments array
     *
     * @return Response returns Json success/failure message
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $hiringPartner = $data['hp_id'];
        $event = $data['event_id'];

        $result = $this->eventModel->removeHiringPartnerFromEvent($event, $hiringPartner);

        if ($result) {
            return $response->withJson(['success' => true,
                'message' => 'Hiring partner successfully removed from the event.',
                'data' => [$hiringPartner, $event]], 200);
        } else {
            return $response->withJson(['success' => false, 'message' => 'Error - please contact administrator'], 500);
        }
    }
}

<?php

namespace Portal\Models;

use PDO;
use Portal\Entities\EventEntity;

class EventModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Get all events from the database
     *
     * @return array An array of Events
     */
    public function getEvents(): array
    {
        $sql = 'SELECT `events`.`id`, `events`.`name`, `events`.`category`, 
        `event_categories`.`name` AS `category_name`, `location`, `date`, `start_time`, 
        `end_time`, `notes` 
        FROM `events`
        LEFT JOIN `event_categories` ON `events`.`category` = `event_categories`.`id`
        ORDER BY `date` DESC;';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get all event categories from the database
     *
     * @return array An array of event categories
     */
    public function getEventCategories(): array
    {
        $sql = 'SELECT `id`, `name` FROM `event_categories`';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Add a new event to the database
     *
     * @param [type] $newEvent
     * @return boolean True if operation succeeded
     */
    public function addEvent(EventEntity $newEvent): bool
    {
        $query = $this->db->prepare("INSERT INTO `events` (
            `id`,
            `name`,
            `category`,
            `location`,
            `date`,
            `start_time`,
            `end_time`,
            `notes`
            ) 
            VALUES (
            :eventId, 
            :name, 
            :category, 
            :location,
            :date, 
            :startTime, 
            :endTime, 
            :notes);");
        $query->bindParam(':eventId', $newEvent->getEventId());
        $query->bindParam(':name', $newEvent->getName());
        $query->bindParam(':category', $newEvent->getCategory());
        $query->bindParam(':location', $newEvent->getLocation());
        $query->bindParam(':date', $newEvent->getDate());
        $query->bindParam(':startTime', $newEvent->getStartTime());
        $query->bindParam(':endTime', $newEvent->getEndTime());
        $query->bindParam(':notes', $newEvent->getNotes());
        return $query->execute();
    }

    /**
     * Search all events from the database
     *
     * @param string of validated search term
     * @return array An array of Events based on input search criteria
     */
    public function searchEvents(string $searchTerm):array
    {
        $sql = 'SELECT `events`.`id`, `events`.`name`, `events`.`category`, 
                `event_categories`.`name` AS `category_name`, `location`, `date`, `start_time`,`end_time`, `notes` 
                FROM `events` 
                LEFT JOIN `event_categories` ON `events`.`category` = `event_categories`.`id` 
                WHERE `events`.`name` LIKE ? ORDER BY `date` DESC;';
        $query = $this->db->prepare($sql);
        $searchTerm = '%' . $searchTerm . '%';
        $query->execute([$searchTerm]);
        return $query->fetchAll();
    }


    /**
     *Adds event id, hiring partner id and people attending to database
     *
     * @param int $hiringPartner id of the hiring partner selected
     *
     * @param int $event the id of the event selected
     *
     * @param int $attendees number of people attending from that hiring partner
     *
     * @return bool True if operation succeeds
     */
    public function addHPToEvent(int $hiringPartner, int $event, $attendees = null): bool
    {
        $query = $this->db->prepare('INSERT INTO `events_hiring_partner_link_table` (
            `hiring_partner_id`, 
            `event_id`, 
            `people_attending`
            ) 
            VALUES (
            :hiringPartner, 
            :event, 
            :attendees);');
        $query->bindParam(':hiringPartner', $hiringPartner);
        $query->bindParam(':event', $event);
        $query->bindParam(':attendees', $attendees);
        return $query->execute();
    }

    /**
     * checks that the hiring partner has successfully been linked to the event in the database
     *
     * @param int $hiringPartner hiring partner id
     *
     * @param int $event event id
     *
     * @return boolean indicating whether a hiring partner has successfully been linked to the event in the database
     */
    public function checkLinkHP(int $hiringPartner, int $event): bool
    {
        $query = $this->db->prepare('SELECT `id` FROM `events_hiring_partner_link_table`
        WHERE  `event_id` = :event AND
        `hiring_partner_id` = :hiringPartner AND `deleted` = 0;');
        $query->bindParam(':hiringPartner', $hiringPartner);
        $query->bindParam(':event', $event);
        $query->execute();
        $linkToHp = $query->fetchAll();
        if (count($linkToHp) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Pulls hiring partner ids from database where they link to a specific event id
     *
     * @param int $eventId the id of the event
     *
     * @return array the array of hiring partner ids
     */
    public function hpIdsByEventId(int $eventId): array
    {
        $statement = 'SELECT `hiring_partner_id`,`people_attending` 
        FROM `events_hiring_partner_link_table` WHERE  `event_id` = :eventId AND `deleted` = 0;';
        $query = $this->db->prepare($statement);
        $query->bindParam(':eventId', $eventId);
        $success = $query->execute();
        $hpIds = $query->fetchAll();
        return $hpIds;
    }

    /**
     * Deletes hiring partner from an event.
     *
     * @param int $eventId the id of the event
     *
     * @param int $hiringPartnerId the id of the hiring partner
     *
     * @return bool true if successful, else false.
     */
    public function removeHiringPartnerFromEvent(int $eventId, int $hiringPartnerId): bool
    {
        $statement = 'UPDATE events_hiring_partner_link_table SET `deleted` = 1  
        WHERE `event_id` = :eventId AND `hiring_partner_id` = :hiringPartnerId;';
        $query = $this->db->prepare($statement);
        $query->bindParam(':eventId', $eventId);
        $query->bindParam(':hiringPartnerId', $hiringPartnerId);
        return $query->execute();
    }
}

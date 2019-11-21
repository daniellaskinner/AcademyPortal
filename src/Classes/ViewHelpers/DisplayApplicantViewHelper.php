<?php

namespace Portal\ViewHelpers;

use \Portal\Entities\ApplicantEntity;

class DisplayApplicantViewHelper
{
    /**
     * Concatenates new applicant's name, email and cohort to join ready to be output.
     *
     * @param $applicants
     *
     * @return string $result, returns name, email, cohortID and all the data for the applicant.
     */
    public static function displayApplicants($applicants)
    {
        $result = '';
        foreach ($applicants as $applicant) {
            if ($applicant instanceof ApplicantEntity) {
                $result .= '<tr>
                        <td><a data-id ="' . $applicant->getId() . '" type="button"  class="myBtn">'
                    . $applicant->getName() . '</a></td>
                            <td>' . $applicant->getEmail() . '</td>
                            <td>' . $applicant->getDateOfApplication() . '</td>
                            <td>' . $applicant->getCohortDate() . '</td>
                        </tr>';
            }
        }
        return ($result);
    }

    /**
     * generates cohorts.
     *
     * @param $applicants
     *
     * @return string.
     */
    public static function getCohorts($applicants, $sort)
    {
        $cohortsArray = [];
        $result = '';
        foreach ($applicants as $applicant) {
            if ($applicant instanceof ApplicantEntity) {
                $cohort = $applicant->getCohortDate();
                array_push($cohortsArray, $cohort);
            }
        }
        $cohortsArraySorted = array_unique($cohortsArray);
        foreach ($cohortsArraySorted as $item) {
            $result .= '<form method="get">';

            if (!empty($sort)) {
                $result .= '<input type="hidden" value="' . $sort . '" name="sort">';
            }

            $result .= '<button type="submit" name="filter" value=" ' . $item . '
            " class="dropdown-item dropdownFilter" href="#">' . $item . '</button></form>';
        }
        return $result;
    }
}

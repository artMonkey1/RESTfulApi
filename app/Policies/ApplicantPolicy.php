<?php

namespace App\Policies;

use App\Models\Applicant;
use App\Models\Offer;
use App\Models\User;
use App\Models\Vacancy;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicantPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * @param User $user
     * @param Applicant $applicant
     * @return bool
     */
    public function actingAsApplicant(User $user, Applicant $applicant)
    {
        return $user->id == $applicant->id;
    }

    /**
     * @param User $user
     * @param Applicant $applicant
     * @param Offer $offer
     * @return bool
     */
    public function manageOfferFromSelf(User $user,
                                        Applicant $applicant,
                                        Offer $offer)
    {
        $offer = $applicant->offersFromSelf()->find($offer->id);

        return $this->actingAsApplicant($user, $applicant) && isset($offer);
    }

    /**
     * @param User $user
     * @param Applicant $applicant
     * @param Offer $offer
     * @return bool
     */
    public function manageOffer(User $user,
                                Applicant $applicant,
                                Offer $offer)
    {
        $offer = $applicant->offers()->find($offer->id);

        return $this->actingAsApplicant($user, $applicant) && isset($offer);
    }

    /**
     * @param User $user
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @return bool
     */
    public function actingAsOwnerOfVacancy(User $user,
                                           Applicant $applicant,
                                           Vacancy $vacancy)
    {
        $applicant->vacancies()->findOrFail($vacancy->id);

        return $this->actingAsApplicant($user, $applicant) &&
            ($vacancy->author instanceof Applicant) ? $vacancy->author->id == $applicant->id : false;
    }

    /**
     * @param User $user
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @param Offer $offer
     * @return bool
     */
    public function manageOffersOfVacancy(User $user,
                                          Applicant $applicant,
                                          Vacancy $vacancy,
                                          Offer $offer)
    {
        return $this->actingAsOwnerOfVacancy($user, $applicant, $vacancy) &&
            ($offer->recipient instanceof Vacancy) ? $offer->recipient->id == $vacancy->id : false;
    }
}

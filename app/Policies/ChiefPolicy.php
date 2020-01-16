<?php

namespace App\Policies;

use App\Models\Chief;
use App\Models\Company;
use App\Models\Offer;
use App\Models\User;
use App\Models\Vacancy;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use function foo\func;

class ChiefPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chief  $chief
     * @return boolean
     */
    public function actingAsChief(User $user, Chief $chief)
    {
        return $user->id == $chief->id;
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chief  $chief
     * @param  \App\Models\Company $company
     * @return boolean
     */
    public function actingAsOwnerOfCompany(User $user,
                                           Chief $chief,
                                           Company $company)
    {
        return $this->actingAsChief($user,$chief) && $company->chief->id == $chief->id;
    }

    /**
     * @param User $user
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return bool
     */
    public function manageOfferFromSelf(User $user,
                                        Chief $chief,
                                        Company $company,
                                        Offer $offer)
    {
        $offer = $company->offersFromSelf()->find($offer->id);

        return $this->actingAsOwnerOfCompany($user, $chief, $company) && isset($offer);
    }

    /**
     * @param User $user
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return bool
     */
    public function manageOffer(User $user,
                                Chief $chief,
                                Company $company,
                                Offer $offer)
    {
        $offer = $company->offers()->find($offer->id);

        return $this->actingAsOwnerOfCompany($user, $chief, $company) && isset($offer);
    }

    /**
     * @param User $user
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @return bool
     */
    public function actingAsOwnerOfVacancy(User $user,
                                           Chief $chief,
                                           Company $company,
                                           Vacancy $vacancy)
    {
        return $this->actingAsOwnerOfCompany($user, $chief, $company) &&
            ($vacancy->author instanceof Company) ? $vacancy->author->id == $company->id : false;
    }

    /**
     * @param User $user
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @param Offer $offer
     * @return bool
     */
    public function manageOffersOfVacancy(User $user,
                                          Chief $chief,
                                          Company $company,
                                          Vacancy $vacancy,
                                          Offer $offer)
    {
        return $this->actingAsOwnerOfVacancy($user, $chief, $company, $vacancy) &&
            ($offer-recipient instanceof Vacancy) ? $offer->recipient->id == $vacancy->id : false;
    }
}

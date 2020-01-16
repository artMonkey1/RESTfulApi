<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Gate;
use App\Models\Offer;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @throws AuthenticationException
     */
    public function allowedAdminAction()
    {
        if (Gate::denies('admin-actions')) {
            throw new AuthenticationException();
        }
    }
    /**
     * @param Request $request
     * @param Model $recipient
     * @return mixed
     */
    protected function getRecipientInfo(Request $request, Model $recipient)
    {
        $data = $request->validated();
        $data['recipient_id'] = $recipient->id;
        $data['recipient_type'] = get_class($recipient);

        return $data;
    }

    protected function getAcceptedInstanceData(Model $instance, Offer $offer)
    {
        return [
            $instance->id => [
                'salary' => $offer->salary,
                'position' => $offer->position
            ],
        ];
    }
}

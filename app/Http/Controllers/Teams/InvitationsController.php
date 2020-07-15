<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\InvitationContract;
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    protected $invitation;

    public function __construct(InvitationContract $invitation)
    {
        $this->invitation = $invitation;
    }

    public function invite(Request $request, $teamId)
    {

    }

    public function resend($id)
    {

    }
    public function respond(Request $request, $id)
    {

    }
    public function destroy($id)
    {

    }

}

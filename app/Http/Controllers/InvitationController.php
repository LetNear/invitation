<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Invite;

class InvitationController extends Controller
{
    public function show($code)
    {
        $invitation = Invite::where('code', $code)->firstOrFail();

        return view('livewire.birthday-invite', compact('invitation'));
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;

class InvitationController extends Controller
{
    public function show($code)
    {
        $invitation = Invitation::where('code', $code)->firstOrFail();

        return view('livewire.birthday-invite', compact('invitation'));
    }
}

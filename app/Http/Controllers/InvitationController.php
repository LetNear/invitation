<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Invite;

class InvitationController extends Controller
{
    public function show($code)
    {
        $invite = Invite::with('event', 'guest')->where('code', $code)->firstOrFail();

        return view('livewire.birthday-invite', compact('invite'));
    }

    public function rsvp(Request $request, $code)
    {
        $invite = Invite::with('guest')->where('code', $code)->firstOrFail();

        $guest = $invite->guest;
        $maxPlusOnes = max(0, ($guest->rsvp_limit ?? 0) - 1);

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plusOnes' => 'required|integer|min:0|max:' . $maxPlusOnes,
        ]);

        // Update guest name (if you want to allow them to update it)
        $guest->name = $validated['name'];
        $guest->save();

        // Save RSVP count (plus ones + 1 for the guest)
        $invite->rsvp_count = $validated['plusOnes'] + 1;
        $invite->status = 'accepted'; // Mark invite as accepted
        $invite->save();

        return redirect()->back()->with('message', 'Thank you for your RSVP!');
    }
}

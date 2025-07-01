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

        // If RSVP was already accepted, flash message once
        if ($invite->status === 'accepted' && !session('message')) {
            session()->flash('message', 'You have already RSVP’d. Thank you!');
        }

        return view('livewire.birthday-invite', compact('invite'));
    }

    public function rsvp(Request $request, $code)
    {
        $invite = Invite::with('guest')->where('code', $code)->firstOrFail();

        // ✅ Step 1: If already accepted, show thank you message and prevent further updates
        if ($invite->status === 'accepted') {
            return redirect()->back()->with('message', 'You have already RSVP’d. Thank you!');
        }

        $guest = $invite->guest;
        $maxPlusOnes = max(0, ($guest->rsvp_limit ?? 0) - 1);

        // ✅ Step 2: Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plusOnes' => 'required|integer|min:0|max:' . $maxPlusOnes,
        ]);

        // ✅ Step 3: Update RSVP data
        $guest->name = $validated['name'];
        $guest->save();

        $invite->rsvp_count = $validated['plusOnes'] + 1;
        $invite->status = 'accepted';
        $invite->save();

        // ✅ Step 4: Return with success message
        return redirect()->back()->with('message', 'Thank you for your RSVP!');
    }
}

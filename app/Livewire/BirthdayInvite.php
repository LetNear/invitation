<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invitation;

class BirthdayInvite extends Component
{
    public $invitation;
    public $name;
    public $plusOnes = 0;
    public $message = '';

    public function mount($code)
    {
        $this->invitation = Invitation::where('code', $code)->firstOrFail();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'plusOnes' => 'required|integer|min:0|max:' . ($this->invitation->rsvp_limit - 1),
        ]);

        // Here, you'd save the RSVP info. This is a placeholder for actual logic.
        
        $this->message = 'Thank you for your RSVP! We look forward to celebrating with you.';
    }

    public function render()
    {
        return view('livewire.birthday-invite');
    }
}
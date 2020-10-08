<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;

class ContactIndex extends Component
{
    public $statusUpdate = false;
    public $search;

    protected $listeners = [
        'contactStored' => 'handleStored',
        'contactUpdated' => 'handleUpdated'
    ];

    public function render()
    {
        return view('livewire.contact-index', [
            'contacts' => $this->search === null ?
            Contact::latest()->get() :
            Contact::latest()->where('name', 'like', '%' . $this->search . '%')->get()
        ]);
    }

    public function getContact($id)
    {
        $this->statusUpdate = true;
        $contact = Contact::find($id);
        $this->emit('getContact', $contact);
    }

    public function destroy($id)
    {
        if ($id) {
            $data = Contact::find($id);
            $data->delete();
            session()->flash('message', 'Contact was Deleted!');
        }
    }

    public function handleStored($contact)
    {
        // dd($contact);
        session()->flash('message', 'Contact ' . $contact['name'] . ' was Stored!');
    }

    public function handleUpdated($contact)
    {
        // dd($contact);
        session()->flash('message', 'Contact ' . $contact['name'] . ' was Updated!');
    }
}

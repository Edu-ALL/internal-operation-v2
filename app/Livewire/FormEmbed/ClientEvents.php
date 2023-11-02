<?php

namespace App\Livewire\FormEmbed;

use Livewire\Attributes\Renderless;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ClientEvents extends Component
{
    public $leads;
    public $schools;
    public $event;
    public $tags;
    public $index;
    public $current_page;

    #[Rule([
        'clientEvent.0.fullname' => [
            'required',
            'min:3',
        ],
    ])]
    public $clientEvent = [];

    public function mount($dataClientEvent)
    {
        $this->leads = $dataClientEvent['leads'];
        $this->schools = $dataClientEvent['schools'];
        $this->event = $dataClientEvent['event'];
        $this->tags = $dataClientEvent['tags'];
        $this->current_page = 'role';
        
    }
 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    
    public function save()
    {
        $validatedData = $this->validate();
 
        // Contact::create($validatedData);
    }

    public function render()
    {
        return view('livewire.form-embed.client-event');
    }
}

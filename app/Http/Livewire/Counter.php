<?php

namespace App\Http\Livewire;

use App\Models\School;
use App\Models\UserClient;
use Livewire\Component;

class Counter extends Component
{
    public $is_loading_client = true;
    public $is_loading_school = true;
    public $clients;
    public $schools;
 
    public function getClients()
    {
        $this->is_loading_client = false;
        $this->is_loading_school = false;
        $this->clients = UserClient::all();
        $this->schools = School::all();
        
    }
 
    public function render()
    {
        return view('livewire.counter');
    }

}

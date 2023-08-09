<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminHeaderSellerProfileInfo extends Component
{
        public $admin;
        public $seller;

        public $listeners = [
            'updateAdminHeaderSellerInfo'=>'$refresh'
        ];
        public function mount(){
            if(Auth::guard('admin')->check()){
                $this->admin = Admin::findOrFail(auth()->id());
            }
        }
        public function render(){
    
        return view('livewire.admin-header-seller-profile-info');
    }
}

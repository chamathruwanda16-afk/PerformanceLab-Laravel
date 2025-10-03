<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;  
use App\Models\Cart; 
class CartPanel extends Component
{
    public $items = [];

    public function mount()
    {
        $this->items = auth()->user()
            ? optional(Cart::firstOrCreate(['user_id'=>auth()->id()]))->items()->with('product')->get() ?? []
            : [];
    }

    public function render(){ return view('livewire.cart-panel'); }
}


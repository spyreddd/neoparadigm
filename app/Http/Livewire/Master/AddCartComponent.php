<?php

namespace App\Http\Livewire\Master;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddCartComponent extends Component
{
    public Product $product;
    public $quantity = 1;

    public function mount($product_id)
    {
        $this->product = Product::findOrFail($product_id);
    }

    public function render()
    {
        return view('livewire.master.add-cart-component');
    }

    public function min()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function plus()
    {
        if ($this->quantity < $this->product->quantity) {
            $this->quantity++;
        } else {
            $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Cannot exceed available stock.']);
        }
    }

    public function addCart()
    {
        if ($this->quantity <= 0) {
            $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Quantity must be greater than zero.']);
            return;
        }

        if ($this->quantity > $this->product->quantity) {
            $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Quantity is more than stock.']);
            return;
        }

        if (Auth::check()) {
            $cartItem = Cart::where([
                'product_id' => $this->product->id,
                'user_id' => Auth::id(),
            ])->first();
        } else {
            $cartItem = Cart::where([
                'product_id' => $this->product->id,
                'session_id' => session()->getId(),
            ])->first();
        }

        if ($cartItem) {
            if ($cartItem->quantity + $this->quantity > $this->product->quantity) {
                $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Quantity is more than stock.']);
                return;
            }
            $cartItem->quantity += $this->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'user_id' => Auth::check() ? Auth::id() : null,
                'session_id' => session()->getId(),
            ]);
        }

        $this->emit('cartAdded');
        $this->dispatchBrowserEvent('message', ['type' => 'success', 'msg' => 'Product added to cart successfully.']);
    }
}

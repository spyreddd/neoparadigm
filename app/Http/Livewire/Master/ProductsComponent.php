<?php

namespace App\Http\Livewire\Master;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class ProductsComponent extends Component
{
    public $showing = 8;
    public $perPage = 8;

    public function render()
    {
        $products = Product::latest()->paginate($this->perPage);
        return view('livewire.master.products-component', ['products' => $products]);
    }

    public function load()
    {
        $this->dispatchBrowserEvent('loadmore');
        $this->perPage = $this->perPage + $this->showing;
    }

    public function showing($size)
    {
        $this->showing = $size;
    }

    public function addCart($productId)
    {
        $product = Product::findOrFail($productId);

        // Check if the product is out of stock
        if ($product->quantity == 0) {
            $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Product is out of stock.']);
            return;
        }

        // Check if the requested quantity is more than the available stock
        $requestedQuantity = 1; // Assuming you are adding one item at a time
        if ($requestedQuantity > $product->quantity) {
            $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Quantity is more than stock.']);
            return;
        }

        $userId = auth()->check() ? auth()->user()->id : null;
        $sessionId = session()->getId();
        if (Auth::check()) {
            $cartItem = Cart::where([
                'product_id' => $productId,
                'user_id' => Auth::id(),
            ])->first();
        } else {
            $cartItem = Cart::where([
                'product_id' => $productId,
                'session_id' => session()->getId(),
            ])->first();
        }

        if ($cartItem) {
            // Check if the total quantity in the cart plus the requested quantity exceeds the stock
            if ($cartItem->quantity + $requestedQuantity > $product->quantity) {
                $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Quantity is more than stock.']);
                return;
            }

            $cartItem->quantity += $requestedQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'product_id' => $product->id,
                'quantity' => $requestedQuantity,
                'user_id' => $userId,
                'session_id' => $sessionId,
            ]);
        }

        $this->emit('cartAdded');
        $this->dispatchBrowserEvent('message', ['type' => 'success', 'msg' => 'Product added to cart successfully.']);
    }
}

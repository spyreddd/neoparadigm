<?php

namespace App\Http\Livewire\Master;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsComponent extends Component
{
    use WithPagination;

    public $showing = 8;
    public $perPage = 8;
    public $search = '';

    protected $paginationTheme = 'bootstrap'; // Use Bootstrap for pagination styling

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $this->search . '%');
        }

        $products = $query->latest()->paginate($this->perPage);

        return view('livewire.master.products-component', ['products' => $products]);
    }

    public function load()
    {
        $this->dispatchBrowserEvent('loadmore');
        $this->perPage += $this->showing;
    }

    public function showing($size)
    {
        $this->showing = $size;
    }

    public function addCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->quantity == 0) {
            $this->dispatchBrowserEvent('message', ['type' => 'error', 'msg' => 'Product is out of stock.']);
            return;
        }

        $requestedQuantity = 1;
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


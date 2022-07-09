<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = false;

    public $name;
    public $price;
    public $status = 0;

    public $confirmingItemDelete = false;
    public $confirmingItemAdd = false;

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'name'     => 'required|string|min:4',
        'price'    => 'required|numeric|between:1,100',
        'status'   => 'boolean'
    ];

    public function render()
    {
        $items = Item::where('user_id', auth()->user()->id)
            ->when($this->q, function($query) {
                return $query->where(function($query) {
                    $query->where('name', 'like', '%' . $this->q . '%')
                        ->orWhere('price', 'like', '%' . $this->q . '%');
                });
            })
            ->when($this->active, function($query) {
                return $query->active();
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $query = $items->toSql();
        $items = $items->paginate(10);

        return view('livewire.items', [
            'items' => $items,
            'query' => $query,
        ]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmItemAdd()
    {
        $this->reset();
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        $this->validate();

        Item::create([
            'user_id'   => auth()->user()->id,
            'name'      => $this->name,
            'price'     => $this->price,
            'status'    => $this->status,
        ]);

        $this->confirmingItemAdd = false;
    }

    public function confirmItemDelete($id)
    {
        $this->confirmingItemDelete = $id;
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
        $this->confirmingItemDelete = false;
    }
}

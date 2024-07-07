<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateGroupServices extends Component
{
    public $GroupsItems = [];
    public $allServices = [];
    public $discount_value = 0;
    public $taxes = 14;
    public $name_group;
    public $notes;
    public $ServiceSaved = false;
    public $ServiceUpdated = false;
    public $show_table = true;
    public $updateMode = false;
    public $group_id;

    // Define validation rules
    protected $rules = [
        'name_group' => 'required',
        'notes' => 'nullable',
        'GroupsItems.*.service_id' => 'required',
        'GroupsItems.*.quantity' => 'required|numeric|min:1',
    ];

    public function mount()
    {
        $this->allServices = Service::all();
    }

    public function render()
    {
        $total = 0;
        foreach ($this->GroupsItems as $groupItem) {
            if ($groupItem['is_saved'] && $groupItem['service_price'] && $groupItem['quantity']) {
                $total += $groupItem['service_price'] * $groupItem['quantity'];
            }
        }

        $subtotal = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
        $total_with_tax = $subtotal * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);

        return view('livewire.GroupServices.create-group-services', [
            'groups' => Group::all(),
            'subtotal' => $subtotal,
            'total' => $total_with_tax
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->render();
    }

    public function addService()
    {
        foreach ($this->GroupsItems as $key => $groupItem) {
            if (!$groupItem['is_saved']) {
                $this->addError('GroupsItems.' . $key, 'This service must be saved before creating a new one.');
                return;
            }
        }

        $this->GroupsItems[] = [
            'service_id' => '',
            'quantity' => 1,
            'is_saved' => false,
            'service_name' => '',
            'service_price' => 0
        ];

        $this->ServiceSaved = false;
    }

    public function editService($index)
    {
        foreach ($this->GroupsItems as $key => $groupItem) {
            if (!$groupItem['is_saved']) {
                $this->addError('GroupsItems.' . $key, 'This line must be saved before editing another.');
                return;
            }
        }

        $this->GroupsItems[$index]['is_saved'] = false;
    }

    public function saveService($index)
{
    $this->resetErrorBag();

    // Validate if service_id and quantity are provided
    $rules = [
        'GroupsItems.' . $index . '.service_id' => 'required',
        'GroupsItems.' . $index . '.quantity' => 'required|numeric|min:1',
    ];

    $this->validate($rules);

    $product = $this->allServices->find($this->GroupsItems[$index]['service_id']);
    $this->GroupsItems[$index]['service_name'] = $product->name;
    $this->GroupsItems[$index]['service_price'] = $product->price;
    $this->GroupsItems[$index]['is_saved'] = true;
    $this->ServiceSaved = true; // Set ServiceSaved to true after saving
}


    public function removeService($index)
    {
        // Check if the item exists in the array before attempting to remove it
        if (isset($this->GroupsItems[$index])) {
            // Unset the specific item
            unset($this->GroupsItems[$index]);
            // Reindex the array to maintain proper indexing
            $this->GroupsItems = array_values($this->GroupsItems);
        }
    }

    public function saveGroup()
    {
        try {
            $this->validate();
    
            if (empty($this->GroupsItems)) {
                $this->addError('GroupsItems', 'You must add at least one service.');
                return;
            }
    
            $serviceAdded = false;
            foreach ($this->GroupsItems as $groupItem) {
                if ($groupItem['is_saved']) {
                    $serviceAdded = true;
                    break;
                }
            }
    
            if (!$serviceAdded) {
                $this->addError('GroupsItems', 'You must add at least one service.');
                return;
            }
    
            // Proceed with saving only if validation passes
            if ($this->updateMode) {
                $Groups = Group::find($this->group_id);
                $total = 0;
                foreach ($this->GroupsItems as $groupItem) {
                    if ($groupItem['is_saved'] && $groupItem['service_price'] && $groupItem['quantity']) {
                        $total += $groupItem['service_price'] * $groupItem['quantity'];
                    }
                }
                $Groups->total_before_discount = $total;
                $Groups->discount_value = $this->discount_value;
                $Groups->total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
                $Groups->tax_rate = $this->taxes;
                $Groups->total_with_tax = $Groups->total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);
                $Groups->name = $this->name_group;
                $Groups->notes = $this->notes;
                $Groups->save();
                $Groups->service_group()->detach();
                foreach ($this->GroupsItems as $GroupsItem) {
                    $Groups->service_group()->attach($GroupsItem['service_id'], ['quantity' => $GroupsItem['quantity']]);
                }
    
                $this->ServiceSaved = false;
                $this->ServiceUpdated = true;
            } else {
                $Groups = new Group();
                $total = 0;
                foreach ($this->GroupsItems as $groupItem) {
                    if ($groupItem['is_saved'] && $groupItem['service_price'] && $groupItem['quantity']) {
                        $total += $groupItem['service_price'] * $groupItem['quantity'];
                    }
                }
                $Groups->total_before_discount = $total;
                $Groups->discount_value = $this->discount_value;
                $Groups->total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
                $Groups->tax_rate = $this->taxes;
                $Groups->total_with_tax = $Groups->total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);
                $Groups->name = $this->name_group;
                $Groups->notes = $this->notes;
                $Groups->save();
                foreach ($this->GroupsItems as $GroupsItem) {
                    $Groups->service_group()->attach($GroupsItem['service_id'], ['quantity' => $GroupsItem['quantity']]);
                }
                $this->reset(['GroupsItems', 'name_group', 'notes', 'discount_value']);
                $this->ServiceSaved = true;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->ServiceSaved = false; // Ensure confirmation message is not shown on validation error
        }
    }
    

    public function show_form_add()
    {
        $this->show_table = false;
    }

    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;
        $group = Group::where('id', $id)->first();
        $this->group_id = $id;

        $this->reset('GroupsItems', 'name_group', 'notes');
        $this->name_group = $group->name;
        $this->notes = $group->notes;

        $this->discount_value = intval($group->discount_value);
        $this->ServiceSaved = false;

        foreach ($group->service_group as $serviceGroup) {
            $this->GroupsItems[] = [
                'service_id' => $serviceGroup->id,
                'quantity' => $serviceGroup->pivot->quantity,
                'is_saved' => true,
                'service_name' => $serviceGroup->name,
                'service_price' => $serviceGroup->price
            ];
        }
    }

    public function delete($id)
    {
        Group::destroy($id);
        return redirect()->to('/Add_GroupServices');
    }


    public function getAllGroupServices()
    {
        $groupServices = Group::with(['service_group' => function ($query) {
            $query->select('services.id', 'services.price', 'services.description', 'services.status', 'services.name')
                ->withPivot('quantity');
        }])
        ->whereNotNull('name')
        ->get(['id', 'name', 'total_before_discount', 'discount_value', 'total_after_discount', 'tax_rate', 'total_with_tax', 'notes']);

        return $groupServices;
    }

    public function getGroupService($id)
    {
        $group = Group::with(['service_group' => function ($query) {
            $query->select('services.id', 'services.price', 'services.description', 'services.status', 'services.name')
                ->withPivot('quantity');
        }])
        ->findOrFail($id);

        return $group;
    }
}

<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Service;
use Livewire\Component;

class CreateGroupServices extends Component
{
    
        public $GroupsItems = [];
        public $allServices = [];
        public $discount_value = 0;
        public $taxes = 17;
        public $name_group;
        public $notes;
        public $ServiceSaved = false;
    
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
    
            return view('livewire.GroupServices.create-group-services', [
                'subtotal' => $Total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
                'total' => $Total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100)
            ]);
    
        }
    
    
        public function addService()
        {
            foreach ($this->GroupsItems as $key => $groupItem) {
                if (!$groupItem['is_saved']) {
                    $this->addError('GroupsItems.' . $key, 'يجب حفظ هذا الخدمة قبل إنشاء خدمة جديدة.');
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
            $product = $this->allServices->find($this->GroupsItems[$index]['service_id']);
            $this->GroupsItems[$index]['service_name'] = $product->name;
            $this->GroupsItems[$index]['service_price'] = $product->price;
            $this->GroupsItems[$index]['is_saved'] = true;
        }
    
        public function removeService($index)
        {
            unset($this->GroupsItems[$index]);
            $this->GroupsItems = array_values($this->GroupsItems);
        }
    
        public function saveGroup()
{
    $Groups = new Group();
    $total = 0;

    foreach ($this->GroupsItems as $groupItem) {
        if ($groupItem['is_saved'] && $groupItem['service_price'] && $groupItem['quantity']) {
            // Calculate total before discount
            $total += $groupItem['service_price'] * $groupItem['quantity'];
        }
    }

    // Save group details
    $Groups->Total_before_discount = $total;
    $Groups->discount_value = $this->discount_value;
    $Groups->Total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
    $Groups->tax_rate = $this->taxes;
    $Groups->Total_with_tax = $Groups->Total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);
    $Groups->name = $this->name_group;
    $Groups->notes = $this->notes;
    $Groups->save();

    // Save group's related services
    foreach ($this->GroupsItems as $GroupsItem) {
        if ($GroupsItem['is_saved']) {
            $Groups->service_group()->attach($GroupsItem['service_id']);
        }
    }

    // Reset form fields and flags
    $this->reset('GroupsItems', 'name_group', 'notes');
    $this->discount_value = 0;
    $this->ServiceSaved = true;
}

    
}

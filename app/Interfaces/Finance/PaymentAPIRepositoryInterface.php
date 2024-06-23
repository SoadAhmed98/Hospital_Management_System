<?php

namespace App\Interfaces\Finance;

interface PaymentAPIRepositoryInterface
{
    // get All Payments
    public function index();

    // show form add (not needed for API)
    // public function create();

    // store Payment
    public function store($request);

    // show Payment
    public function show($id);

    // Update Payment
    public function update($request, $id);

    // destroy Payment
    public function destroy($id);
}

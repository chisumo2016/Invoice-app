<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()
            ->count(25)
            ->hasInvoices(10)  //each of them will have 25 invoices
            ->create();

        Customer::factory()
            ->count(100)
            ->hasInvoices(5)  //each of them will have 25 invoices
            ->create();

        Customer::factory()
            ->count(100)
            ->hasInvoices(3)  //each of them will have 25 invoices
            ->create();

        Customer::factory()
            ->count(5)
            ->create();
    }
}

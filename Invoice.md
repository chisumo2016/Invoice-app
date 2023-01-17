
## Installation of an application
## Data Modelling  Customer and Invoice
         php artisan make:model Customer --all
         php artisan make:model Invoice --all
## Relation 1: M
    Once Customer cann has many Invoice
    Invoice belongs to Customer
    Define the relationship btn Customer and Invoice
## Add the migration column
    - define all the column for custtomers and Invoice
## Designing and Seeding the Database
    - Gonna use Factory
            


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
## Version and Defining Routes
    - we need to versioning our api 
    - We should put our controller in API folder FOLLOWED V1
    php artisan help make:resource
            

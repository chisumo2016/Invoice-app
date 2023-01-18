
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

## TRANSFORMING DATABASE DATA INTO JSON
     - when you hit the endpoint of the customer url, return everything from database.
         e.g http://invoice-api.test/api/v1/customers
            We need to use camel case in api "postal_code": "89033",
                eg 'postalCode'=>$this->postal_code
            To remove the created_at and updated_at field 
    - We can approach the two things aboove by using Resource,it allow to transforem
        the elequeent model into json response.
    Create a Resoource
        php artisan help make:resource
        php artisan make:resource V1/CustomerResource  
      example:
            http://invoice-api.test/api/v1/customers/1  - show()
    - If we go back to our customers we get the sammee response
            http://invoice-api.test/api/v1/customers  - index()
            We need to use a resource to filter down each individual into JSON Object.
            We can archive this by create another resource called collection
                specificc for working alot of thiing

                    php artisan make:resource V1/CustomerCollection     
        
        







            

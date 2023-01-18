
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
                    php artisan make:resource V1/InnvoiceResource 
                    php artisan make:resource V1/InnvoiceCollection     

### FILTERING DATA
    Provide an ability to filter the data.
    Search is different from filtering
    We'dont need search in api
    Filtering thing getting GET request, return collection
        customers , invoices
        customers?postalCode[gt] =30000  - into array

        Customer::where([['column', 'operator', 'value']])
    Create a folder called services in app
        app/Services/V1/CustomerQuery.php
            Write a logic on this class
            import inside the controoller
    Testing filter  
            http://invoice-api.test/api/v1/customers/?postalCode[gt]=3000
        error: Call to undefined method App\Services\V1\CustomerQuery::operatorMap()
        Solution: this operatorMap() isnt a mmethod is an array 
    Testing search   (AND)
        http://invoice-api.test/api/v1/customers?postalCode[gt]=9000  - Passed
        http://invoice-api.test/api/v1/customers?postalCode[gt]=9000&type[eq]=I  - Passed
    BUT
        We dont have unabilitty to do OR  COMPLEX
        We have ability to use AND ?postalCode[gt]=9000
    NOTE
        The code isnt not reusable in other service.
      
        







            


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

## FILTERING MORE DATA 
        we need to implement other filter so we can use in the future
        - To use the base class to abstact .
        - Change the Folder into Filters not services 
        - Change tthe name of class to CustomerFilter
        - Create a file called apiFilter.php inside Filters
                - copy everything from customerFiltter annd paste
                - change the namespace
                - import namespace in CustomerFilter
                - modifify our CustomerController
                        we can create a facades for CustomersFilter , not new constructtor CustomersFilter is very complicated
                        Also we can use tthe service conttainer 
        - Let us implement the filter for invoice call Filters/V1/InvoicesFilter.php
                - Implmenet the logic in the InvoiceController
                        on the index() method 
        - TEST
                http://invoice-api.test/api/v1/invoices  Passed
                http://invoice-api.test/api/v1/invoices  Passed

        - Note
            Links doesnt contains the query string
            In the invoiceController
            return new InvoiceCollection(Invoice::where($queryItems)->paginate());
                TOBE
                $invoices = Invoice::where($queryItems)->paginate();
                return new InvoiceCollection($invoices->appends($request->query()));
              PLEASE DO FOR CUSTOMERS CONTROLLERS


## RELATIONSHIP 
    - Include related data btn customer and Invoices
    - One To Many 
    - include the query parameter = &includeInvoices
             $includeInvoices = $request->query('includeInvoices');
    - Open the CustomerController index(){}
            
                 public function index(Request $request)
                    {
                        $filter     = new CustomersFilter();
                        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]
                        
                        
                        if (count($queryItems) == 0 ){
                            return new CustomerCollection(Customer::paginate());
                        }else{
                            $customers = Customer::where($queryItems)->paginate();
                           return new CustomerCollection($customers->appends($request->query()));
                           // return new CustomerCollection(Customer::where($queryItems)->paginate());
                        }
                    }
            TO 

            public function index(Request $request)
            {
                $filter     = new CustomersFilter();
                $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]
        
                $includeInvoices = $request->query('includeInvoices');
                $customers = Customer::where($filterItems);
                    if ($includeInvoices){
                        $customers = $customers->with('invoices');
                    }
                return new CustomerCollection($customers->paginate()->appends($request->query()));
        
            }

    TEST:
    http://invoice-api.test/api/v1/customers?postalCode[gt]=9000&type[eq]=I&includeInvoices=true
    - Open the CustomerResource File  and add the relationships
                'invoices' => InvoiceResource::collection($this->whenLoaded('invoices'))
    - We want to add the relatioship to inndividual customers
        will bee in the show method.
            eg http://invoice-api.test/api/v1/customers/9?includeInvoices=true
                public function show(Customer $customer)
                    {
                        $includeInvoices = request()->query('includeInvoices');
                        if($includeInvoices){
                            return new CustomerResource($customer->loadMissing('invoices'));
                        }
                        return new CustomerResource($customer);
                    }

## CREATING RESOURCE WITH POST REQUEST
    - Create a Fillable array in the Customer Model
    - Add the small logic in store() in CustomerController
        return  new CustomerResource(Customer::create($request->all()));
    - Add the logic of validation in the request
            Information comes from client so we need to transform or postalCode
    TEST:
        We can use the Postman to create a new recode
            http://invoice-api.test/api/v1/customers/231

## UPDATING WITH PUT AND PATCH
    PUT: Replace the entire entity, you can't leave antything out 
            {
            "data": {
                    "id": 231,
                    "name": "Jerermy Hunter",
                    "type": "I",
                    "email": "jeremey@gmai.com",
                    "address": "1234 Whennener",
                    "city": "Some Town",
                    "state": "Cansass",
                    "postalCode": "22223"
                }
            }
    PATCH: we can select what we want to edit  
        {
            "data": {
                    
                    "address": "1234 Whennener",
                    "city": "Some Town",
                    "state": "Cansass",
                    "postalCode": "22223"
                }
            }
### IMPLEMENTING BUILD INSERT 
    Payload will have an arrays
            [{customerId: } ,{customerId: }]
    Were goingo to validate an individual array inside an array
    - Add the api route
    - Create a bulkStore() method in the InvoiceController
    - Create a request validation rules called app/Http/Requests/V1/BulkStoreInvoiceRequest.php
            - Write all logic inside of this files.
            - Call the BulkStoreInvoiceRequest in bulkStore() in the InvoiceController
            - Write all the logic in in the bulkStore() 
    - TEST THE API via Postman
            POST : http://invoice-api.test/api/v1/invoices/bulk
                    {
                        "customerId": "1",
                        "amount": "0",
                        "status": "B",
                        "billDate": "2015-09-04 09:13:26",
                        "paidDate": null
                    },
                    {
                    "customerId": 1,
                    "amount": "200",
                    "status": "P",
                    "billedDate": "2015-09-04 09:13:26",
                    "paidDate": null
                    }

    ###  PROTECTING ROUTES WITH SANCTUM    
        Provide the token 
            Install and puplish









      
        







            

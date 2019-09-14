# Sasquatch PHP

Sasquatch its a **micro framework** based on the MVC 
pattern for making small web applications with
php 

This framework is not meant for large applications
, its a work in progress
project made by a **junior developer** use it at your
own risk, if by any chance you have suggestions please
let me know and dont be afraid to send me an email at 
**ben99.planetatierra@gmail.com**

## How to use 
The framework as you may guess its divided in three main parts
, the controllers, the database models, and the views. 
And also a config file 

It all starts in the index.php file within the public folder 
, all of the http requests are redirected to this file, witch initialize a controller
based on the url 

### Index file 
It all begins here where the Core class in the 
library namespace gets call and based on the 
introduced URL it will render the proper Controller.

I will recommend not to mess with the Core class
function unless you really know what you are
doing 

### Controllers
All of the controllers must be created inside the
'app/Controllers' folder and the class created there
must have the sufix 'Controller' an example.

```php
namespace App\Controller; 

use App\Libraries\BaseController

class ExampleController extends BaseController
{
    // It is recommended to have an index method
    // Gets called if user navegates to '/example'
    public function index()
    {
        $this->renderView('example.html.twig');
    }
    
    // gets called if user goes to '/example/info'
    public function info()
    {
        
    }
} 
```

By default Sasquatch comes with to controllers 
, the HomeController and the NoController.

The *HomeController* renders the index.html.view
this is your homepage as simple as that, everytime the user
browses to the '/' path, the HomeController gets called.

The *NoController* its the one executed if the URL
introduced by the user matches no Controller
or no method inside a Controller. This Controller
will render the 404 page.

### Database

### Views


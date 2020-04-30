# How to use this CMS


I have created a simple installation process: after creating a database and providing its credentials to the `application/config/database.php` file, you can run the `Install` controller which will create all the necessary tables:

    class Install extends CI_Controller {
        public function __construct()
        {
            parent::__construct();
        }
    
        public function index(){
            // Create all the database tables if there are none
            // by redirecting to the Migrations controller
            $tables = $this->db->list_tables();
            if (count($tables) == 0) {
                redirect('migrate');
            } else {
                redirect('/');
            }
        }
    }


After that, you can register as an **author**. Being the first registered author, you are also an admin, meaning that your author account *does not require activation* (and the value for the `is_admin` column has a value of `1` in the database record for you). 

All the future authors will need their accounts *activated by you* in order to publish articles (posts).
Clone and Setup

1. Clone the Repository
git clone https://github.com/shafa20/Product-Management-API.git
cd project name

2.composer install

3.cp .env.example .env
Edit the .env file to include your database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

4. php artisan key:generate

5.php artisan migrate

API Test
Open Postaman


Categories:

1. http://127.0.0.1:8000/api/categories   To Show Category (List)  -> Method GET

2. http://127.0.0.1:8000/api/categories To Create Category -> Method Post
Choose Body → raw → JSON

{
  "name": "Category-01",
  "description": "This is Category-01"
}

3. http://127.0.0.1:8000/api/categories/{id} To Update Category -> PUT 

Body:

json

{
  "name": "Updated Category-01",
  "description": "Updated description of Category-01"
}

4. http://127.0.0.1:8000/api/categories/{id} To Delete Category ->Method DELETE

Products:

1. http://127.0.0.1:8000/api/products   To Show Product (List)  -> Method GET

2. http://127.0.0.1:8000/api/products to Create Product -> Method POST
Choose Body → raw → JSON
{
  "name": "product 01",
  "description": "product 01 description",
  "price": 999.99,
  "category_id": 1
}

3.http://127.0.0.1:8000/api/products/{id} To Update Product -> Method Put
Body:

json

{
  "name": "product 01",
  "description": "Updated description of product 01",
  "price": 899.99,
  "category_id": 1
}


4.http://127.0.0.1:8000/api/products/{id} To Delete Product -> Method Delete

Unuit Test
Run Command php artisan test

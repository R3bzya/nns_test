## Docker

```
docker-compose build
docker-compose up -d
docker-compose exec php bash
php artisan migrate
```

## Api
### User

#### Register
```
[POST] /api/auth/user/register

# Register manager
{
    "email": "employee@gmail.com",
    "password": "123456",
    "password_confirmation": "123456",
    "name": "John Doe",
    "company": "John Doe"
}

# Register sub employee
{
    "email": "employee@gmail.com",
    "password": "123456",
    "password_confirmation": "123456",
    "name": "John Doe",
    "parent_email": "parent_email@gmail.com"
}
```

#### Login
```
[POST] /api/auth/user/login
{
    "email": "employee@gmail.com",
    "password": "123456"
}
```

### Employee
#### Create sub employee

```
[POST] /api/employees/create
{
    "name": "John Doe",
    "email": "employee@gmail.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```

#### Get children

```
[GET] /api/employees/<employee_id>/children
```

#### Get descendants

```
[GET] /api/employees/<employee_id>/descendants
```

#### Export children

```
[GET] /api/employees/<employee_id>/children-export
```

#### Export descendants

```
[GET] /api/employees/<employee_id>/descendants-export
```

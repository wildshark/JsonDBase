## JSON Database Class

This PHP class, `JsonDatabase`, offers functionalities for managing data stored in JSON format. Below is an explanation of the provided methods and examples of their usage.

### Constructor

```php
$database = new JsonDatabase('data.json');
```

Instantiates the `JsonDatabase` class with the filename of the JSON data.

### CRUD Operations

#### Get All Entities

```php
$users = $database->getAll('users');
print_r($users);
```

Retrieves all entities of a specified type (e.g., 'users').

#### Get Entity by ID

```php
$user = $database->getById('users', "658818a84aaaa");
print_r($user);
```

Retrieves a specific entity by its unique ID.

#### Create Entity

```php
$newUser = $database->create('users', ['name' => 'New User', 'email' => 'newuser@example.com']);
print_r($newUser);
```

Creates a new entity with the provided data.

#### Update Entity

```php
$newUser['id'] = "658818a84aaaa";
$updatedUser = $database->update('users', $newUser['id'], ['name' => 'Updated User']);
print_r($updatedUser);
```

Updates an existing entity with the provided data.

#### Delete Entity

```php
$updatedUser['id'] ="658818a84aaaa";
$deletedUser = $database->delete('users', $updatedUser['id']);
print_r($deletedUser);
```

Deletes an entity by its ID.

### Join Operations

#### Left Join

```php
$leftJoinResult = $database->leftJoin('users', 'orders', 'user_id');
print_r($leftJoinResult);
```

Performs a left join between two entities based on a common field.

#### Cross Join

```php
$crossJoinResult = $database->crossJoin('users', 'products');
print_r($crossJoinResult);
```

Performs a cross join between two entities.

#### One-to-Many Relationship

```php
$oneToManyResult = $database->oneToMany('users', 'orders', 'id', 'user_id');
print_r($oneToManyResult);
```

Establishes a one-to-many relationship between parent and child entities.

### Export to CSV

```php
$csvExportResult = $database->exportToCsv('users');
if ($csvExportResult) {
    echo "Data exported to CSV file: $csvExportResult\n";
} else {
    echo "Failed to export data to CSV.\n";
}
```

Exports data from a specified entity to a CSV file.

### Note

- Adjust the file name and entity names according to your actual data structure.
- Ensure proper error handling and data validation in a production environment.

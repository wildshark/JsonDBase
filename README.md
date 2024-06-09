# JsonDatabase

`JsonDatabase` is a PHP class that provides an easy-to-use interface for managing JSON data files. It supports various operations such as Create, Read, Update, Delete (CRUD), searching, sorting, and exporting/importing data to/from CSV files. This tool is ideal for lightweight data storage needs without the complexity of a full-fledged database management system.

## Features

- Load and save JSON data
- Perform CRUD operations
- Search data by fields or across all fields
- Sort records
- Retrieve file size
- Export data to CSV
- Import data from CSV
- Calculate sum and average of numeric fields
- Range queries and partial matching

## Requirements

- PHP 5.6 or higher

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/JsonDatabase.git
   ```

2. **Include the class in your project:**
   ```php
   require_once 'path/to/JsonDatabase.php';
   ```

## Usage

### Initialization

```php
require_once 'JsonDatabase.php';

// Initialize the database with the JSON file
$database = new JsonDatabase('data.json');
```

### CRUD Operations

**Create a new record:**
```php
$newUser = $database->create('users', ['name' => 'John Doe', 'email' => 'john@example.com']);
print_r($newUser);
```

**Read all records:**
```php
$users = $database->getAll('users');
print_r($users);
```

**Read a record by ID:**
```php
$user = $database->getById('users', 'unique_id_here');
print_r($user);
```

**Update a record:**
```php
$updatedUser = $database->update('users', 'unique_id_here', ['name' => 'Jane Doe']);
print_r($updatedUser);
```

**Delete a record:**
```php
$deletedUser = $database->delete('users', 'unique_id_here');
print_r($deletedUser);
```

### Searching

**Search by specific fields:**
```php
$matches = $database->searchFields('users', ['name', 'email'], 'John Doe');
print_r($matches);
```

**Search across all fields:**
```php
$matches = $database->searchAllFields('users', 'john@example.com');
print_r($matches);
```

**Search for values within a range:**
```php
$matches = $database->searchBetween('users', 'age', 20, 30);
print_r($matches);
```

**Search for partial matches:**
```php
$matches = $database->searchWordsLike('users', 'example');
print_r($matches);
```

### Sorting

**Sort records:**
```php
$sortedUsers = $database->sort('users', 'name', 'asc');
print_r($sortedUsers);
```

### File Management

**Get file size:**
```php
$fileSize = $database->getFileSize();
echo "File size: " . $fileSize;
```

### CSV Export and Import

**Export to CSV:**
```php
$database->exportToCsv('users', 'users.csv');
```

**Import from CSV:**
```php
$database->importFromCsv('users', 'users.csv');
```

### Aggregate Functions

**Calculate sum:**
```php
$totalAmount = $database->sum('transactions', 'amount');
echo "Total amount: " . $totalAmount;
```

**Calculate average:**
```php
$averageAmount = $database->average('transactions', 'amount');
echo "Average amount: " . $averageAmount;
```

## Example JSON Structure

The JSON file should be structured with entities as top-level keys, each containing an array of records. Each record should be an associative array.

```json
{
    "users": [
        {
            "id": "unique_id_1",
            "name": "John Doe",
            "email": "john@example.com",
            "age": 28
        },
        {
            "id": "unique_id_2",
            "name": "Jane Smith",
            "email": "jane@example.com",
            "age": 34
        }
    ],
    "transactions": [
        {
            "id": "transaction_id_1",
            "amount": 100.0,
            "date": "2023-01-01"
        },
        {
            "id": "transaction_id_2",
            "amount": 250.5,
            "date": "2023-01-15"
        }
    ]
}
```

## Contributing

Contributions are welcome! Please submit a pull request or open an issue to discuss any changes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

## Author

[Your Name](https://github.com/yourusername)

## Acknowledgments

- Inspired by the simplicity and versatility of JSON for data storage.
- Special thanks to the PHP community for continuous improvements and support.

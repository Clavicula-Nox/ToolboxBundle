CSV Manager
===========

```php
public function getCSV(string $filePath, string $delimiter = ';'): array
```
Returns an array of values from a CSV file. Set the delimiter of the file with $delimiter var.

```php
public function writeCSV(array $csvDatas, string $filePath = '', string $fileName = '', string $delimiter = ';', string $enclosure = '"'): void
```
Write CSV datas to a file. You can force delimiter or enclosure.

```php
public function generateCSV(array $datas, string $delimiter = ';', string $enclosure = '"'): string
```
Generates a CSV file to a string. You can force delimiter or enclosure.

String Manager
==============

```php
public function washString(string $string): string
```
Replace special chars to regular ones

```php
public function removeAccents($string): string
```
Remove accents from a string

```php
public function removeLetters(string $input): string
```
Remove letters from a string

```php
public function cleanString(string $input): string
```
Replace special chars to regular ones

```php
public function deleteWordsFromString(string $input, array $wordsList): string
```
Delete an array of words from a string

```php
public function stripLineBreaks(string $input): string
```
Remove all line breaks from a string

```php
public function niceSubStr(string $input, int $length = 200): string
```
Does a substr without cutting a word in two

```php
public function stringToLabel(string $input): string
```
Convert a string to a "labeled" version, like hello-you-foo

```php
public function generateRandomString(int $length): string
```
Generates a random string

```php
public function startsWith(string $haystack, string $needle): bool
```
Check if a string starts with another string

```php
public function endsWith(string $haystack, string $needle): bool
```
Check if a string ends with another string

```php
public function removeExtraSpaces(string $input): string
```
Remove extra spaces

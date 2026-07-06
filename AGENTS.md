# AGENTS.md - AI Agent Context for Good Code Parser

This file provides essential context for AI agents (like Claude, Cursor, GitHub Copilot) working with this codebase.

## Project Overview

**Name:** Good Code Parser  
**Purpose:** PHP library for parsing and standardizing product codes from various e-commerce platforms (Coupang, 11th Street, Naver Storefarm, etc.) for WMS (Warehouse Management System) integration  
**PHP Version:** 8.1+  
**License:** MIT  
**Package:** `cable8mm/good-code`

## Architecture

### Design Patterns

- **Value Object Pattern**: `SetGood`, `LocationCode`, `ReceiptCode`, `Sku` are immutable value objects
- **Factory Method Pattern**: Static `of()` methods for instance creation
- **Enum Pattern**: `GoodCodeType` enum for type safety
- **Strategy Pattern**: Callback functions for code transformation

### Core Components

#### 1. GoodCode (Main Class)

**Location:** `src/GoodCode.php`  
**Purpose:** Central parser for all good code types

**Key Concepts:**

- `originType`: Original code type before transformation (OPTION, GIFT, COMPLEX)
- `type`: Current code type after transformation (NORMAL, SET, etc.)
- `code()`: Returns the final transformed code
- `value()`: Returns parsed value (array for SET, string for NORMAL)
- Throws `BadFunctionCallException` for OPTION/GIFT/COMPLEX types (must use callback first)

**Usage Pattern:**

```php
// Normal code - direct use
$code = GoodCode::of('72363')->value(); // '72363'

// Set code - returns array
$code = GoodCode::of('SET1234x2zz5678x1')->value(); // ['1234' => 2, '5678' => 1]

// Complex/Gift/Option - requires callback
$code = GoodCode::of('COM10', callback: fn($key) => $map[$key])->value();
```

#### 2. GoodCodeType (Enum)

**Location:** `src/Enums/GoodCodeType.php`  
**Values:**

- `NORMAL` - Single product code (no prefix)
- `SET` - Multiple products (prefix: SET)
- `COMPLEX` - Alias for SET (prefix: COM)
- `GIFT` - Alias for COMPLEX (prefix: GIF)
- `OPTION` - Product with options (prefix: OPT)

**Detection Logic:** Checks first 3 characters (case-insensitive)

#### 3. SetGood (Value Object)

**Location:** `src/ValueObjects/SetGood.php`  
**Format:** `SET{goodCode}x{count}zz{goodCode}x{count}`  
**Example:** `SET7369x4zz4235x6` → `['7369' => 4, '4235' => 6]`

**Important:**

- Delimiter between products: `zz` (case-sensitive)
- Delimiter between code and count: `x`
- Constructor is private - use `of()` or `ofArray()`
- Throws `InvalidArgumentException` for invalid formats

#### 4. ReceiptCode (Value Object)

**Location:** `src/ReceiptCode.php`  
**Format:** `{prefix}-{Ymd}-{number}`  
**Example:** `PO-20250312-0001`

**Key Features:**

- Auto-increment with `nextCode()`
- Resets to `0001` when date changes
- Default prefix: `PO`
- Public properties: `$prefix`, `$ymd`, `$number`, `$code`

#### 5. LocationCode (Value Object)

**Location:** `src/LocationCode.php`  
**Format:** `{warehouse}-{rack}-{shelf}`  
**Example:** `AUK-R3-S32`

**Key Features:**

- All components are optional (except at least one required)
- Implements `Stringable` for easy casting
- Filters out null/empty values automatically
- Prevents duplicate dashes

#### 6. Sku (Value Object)

**Location:** `src/Sku.php`  
**Format:** `{prefix}{code}`  
**Example:** `PO123`, `123`

**Key Features:**

- Simplest structure
- Prefix is optional
- Implements `Stringable`

## Testing Strategy

### Test Structure

```
tests/
├── GoodCodeTest.php           # Main parser tests
├── LocationCodeTest.php       # Location code tests
├── ReceiptCodeTest.php        # Receipt code tests
├── SkuTest.php               # SKU tests
├── Enums/
│   └── GoodCodeTypeTest.php  # Enum tests
└── ValueObjects/
    └── SetGoodTest.php       # SetGood tests
```

### Test Count

- **Total:** 45 tests, 65 assertions
- All tests use PHPUnit 11.x
- Follow AAA pattern (Arrange-Act-Assert)

### Running Tests

```bash
composer test          # Run all tests
composer test --filter=GoodCodeTest  # Run specific test
```

## Code Conventions

### Naming

- Classes: PascalCase (`GoodCode`, `SetGood`)
- Methods: camelCase (`of()`, `nextCode()`)
- Constants: UPPER_SNAKE_CASE (`DELIMITER`, `DELIMITER_COUNT`)
- Private properties: camelCase with type hints

### Immutability

- All value objects use `readonly` properties where possible
- Constructor is private - use factory methods
- No setters - create new instances for changes

### Error Handling

- Use `InvalidArgumentException` for invalid input
- Use `BadFunctionCallException` for unsupported operations
- Always validate input in `of()` methods before construction

### Type Safety

- Strict type declarations on all methods
- Return types always specified
- Use PHP 8.1+ features (enum, readonly, match)

## Common Pitfalls

### 1. GoodCode::value() Limitations

```php
// ❌ WRONG - Will throw exception
$code = GoodCode::of('COM10', callback: fn($k) => '123');
$value = $code->value(); // BadFunctionCallException

// ✅ CORRECT - Callback transforms to NORMAL first
$code = GoodCode::of('COM10', callback: fn($k) => '123');
$value = $code->value(); // '123' (type is now NORMAL)
```

### 2. SetGood Delimiters

- `zz` is case-sensitive (must be lowercase)
- `x` separates code from count
- Empty payload after SET prefix removal throws exception

### 3. ReceiptCode Date Logic

- `nextCode()` compares with today's date, not stored date
- If dates differ, resets to `0001` with today's date
- Number is stored as string with leading zeros

### 4. LocationCode Empty Values

- Empty strings are filtered out
- `LocationCode::of(warehouse: 'AUK', rack: '')` → `'AUK'`
- At least one non-empty value required

## Extension Points

### Adding New Code Types

1. Add new case to `GoodCodeType` enum
2. Add prefix mapping in `prefix()` method
3. Add detection logic in `of()` method
4. Add transformation logic in `GoodCode::of()` if needed
5. Add tests in `tests/Enums/GoodCodeTypeTest.php`

### Adding New Value Objects

1. Create class in `src/` or `src/ValueObjects/`
2. Implement `Stringable` if string representation needed
3. Use private constructor with static factory methods
4. Add comprehensive edge case tests
5. Document in README.md

## Important Notes for AI Agents

### When Modifying Code

1. **Always run tests:** `composer test` after changes
2. **Check edge cases:** Empty strings, null values, invalid formats
3. **Preserve immutability:** Don't add setters to value objects
4. **Update documentation:** Keep README.md in sync with code changes
5. **Add tests:** Every new feature needs tests

### When Creating Tests

1. Follow AAA pattern
2. Test both success and failure cases
3. Test edge cases (empty, null, invalid)
4. Use descriptive test names
5. Add PHPDoc with examples

### Code Style

- Follow PSR-12 standard
- Use Laravel Pint for formatting: `composer lint`
- Maximum line length: 120 characters
- Use strict comparisons (`===`, `!==`)

## Recent Changes

### 2025-02-04

- Initial release with GoodCode, GoodCodeType, SetGood
- Support for NORMAL, SET, COMPLEX, GIFT, OPTION codes

### 2025-02-21

- Added ReceiptCode for purchase order codes
- Auto-increment functionality with date reset

### 2025-02-24

- Added LocationCode for warehouse locations
- Added Sku for product SKUs
- Implemented Stringable interface on all value objects

### 2025-02-04 (Latest)

- Fixed ReceiptCode::nextCode() date comparison bug
- Enhanced SetGood::pipe() with validation
- Added comprehensive edge case tests (45 tests total)
- Improved error messages
- Fixed README.md documentation errors

## Dependencies

### Production

- PHP 8.1+

### Development

- PHPUnit 9.0|10.0|11.0
- Laravel Pint 1.0 (code style)

## Resources

- **API Documentation:** https://www.palgle.com/good-code/
- **Laravel Integration:** https://github.com/cable8mm/aipro
- **Packagist:** https://packagist.org/packages/cable8mm/good-code
- **GitHub:** https://github.com/cable8mm/good-code

## Quick Reference

### Creating Instances

```php
// GoodCode
GoodCode::of('72363');  // NORMAL
GoodCode::of('SET1234x2zz5678x1');  // SET
GoodCode::of('COM10', callback: fn($k) => $map[$k]);  // COMPLEX
GoodCode::of('GIF11', callback: fn($k) => $map[$k]);  // GIFT
GoodCode::of('OPT10', option: 'Name', callback: fn($k, $o) => $map[$k][$o]);  // OPTION
GoodCode::setCodeOf(['1234' => 2, '5678' => 1]);  // SET from array

// SetGood
SetGood::of('SET1234x2zz5678x1');
SetGood::ofArray(['1234' => 2, '5678' => 1]);

// ReceiptCode
ReceiptCode::of('PO-20250312-0001');
ReceiptCode::of(prefix: 'CT');  // New with custom prefix

// LocationCode
LocationCode::of(warehouse: 'AUK', rack: 'R3', shelf: 'S32');
LocationCode::of(['warehouse' => 'AUK', 'rack' => 'R3']);

// Sku
Sku::of(123, prefix: 'PO');
Sku::of(['code' => 123, 'prefix' => 'PO']);
```

### Common Operations

```php
// Get values
$code->value();  // Parsed value
$code->code();   // Raw code string
$code->type();   // Current type
$code->originalType();  // Original type before transformation

// ReceiptCode operations
$receipt->nextCode();  // Get next sequential code
$receipt->prefix;      // 'PO'
$receipt->ymd;         // '20250312'
$receipt->number;      // '0001'

// String conversion
(string) $locationCode;  // 'AUK-R3-S32'
(string) $receiptCode;   // 'PO-20250312-0001'
(string) $sku;           // 'PO123'
```

## AI Agent Guidelines

### DO:

✅ Run tests after every change  
✅ Add edge case tests for new features  
✅ Preserve backward compatibility  
✅ Update README.md with code changes  
✅ Use type hints and return types  
✅ Follow existing code patterns

### DON'T:

❌ Modify test files to make failing tests pass (fix the code instead)  
❌ Remove existing tests without discussion  
❌ Change public API without updating documentation  
❌ Add dependencies without discussion  
❌ Break immutability of value objects  
❌ Use loose comparisons (`==`, `!=`)

## Contact

**Author:** Sam Lee <cable8mm@gmail.com>  
**GitHub:** https://github.com/cable8mm  
**Website:** https://www.palgle.com

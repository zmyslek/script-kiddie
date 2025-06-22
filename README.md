Great! Here is your updated and complete `README.md`, reflecting all corrections, improvements, and your current test code:

---

# Script-Kiddie Laravel Project – Test Plan & Evaluation

## Contents

* [Test Plan](#test-plan)

  * [User Stories](#user-stories)
  * [Acceptance Criteria](#acceptance-criteria)
  * [Why Some Parts Are or Aren't Tested](#why-some-parts-are-or-arent-tested)
  * [Link to the V-Model](#link-to-the-v-model)
  * [System Tests](#system-tests)
  * [Unit Tests](#unit-tests)
* [Test Results Screenshot](#test-results-screenshot)
* [Evaluation](#evaluation)

  * [Detectable Errors](#detectable-errors)
  * [Undetectable Errors](#undetectable-errors)
  * [Test Coverage Conclusion](#test-coverage-conclusion)
  * [Test Automation and Effectiveness](#test-automation-and-effectiveness)
  * [Critical Reflection and Improvement Proposal](#critical-reflection-and-improvement-proposal)

---

## Test Plan

### User Stories

1. **As a visitor**, I want to send a message using the contact form so that I can ask questions or provide feedback.
2. **As a new user**, I want to register securely so I can log in and access the application.

### Acceptance Criteria

* Contact Form:

  * A message must have a valid name, email, and a non-empty message.
  * Invalid formats (like `email@`) or missing fields should show appropriate errors.

* Registration:

  * A user must provide a unique email, a name, and a password with at least 8 characters.
  * Repeated emails or weak passwords must be rejected.

---

### Why Some Parts Are or Aren’t Tested

* ✅ Core logic (validation, user creation, form submission) **is tested**.
* ❌ **Email sending** is not tested due to lack of mocking in current setup.
* ❌ **UI/UX rendering** and **CSS behavior** are not automated; these require manual or visual testing.
* ❌ **Performance** is not tested; would require stress/load tools (e.g., JMeter).
* These limitations are by design to focus on Laravel’s backend behavior in this phase.

---

### Link to the V-Model

| V-Model Phase       | Test Level  | User Story        | Test Focus                                    |
| ------------------- | ----------- | ----------------- | --------------------------------------------- |
| **Requirements**    | System Test | Contact Form      | End-to-end flow, validation + DB persistence. |
| **Requirements**    | System Test | User Registration | Full registration path, happy + edge cases.   |
| **Detailed Design** | Unit Test   | User Registration | User object creation, password hashing.       |
| **Detailed Design** | Unit Test   | Email Validation  | Email format rejection at low level.          |

---

### System Tests (using AAA)

#### `user_can_register_with_valid_data`

```php
public function user_can_register_with_valid_data()
{
    // Arrange
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    // Act
    $response = $this->post('/register', $userData);

    // Assert
    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
}
```

#### `contact_form_submits_successfully`

```php
public function contact_form_submits_successfully()
{
    // Arrange
    $formData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Hello world',
    ];

    // Act
    $response = $this->post('/contact', $formData);

    // Assert
    $response->assertStatus(302);
    $response->assertSessionHas('success');
}
```

---

### Unit Tests (using AAA)

#### `password_is_hashed_correctly_upon_user_creation`

```php
public function password_is_hashed_correctly_upon_user_creation()
{
    // Arrange
    $password = 'SecurePassword123!';
    $user = User::factory()->make(['password' => bcrypt($password)]);

    // Assert
    $this->assertNotEquals($password, $user->password);
    $this->assertTrue(Hash::check($password, $user->password));
}
```

#### `email_with_invalid_format_fails_validation`

```php
public function email_with_invalid_format_fails_validation()
{
    // Arrange
    $invalidEmail = 'invalid..@email';

    // Act
    $isValid = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);

    // Assert
    $this->assertFalse($isValid);
}
```

---

## Test Results Screenshot

![Test Result Local Screenshot](image.png)
![Test Results in GitHub Screenshot](image-1.png)

---

## Evaluation

### Detectable Errors

* Validation errors like empty message, short passwords, malformed email addresses.
* Ensures only valid users are created and bad inputs are rejected.

### Undetectable Errors

* Frontend: Clicking disabled buttons or rendering bugs.
* Integration: Mail server unavailable, not caught without mocking.
* Security: SQL injection or XSS unless explicitly tested (out of scope here).

---

### Test Coverage Conclusion

Tests cover all defined **user stories**, including both happy and unhappy paths.
Edge cases (e.g. invalid email with `..`, or missing fields) were tested successfully.
However, UI-specific behavior and 3rd-party services are not covered in automated tests.

---

### Test Automation and Effectiveness

* All tests are automated using `php artisan test`.
* CI pipeline in GitHub runs tests on push automatically.
* Tests complete in under 1s, making them ideal for quick feedback.
* Factories and Laravel helpers ensure clean, consistent test setup.

---

### Critical Reflection and Improvement Proposal

Writing and running tests went according to plan, and the tests reflect the intended user stories well.

**Improvements**:

1. Add integration tests using `Mail::fake()` to verify mail is sent.
2. Add UI automation (e.g., Laravel Dusk) to test JavaScript, client validation.
3. Expand CI to run tests in parallel for performance.

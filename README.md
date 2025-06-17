# Script-Kiddie Laravel Project - Test Plan & Evaluation

## Contents
- [Test Plan](#test-plan)  
  - User Stories  
  - Link to the V-Model  
  - System Tests  
  - Unit Tests  
  - Why Certain Parts Are or Aren't Tested  
- [Test Results Screenshot](#test-results-screenshot)  
- [Evaluation](#evaluation)  
  - Detectable Errors  
  - Undetectable Errors  
  - Test Coverage Conclusion  
  - Test Automation and Effectiveness  
  - Critical Reflection and Improvement Proposal  

---

## Test Plan

### User Stories

1. **Contact Form Submission**  
   - Happy path: User fills in valid name, email, and message, and submits successfully.  
   - Unhappy path: User submits with invalid or missing fields, validation errors are shown.

2. **User Registration**  
   - Happy path: User provides valid registration data and is registered successfully.  
   - Unhappy path: User submits incomplete or invalid registration data, errors are displayed.

---

### Link to the V-Model

| User Story                | V-Model Phase            | Description                                                        |
|---------------------------|--------------------------|--------------------------------------------------------------------|
| Contact Form Submission   | System Testing           | Tests entire contact form submission including validation & UI.   |
|                           | Unit Testing             | Tests validation logic and controller methods individually.       |
| User Registration         | System Testing           | Tests full registration process through the web interface.        |
|                           | Unit Testing             | Tests user model validation rules and registration service logic. |

Each user story includes system tests for both happy and unhappy paths, as well as unit tests verifying underlying logic.

---

### System Tests per User Story

- **Contact Form**  
  - Successful form submission with valid input.  
  - Form submission with missing or invalid data resulting in validation errors.

- **User Registration**  
  - Successful registration flow with valid input.  
  - Registration attempt with missing or invalid data showing appropriate errors.

---

### Unit Tests per User Story

- **Contact Form**  
  - Validation rules for `name`, `email`, and `message`.  
  - Controller method behavior on valid and invalid input.

- **User Registration**  
  - Validation rules on registration data.  
  - User creation logic and database persistence.

---

### Why Certain Parts Are or Aren't Tested

The tests focus on core functionalities critical to user interaction and data integrity, such as input validation and successful data submission. External integrations (like email sending), UI/UX design, and performance under heavy load are not tested here due to their specialized nature, requiring dedicated integration, manual, or performance testing. This choice ensures the scope remains manageable and focused on validating business-critical logic.

---

## Test Results Screenshot

*Include a screenshot named `testscreenshot.png` showing all tests passing.*

![Test Results Screenshot](./testscreenshot.png)

---

## Evaluation

### Detectable Errors by Tests

- Invalid or missing input data triggering validation errors.  
- Successful handling and persistence of valid data submissions.  
- Proper response handling for both success and error scenarios.

### Undetectable Errors by Tests

- Frontend UI/UX issues unrelated to form validation or submission.  
- Performance bottlenecks or server/database failures under stress.  
- Failures in external systems such as email servers or third-party APIs.  
- Security vulnerabilities beyond input validation scope.

### To What Extent Can We Conclude “Everything Works Correctly”?

The current tests cover core functional and validation scenarios, providing confidence that key features behave correctly under both valid and invalid inputs. However, they do not guarantee flawless operation in all scenarios. For a more comprehensive assurance, additional layers of testing—such as integration tests, UI automation, security assessments, and load testing—are recommended.

### Test Automation and Effectiveness

All tests are automated and can be executed using the `php artisan test` command. In a full development pipeline, these tests should be integrated with a Continuous Integration (CI) system to run automatically on every code push, ensuring immediate feedback on code quality and preventing regressions.

### Critical Reflection and Improvement Proposal

While the test suite effectively validates main functionalities, its current limitation is the absence of integration and UI automation tests. Introducing integration tests would verify end-to-end workflows including database and external service interactions. Automated UI tests (e.g., Laravel Dusk) could catch frontend issues missed by backend tests. Adding these would enhance robustness and reduce manual testing effort.

---

# Notes

- Tests follow the Arrange-Act-Assert (AAA) pattern consistently.  
- Both happy and unhappy paths are covered at unit and system levels.  
- Factories are used for setting up test data where applicable.  
- Tests are ready to be integrated into CI pipelines for automatic execution.

---

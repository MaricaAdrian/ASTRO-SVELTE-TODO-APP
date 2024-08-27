## To Do App with Astro, Svelte, Tailwind CSS, and Symfony

This project is a full-stack To Do application featuring:

- **Frontend:**
    - Astro for rapid server-side rendering and file-based routing
    - Svelte for interactive UI components and state management
    - Tailwind CSS for utility-first styling
- **Backend:**
    - Symfony for robust and secure API building
    - JWT (JSON Web Token) for user authentication and authorization

### Getting Started

**Prerequisites:**

- Node.js (version 20.16.0 or later): [https://nodejs.org/en/download/package-manager](https://nodejs.org/en/download/package-manager)
- Composer (PHP dependency manager): [https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md](https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md)
- PHP (version 8.2 or later): [https://www.php.net/downloads.php](https://www.php.net/downloads.php)
- A code editor or IDE of your choice

**Installation:**

1. Clone this repository.
2. Navigate to the project directory:

   ```bash
   cd to-do-app
   ```

3. Install frontend dependencies:

   ```bash
   npm install
   ```

4. Install backend dependencies:

   ```bash
   composer install
   ```

**Development Server:**

1. Start the development server to run frontend application:

   ```bash
   npm run dev
   ```

   This will typically start the server on `http://localhost:4321` (adjust the port if necessary).

**Project Structure:**

```
frontend/    # Astro frontend code
    - src/    # Application source files
        - App.astro     # Main app component
        - components/  # Reusable Svelte components
        - ...          # Other frontend code
backend/     # Symfony backend code
    - config/    # Configuration files
    - public/    # Publicly accessible files
    - src/       # Application source files
        - Controller/  # Controllers
        - Entity/     # Entities
        - Repository/  # Repositories
        - ...          # Other backend code
composer.json # Composer project configuration
package.json  # npm project configuration
README.md     # This file
```

**API Calls and JWT Authentication:**

- The backend provides RESTful API endpoints for To Do list management.
- Authentication uses JWTs stored in cookies. Refer to the Symfony documentation for specific implementation details.

### Contributing

We welcome contributions to this project! Please follow these guidelines:

- Fork the repository.
- Create a new branch for your changes.
- Commit your changes with clear and concise messages.
- Create a pull request to get your changes reviewed and merged.

### License

This project is licensed under the [MIT License](https://choosealicense.com/licenses/mit/).
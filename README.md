<h1>TRACKIT WEB APP</h1>

Task Manager is a web-based application designed to help users organize, manage, and track their tasks efficiently. It offers a user-friendly interface, allowing users to add, edit, and delete tasks while categorizing them for better organization. 

<h2>FEATURES</h2>

- User registration and authentication
- Create, edit, and delete tasks
- Categorize tasks (e.g., Work, Personal, Shopping)
- Filter tasks by category
- Responsive design for mobile and desktop users

<h2>TECHNOLOGY STACK</h2>

- HTML
- CSS
- Bootstrap 5
- JavaScript
- PHP
- MySQL

## INSTALLATION

To set up the Task Tracker project locally, follow these steps:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/ElvissRukundo/task-manager.git
    cd task-manager
    ```

2. **Set up the database**:
    - Create a new MySQL database 'task'.
    - Import the SQL schema provided in `assets/db/task.sql`

3. **Configure your environment**:
    - Update the database connection settings in `assets/include/db.php`.

4. **Run a local server**:
    - Use a local server like XAMPP or WAMP to serve your PHP files. Place the project folder in the `htdocs` directory (for XAMPP).

5. **Access the application**:
    - Open your browser and navigate to `http://localhost/task-manager`.

## Usage

1. **Register an account**:
    - Click on the "Sign Up" button to create a new account.

2. **Login**:
    - Use your credentials to log into the application.

3. **Manage Tasks**:
    - Add new tasks using the input field.
    - Categorize tasks and filter them as needed.
    - Edit or delete tasks as required.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [Bootstrap](https://getbootstrap.com/) for the responsive CSS framework.
- [PHP](https://www.php.net/) for server-side scripting.
- [MySQL](https://www.mysql.com/) for the database management system.

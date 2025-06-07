# Database setup
- Install MySQL
    - Update all the packages<br>
      ```sudo apt update```
    - Install MySQL Server<br>
      ```sudo apt install mysql-server```
- Create the project's database
    - Enter the MySQL shell<br>
      ```sudo mysql -u root -p```
    - Query to create the tasks' database<br>
      ```sql
        CREATE DATABASE task_test;
      ```
- Create the DB's user (and grant the necessary permissions)
    - ```sql
        CREATE USER 'constellation'@'localhost' IDENTIFIED BY 'newPassword';
        ```
    - ```sql
        GRANT ALL PRIVILEGES ON task_test.* TO 'constellation'@'localhost';
        ```
    - ```sql
        FLUSH PRIVILEGES;
        ```
- Exit the MySQL shell
    ```sql
     EXIT;
    ```
- Create the tasks' table
    - Login to the database<br>
        ```mysql -u constellation -p task_test```
    - Run the following query to create the database
        ```sql 
            CREATE TABLE `tasks` (
                `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `Title` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
                `Description` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
                `Due_Date` DATETIME NOT NULL,
                `Done` TINYINT NOT NULL DEFAULT 0,
                `Set_Date` DATETIME NOT NULL,
                PRIMARY KEY (`ID`)
            ) COLLATE='utf8mb4_general_ci' ENGINE=InnoDB;
        ```
- Start the MySQL Server<br>
    ```sudo systemctl start mysql```
    
<br>
<br>

# Change DB access information
If some other info is used on the database (like for example, another user or password), those details can be configured on the ```classes\db.php``` file.
    
<br>
<br>

# PHP setup
- Install PHP and it's extensions
    - Update all the packages<br>
    ```sudo apt update```
    - Install PHP and the extensions <br>
    ```sudo apt install php php-cli php-mbstring php-xml php-curl php-sqlite3```
    - Check the installed php version <br>
    ```php -v``` (on this project's creation date, the version was 8.3.6)
    
<br>
<br>

# Run the project
- Start the project's server<br>
    ```php -S localhost:8000``` (this will start the server in the localhost, on the port 8000)
    - Run this command while inside the project's folder
- Access the URL (localhost:8000) on a browser
    
<br>
<br>

# Manage tasks
- After accessing the project's URL (localhost:8000) on a browser:
    - Fill in the "Task Title", "Task Description" and "Due Date" fields
    - Click on "Add Task"
- To mark a task as done or not done:
    - Click on the first button, on the left of each task
    - The button's icon and color changes according to the task's completion state
    - When a task is completed, the entire row will change color to green.
- To delete a task from the table
    - Click on the last button, on the right of each task
    - Before the task is deleted, a confirmation message will be shown so accidental deletions can be prevented
- The "Days Left" column's text will change to "Overdue" when the value is 0 or less. When this happens the text will also turn red.
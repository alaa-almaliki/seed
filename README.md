# seed

**seed** automates the tasks that are done repeatedly and frequently to remove production and test server variables from SQL dump files.

Command `bin/seed path/to/file.sql --profile www.example.com --delete-file`

The command above will do the following:
- Performs find and replace using sed commands on the SQL file.
- Imports The SQL file into MySQL inside the container.
- Runs DDL commands
  - Insert new data
  - Update existing data
  - Delete data
  - Truncate tables
  - Drop Tables
- Runs **mysqldump** command as the final step given you a new SQL dump file inside **code/db/seed-{database_name}-{timestamp}.sql**
- If the option **--delete-file** was provided, it will delete the original SQL file **path/to/file.sql**

## How it works

###### Command glossary

| Command                                                                      | Summary                                                                                                                                               |
|------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|
| `bin/seed set:path`                                                          | Sets the bin path in .zshrc, so you can use **seed** from anywhere in the terminal. Then you can do like `seed build --no-cache`                      |
| `bin/seed build [--no-cache]`                                                | Builds the container, optionally with arguments                                                                                                       |
| `bin/seed rebuild`                                                           | Rebuilds the container from scratch                                                                                                                   |
| `bin/seed up`                                                                | Starts the container                                                                                                                                  |
| `bin/seed stop`                                                              | Stops the container                                                                                                                                   |
| `bin/seed restart`                                                           | Restarts the container                                                                                                                                |
| `bin/seed destroy`                                                           | Destroys the container                                                                                                                                |
| `bin/seed chown`                                                             | Fixes filesystem ownership                                                                                                                            |
| `bin/seed ssh`                                                               | Access into the container                                                                                                                             |
| `bin/seed mysql`                                                             | Access mysql interactive shell                                                                                                                        |
| `bin/seed host:mysql`                                                        | Allow you to access the database from any MySQL client through container private network using host 0.0.0.0, port:3307 user:root and password:root    |
| `bin/seed composer {install}`                                                | Runs composer inside the container                                                                                                                    |
| `bin/seed profiles`                                                          | Runs profiles actions as create, delete, copy and list                                                                                                |
| `bin/seed copy_to_container {folder_name}`                                   | Copy Filesystem from host **./code/** to container **/var/www/html**                                                                                  
| `bin/seed copy_from_container {folder_name}`                                 | Copy Filesystem from container **/var/www/html** to host **./code/**                                                                                  
| `bin/seed seed path/to/file.sql --profile {www.example.com} [--delete-file]` | Runs seed, to clean up your local database<br/>file is required<br/>profile is required<br/>delete-file will delete the original SQL file if provided |

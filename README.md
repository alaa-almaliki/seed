# seed

**seed** automates the tasks that are done repeatedly and frequently to remove production and test server variables from
SQL dump files and replaces them with local environment variables.

Command `bin/seed path/to/file_name.sql --profile www.example.com --delete-file`

The command above will do the following:

- Copies the file `path/to/file_name.sql` to `code/db/file_name.sql`
- Reads the configurations in `profiles/www.example.com/env.php` to set up tasks
- Performs find and replace using sed commands on the SQL file.
- Imports The SQL file into MySQL inside the container.
- Runs DDL commands
    - Insert new data
    - Update existing data
    - Delete data
    - Truncate tables
    - Drop Tables
- Runs `mysqldump` command as the final step given you a new SQL dump file inside
  `code/db/seed-{database_name}-{timestamp}.sql`
- If the option `--delete-file` was provided, it will delete the copied SQL file `code/db/file_name.sql`

> [!NOTE]
> seed Used and tested on **macOS** only. You are free to try it in windows or linux and contribute.

## How it works

### 1. Setup `seed`

- Clone the repo `git@github.com:alaa-almaliki/seed.git`
- Go into seed folder - `cd seed`
- Build the container `bin/seed build`
- Run composer `bin/seed composer install`
- Optionally set the path of seed script `bin/seed set:path` so you can access the script from anywhere

### 2. Setup profiles

After building the **seed** container, you can do the following:

- Run `bin/seed profiles create www.example.com`
- This will create `code/profiles/www.example.com/env.php` file
- Configure `env.php` file as you wish
    - Section `mysql` is the MySQL database credentials and options you wish to create inside the **seed** container
    - Section `mysqldump` will be the settings related the database export in the final step
    - Section `sed` is the find and replace settings, it will be performed on SQL file before the import
    - Section `ddl` has the following settings:
        - `insert` will insert new rows to a given table
        - `update` will update existing rows in a given table
        - `delete` will delete rows from a given table
        - `truncate` will truncate tables
        - `drop` will drop tables

### 3. Running `seed`

After setting up profiles, you can run **seed** as follows:

- Run `bin/seed path/to/file_name.sql --profile www.example.com --delete-file`
- Wait for the script to finish
- Once done, the file `code/db/seed-{database_name}-{timestamp}.sql` will be available for you to use

## Profiles

The command `bin/seed profiles` has the following:

- `bin/seed profiles create [profile-name]` will create a profile with a given name
- `bin/seed profiles delete [profile-name]` will delete a profile
- `bin/seed profiles copy [profile-name-1] [profile-name-2]` will duplicate/copy a profile
- `bin/seed profiles list` will list profiles

## Command glossary

| Command                                                                      | Summary                                                                                                                                                                                        |
|------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `bin/seed set:path`                                                          | Sets the bin path in .zshrc, so you can use **seed** from anywhere in the terminal. Then you can do like `seed build --no-cache`                                                               |
| `bin/seed build [--no-cache]`                                                | Builds the container, optionally with arguments                                                                                                                                                |
| `bin/seed rebuild`                                                           | Rebuilds the container from scratch                                                                                                                                                            |
| `bin/seed up`                                                                | Starts the container                                                                                                                                                                           |
| `bin/seed stop`                                                              | Stops the container                                                                                                                                                                            |
| `bin/seed restart`                                                           | Restarts the container                                                                                                                                                                         |
| `bin/seed destroy`                                                           | Destroys the container                                                                                                                                                                         |
| `bin/seed chown`                                                             | Fixes filesystem ownership                                                                                                                                                                     |
| `bin/seed ssh`                                                               | Access into the container                                                                                                                                                                      |
| `bin/seed mysql`                                                             | Access mysql interactive shell                                                                                                                                                                 |
| `bin/seed host:mysql`                                                        | Allow you to access the database from any MySQL client through container private network using host 0.0.0.0, port:3307 user:root and password:root. See `CONTAINER_IP` variable in `.env` file |
| `bin/seed composer {install}`                                                | Runs composer inside the container                                                                                                                                                             |
| `bin/seed profiles`                                                          | Runs profiles actions as create, delete, copy and list                                                                                                                                         |
| `bin/seed copy_to_container {folder_name}`                                   | Copy Filesystem from host **./code/** to container **/var/www/html**                                                                                                                           |
| `bin/seed copy_from_container {folder_name}`                                 | Copy Filesystem from container **/var/www/html** to host **./code/**                                                                                                                           |
| `bin/seed seed path/to/file.sql --profile {www.example.com} [--delete-file]` | Runs seed, to clean up your local database<br/>file is required<br/>profile is required<br/>delete-file will delete the original SQL file if provided                                          |

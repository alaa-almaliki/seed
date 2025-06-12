# seed
A MySQL database cleanser. It will perform sed operation on the SQL file, then import and run various SQL queries to make sure your local database as you would expect, removing all production and staging variables.
All done by configurations you provide

## How it works


###### Command glossary
| Command                                                                  | Summary                                                                                                                                               |
|--------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|
| `bin/seed set:path`                                                      | Sets the bin path in .zshrc, so you can use **seed** from anywhere in the terminal. Then you can do like `seed build --no-cache`                      |
| `bin/seed build [--no-cache]`                                            | Builds the container, optionally with arguments                                                                                                       |
| `bin/seed rebuild`                                                       | Rebuilds the container from scratch                                                                                                                   |
| `bin/seed up`                                                            | Starts the container                                                                                                                                  |
| `bin/seed stop`                                                          | Stops the container                                                                                                                                   |
| `bin/seed restart`                                                       | Restarts the container                                                                                                                                |
| `bin/seed destroy`                                                       | Destroys the container                                                                                                                                |
| `bin/seed chown`                                                         | Fixes filesystem ownership                                                                                                                            |
| `bin/seed ssh`                                                           | Access into the container                                                                                                                             |
| `bin/seed mysql`                                                         | Access mysql interactive shell                                                                                                                        |
| `bin/seed host:mysql`                                                    | Allow you to access the database from any MySQL client through container private network using host 0.0.0.0, port:3307 user:root and password:root    |
| `bin/seed composer`                                                      | Runs composer inside the container                                                                                                                    |
| `bin/seed profiles`                                                      | Runs profiles actions as create, delete, copy and list                                                                                                |
| `bin/seed seed path/to/file.sql --profile www.example.com --delete-file` | Runs seed, to clean up your local database<br/>file is required<br/>profile is required<br/>delete-file will delete the original SQL file if provided |



## export path `export PATH="./seed/bin:$PATH"` in ~/.zsrhc


## To access databases from the host:

```shell
mysql -e "GRANT USAGE ON *.* to root@192.168.148.1 IDENTIFIED BY 'root';"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO root@192.168.148.1 WITH GRANT OPTION;"
```

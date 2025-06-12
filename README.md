# seed
A MySQL database cleanser. It will perform sed operation on the SQL file, then import and run various SQL queries to make sure your local database as you would expect, removing all production and staging variables.
All done by configurations you provide

## How it works


###### Commands glossary
| Command                                                                  | Summary                                                                                                                                               |
|--------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|
| `bin/seed set:path`                                                      | sets the bin path in .zshrc, so you can use **seed** from anywhere in the terminal. The you can do like `seed build --no-cache`                       |
| `bin/seed build [--no-cache]`                                            | builds the container, optionally with arguments                                                                                                       |
| `bin/seed rebuild`                                                       | rebuilds the container from scratch                                                                                                                   |
| `bin/seed up`                                                            | starts the container                                                                                                                                  |
| `bin/seed stop`                                                          | stops the container                                                                                                                                   |
| `bin/seed restart`                                                       | restarts the container                                                                                                                                |
| `bin/seed destroy`                                                       | destroys the container                                                                                                                                |
| `bin/seed chown`                                                         | fixes filesystem ownership                                                                                                                            |
| `bin/seed ssh`                                                           | access into the container                                                                                                                             |
| `bin/seed mysql`                                                         | access mysql interactive shell                                                                                                                        |
| `bin/seed host:mysql`                                                    | Allow you to access the database from any MySQL client through container private network using host 0.0.0.0, port:3307 user:root and password:root    |
| `bin/seed composer`                                                      | runs composer inside the container                                                                                                                    |
| `bin/seed profiles`                                                      | runs profiles actions as create, delete, copy and list                                                                                                |
| `bin/seed seed path/to/file.sql --profile www.example.com --delete-file` | runs seed, to clean up your local database<br/>file is required<br/>profile is required<br/>delete-file will delete the original SQL file if provided |



## export path `export PATH="./seed/bin:$PATH"` in ~/.zsrhc


## To access databases from the host:

```shell
mysql -e "GRANT USAGE ON *.* to root@192.168.148.1 IDENTIFIED BY 'root';"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO root@192.168.148.1 WITH GRANT OPTION;"
```

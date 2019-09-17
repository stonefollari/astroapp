Website / WebApp to display the locally visible constellations.

### Cloning and navigating to the project files

- Open cmd or PowerShell (or terminal on Mac, or whatever)
- Navigate to the the location you want the astroapp folder by `$ cd` command. If you are using xampp and have not configured an [alias](https://stackoverflow.com/questions/8121720/how-setup-alias-on-xampp-dev-machine) which is very convinient for development, navigate to the htdocs typically `C:\xampp\htdocs`
- Type `$ git clone [url_of_repo]` in the console. I'd reccommend configuring [SSH](https://help.github.com/en/enterprise/2.15/user/articles/adding-a-new-ssh-key-to-your-github-account), which makes using git easier.
- Navigate into the repo folder by typing `$ cd astroapp`
- It is recommended to work in your own branch; push/pull changes there until ready to merge changes with master. Create a branch with `$ git checkout -b [name_of_new_branch]`.
- To switch branches, type `git checkout [branch_name]`

### Setting up Environment Variables

- A sample .env file is in the repo. It should contain a template for all of the environment variables used in the project. Open the file.
- Create a new file with no name, and extension `.env`. (This is done by saving the file type as 'All files (*.*)', with the name `.env`
- In the new `.env` file, give values for all values that the `.env.example` file has.

### Connecting (via proxy) to the SQL Server
- Open the .txt file that has the command for proxying to the server.
- Copy the command in the file, and paste it into the console. This will run the .exe, using the credentials in the repo (the .json file), and connect to the sql server. This uses localhost on port 3306 to act as a proxy to the server. ( `'127.0.0.1:3306` )
- In PHP, the `mysqli()` will successfully connect to the SQL server if the proxy is running, and the credentials (in the `.env` file) are valid.

I wish to have the .json credentials no longer on the github, but this requires us to create and use all our own from gcloud: which can wait until another day.


### Notes
To load the environment variables, the library [phpdotenv](https://github.com/vlucas/phpdotenv) is used. It is installed and managed with [Composer](https://getcomposer.org/). It required installing Composer, installing phpdotenv with composer, and running `composer install` in the repo to get it all working. The necessecary files are in the repo, so none of this should be required for general use; I don't think. If you are getting errors let me (Stone) know.


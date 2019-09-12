Website / WebApp to display the locally visible constellations.

### Cloning and navigating to the project files

Currently the server branch holds the server files -- as I am still implementing things.

- Open cmd or PowerShell (or terminal on Mac, or whatever)
- Navigate to the the location you want the astroapp folder by `cd` command. If you are using xampp (and have not configured an [https://stackoverflow.com/questions/8121720/how-setup-alias-on-xampp-dev-machine](alias) -- which is very convinient for development), navigate to the htdocs (typically `C:\xampp\htdocs`)
- type `git clone <URL of repo>` in the console [https://help.github.com/en/enterprise/2.15/user/articles/adding-a-new-ssh-key-to-your-github-account](link on how to set up SSH, which makes git a lot easier once done)
- Navigate into the repo folder by typing `cd astroapp`
- To switch branches, type `git checkout <branch_name>`, in this case, `git checkout server` 


### Connecting (via proxy) to the SQL Server
- Open the .txt file that has the command for proxying to the server.
- Copy the command in the file, and paste it into the console. This will run the .exe, using the credentials in the repo (the .json file), and connect to the sql server. This uses localhost on port 3306 to act as a proxy to the server. ( `'127.0.0.1:3306` )
- In PHP, fill the `mysqli()` function with it's correct parameters. You will have to contact me (Stone), in the time being, and I will send you the params.

### Future
I hope to have the .env file properly implemented, meaning you can store the sensetive info, like passwords, there, in your local machine. It will not be uploaded to git once configured. And once everyone is added to gcloud, we can give everyone a different proxy private key (the .json in the repo), which will also not be uploaded to git once configured.

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

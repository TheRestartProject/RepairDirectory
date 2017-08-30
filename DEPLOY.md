# Deployment

Currently deployment is not automated on the Vidahost servers due to 
issues with running commands across SSH in that environment. 

## Download

The first step in the deployment process is to download the latest artifact. 

### Gitlab
If you are using the Gitlab CI pipeline then you can run the following command 
to download the latest version if it exists

    ./download.gitlab.sh
    
### FTP

Alternatively you can provide your own artifact by uploading a zip file of the project,
making sure that you have run the following build commands

* Install composer dependencies `composer install`
* Install node dependencies `yarn` or `npm install`
* Build front-end assets `npm run production`

Additionally you can also delete the following folders

* `.git`
* `docker`
* `node_modules`

Once you've done this, zip it up and ftp it onto the server and give it the name
of `repairmap.zip`.

## Deployment

With a built version of the site in a zip file called `repairmap.zip`, you can now
run the second part of the deployment

    ./deploy.sh
    
This will unzip the build artifact from `repairmap.zip` and zip it into place, and then
copy the public part of the application to the appropriate folderin the public directory 
of the fixometer application. 
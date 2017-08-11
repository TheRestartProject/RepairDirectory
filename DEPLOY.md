# Deployment

Currently deployment is not automated on the Vidahost servers due to 
issues with running commands across SSH in that environment. 

To deploy a new version of the site, you will need to ssh onto the
server using the credentials provided by Neil. 

Run the following command 

    ./deploy.sh
    
This will download the latest version, unzip it into place, and then
copy the public part of the application to the appropriate folder
in the public directory of the fixometer application. 
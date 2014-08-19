# Elastic Beanstalk + PHP Demo App - "Share Your Thoughts"

This demo app shows you how to run a simple PHP application on AWS Elastic Beanstalk.

## Run the App
Follow the steps below to deploy the demo application to an Elastic Beanstalk PHP environment. Accept the default settings unless indicated otherwise in the steps below:

1. Download the ZIP file from the [Releases section](https://github.com/awslabs/eb-demo-php-simple-app/releases) of this repository.
2. Login to the [Elastic Beanstalk Management Console](https://console.aws.amazon.com/elasticbeanstalk)
3. Click `Create New Application` and give your app a name and description
4. Choose 'PHP' in the 'Predefined configuration' dropdown and click `Next`
5. Upload the ZIP file downloaded in Step 1
6. Choose 'Create an RDS DB Instance with this environment' in the 'Additional Resources' step
7. Allocate 5GB of storage and provide a username and password for your database
8. Review and launch the application

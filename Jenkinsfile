pipeline {
    agent none

    stages {
        stage('Build') {
            steps {
                if(!fileExists("/var/lib/jenkins/workspace/devops"))
                {
                    sh "mkdir /var/lib/jenkins/workspace/devops"
                }
                // if(!fileExists("/var/lib/jenkins/workspace/devops"))
                // {
                //
                // }
                // echo "Downloading dependencies"
                // checkout scm
                //
                // sh "composer install"
            }
        }
        stage('Test') {
            steps {
                // sh "./vendor/bin/phpunit"
            }
        }
    }
}

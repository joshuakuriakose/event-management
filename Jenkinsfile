pipeline {
    agent any
    environment {
        DOCKER_HOST = 'tcp://host.docker.internal:2375'
    }
    stages {
        stage('Clone') {
            steps {
                git branch: 'main', url: 'https://github.com/joshuakuriakose/event-management.git'
            }
        }

        stage('Build Image') {
            steps {
                sh 'docker build -t event-management-app .'
            }
        }

        stage('Run Container') {
            steps {
                sh 'docker-compose -f docker-compose.yml up -d --build'
            }
        }

        stage('Test') {
            steps {
                sh '''
                    docker build -f Dockerfile.selenium -t selenium-runner .
                    docker run --rm selenium-runner
                '''
            }
        }
    }
}

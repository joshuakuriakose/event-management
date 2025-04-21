pipeline {
    agent any

    environment {
        XAMPP_PATH = "C:\\xampp"
        DEPLOY_PATH = "\"${XAMPP_PATH}\\htdocs\\EventManagement\""
        PHP_PATH = "C:\\xampp\\php\\php.exe"
        APACHE_START = "\"${XAMPP_PATH}\\apache\\bin\\httpd.exe\""
        APACHE_STOP = "\"${XAMPP_PATH}\\apache\\bin\\httpd.exe\" -k shutdown"
    }

    stages {
        stage('Stop Apache Server') {
            steps {
                echo '🛑 Stopping Apache server...'
                bat '"%APACHE_STOP%"'
            }
        }

        stage('Start Apache Server') {
            steps {
                echo '🚀 Starting Apache server...'
                bat '"%APACHE_START%"'
            }
        }

        stage('Checkout Code') {
            steps {
                echo '📦 Cloning repository...'
                checkout scm
            }
        }

        stage('PHP Lint Check') {
            steps {
                echo '🔍 Running PHP lint check...'
                bat '''
                set PHP_PATH=%PHP_PATH%
                for /R %%f in (*.php) do (
                    echo Checking %%f...
                    "%PHP_PATH%" -l "%%f" || exit /b 1
                )
                '''
            }
        }

        stage('Deploy to XAMPP') {
            steps {
                echo '🚚 Deploying to XAMPP htdocs...'
                bat '''
                if exist "%DEPLOY_PATH%" rmdir /s /q "%DEPLOY_PATH%"
                mkdir "%DEPLOY_PATH%"
                xcopy /E /I /Y "Event management project\\*" "%DEPLOY_PATH%"
                '''
            }
        }

        stage('Open in Browser') {
            steps {
                echo '🌐 Opening project in browser...'
                bat 'start "" "http://localhost/EventManagement/login.php"'
            }
        }
    }

    post {
        failure {
            echo '❌ Build failed!'
        }
        success {
            echo '✅ Build completed successfully!'
        }
    }
}

# Email Sender

This project is a Symfony application that allows sending emails to users by category.

## Prerequisites

- Docker
- Docker Compose

## Setup

1. **Clone the repository:**
   ```sh
   git clone <repository-url>
   cd <repository-directory>
    ```
2. **Build and start the Docker services:**
    ```sh
    make build
    make start
    ```
3. **Install PHP dependencies using Composer:**
   ```sh
   make composer-install
   ```
4. **Run database migrations:**
   ```sh
    make migrate
    ```
5. **Load database fixtures:**
    ```sh
     make fixtures
     ```
6. **Sending Emails**
    - **Access the application:** Open your web browser and navigate to http://localhost:8000.
    - **Send emails:**
        - Navigate to the email sending page.
        - Fill out the form and submit it to send emails to users by category.
7. **Accessing Sent Emails**
    - **Access MailHog:** Open your web browser and navigate to http://localhost:8025.
    - **View sent emails:**
        - In the MailHog interface, you can see the list of sent emails.
        - Click on an email to view its details.

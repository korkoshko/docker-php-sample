# Docker Sample (Nginx + PHP-FPM + Postgres + Redis)

**Specially crafted for members of the @symfony_php**

<img src="./art/symfony-php.png" alt="Symfony PHP Logo" height="400px">

## Setup

### 0. Add the following entry to your `/etc/hosts` file:
```plaintext
127.0.0.1   quotes.test
```

### 1. Copy the environment variables file:
```bash
cp .env.example .env
```

### 2. Build and start the Docker containers:
```bash
docker compose up -d
```

### 3. Access the backend container:
```bash
docker compose exec backend bash
```

### 4. Run database migrations:
```bash
sf doctrine:migrations:migrate -n
```

### 5. Load sample data into the database:
```bash
sf app:quotes:load
```

---

## Access the Application

After completing the setup, you can visit the application in your browser:

👉 **[https://quotes.test](https://quotes.test)**
___

## Tests

### Prepare the environment (recreate the database and run migrations):
```bash
c test:prepare
```

### Run tests:
```bash
c test
```

---

### Aliases in the Container
The following aliases are pre-configured inside the Docker container:

- **`sf`**: Shortcut for Symfony
  ```bash
  alias sf='php ./bin/console'
  ```
- **`c`**: Shortcut for Composer
  ```bash
  alias c='composer'
  ```

You can use these aliases directly after accessing the container.
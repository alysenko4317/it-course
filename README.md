# Telegram Bot System – Diploma Project from Prof2IT Course

## Summary

This project was developed as a **diploma assignment** during the professional training course **"Information Systems: from OOP to Telegram Bot"** (Prof2IT). It demonstrates full-cycle system design and integration of multiple backend components using modern technologies.

The solution simulates a small-scale, real-world information system consisting of:
- A **Telegram bot** built with Python.
- An **MVC web application** developed in pure PHP.
- A **REST API** layer for inter-component communication.
- A **PostgreSQL database**, containerized and orchestrated via Docker.

All services are containerized and launched via a single script (`build-and-run.bat`), allowing easy deployment and testing.

## Key Features

- **Modular architecture**: each component runs in its own container (bot, web app, DB).
- **RESTful API**: designed for reliable communication between Python and PHP layers.
- **Data persistence**: implemented with a PostgreSQL container and structured DB schema.
- **Educational focus**: the project structure reflects typical steps in backend system development—from modeling to deployment.

## Tech Stack

- Python (bot logic)
- PHP (MVC web app)
- PostgreSQL (Dockerized)
- REST API (custom spec, JSON over HTTP)
- Docker & Docker Compose

```bash
.
├── app/                # MVC-style web application in PHP
├── bot/                # Telegram bot in Python
├── database/           # Docker-based PostgreSQL setup
├── restapi_design/     # REST API documentation
```

## Certificate

This project was completed as part of the Prof2IT professional training program.

📄 [Prof2IT Certificate (PDF)](cert/ProfIT_Lysenko_Anton_2024.pdf)

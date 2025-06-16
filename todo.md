# 🏥 MedControl - Arquitectura y Normalización

## 🎯 **Objetivo**

Sistema para que doctores gestionen:

- Sus pacientes (no usuarios, solo registros propios del doctor)
- Consultas realizadas
- Historial médico de cada paciente por consulta

👉 MVP enfocado en un doctor individual con sus propios pacientes.  
👉 MySQL 8 como base de datos.  
👉 Laravel 11 + Sanctum + REST API + opcional Filament para admin panel.

---

## 🛠 **Arquitectura técnica**

### 📌 Stack

- Laravel 11 (PHP 8.2+)
- MySQL 8+
- Sanctum (auth por token)
- REST API
- Filament (opcional para admin CRUD interno)
- PestPHP (testing)
- Docker (opcional recomendado)

### 📌 Estilo de arquitectura

- Layered architecture + DDD light
- API-only (no blade, no frontend integrado)
- Entities: Doctor, Patient, Consultation, MedicalHistory
- Repositorios para acceso a datos
- Controladores finos que llaman a services/use cases

### 📌 API

- RESTful, rutas bien organizadas:
    - `/api/patients`
    - `/api/consultations`
    - `/api/medical-histories`
    - `/api/profile` (para el doctor)
- Autenticación por token (Sanctum)

---

## 🗄 **Modelo de datos / normalización**

### doctors

| Field      | Type         | Constraints      |
| ---------- | ------------ | ---------------- |
| id         | BIGINT       | PK, AI           |
| uuid       | CHAR(36)     | UNIQUE           |
| name       | VARCHAR(255) | NOT NULL         |
| email      | VARCHAR(255) | UNIQUE, NOT NULL |
| password   | VARCHAR(255) | NOT NULL         |
| phone      | VARCHAR(20)  | NULL             |
| created_at | TIMESTAMP    |                  |
| updated_at | TIMESTAMP    |                  |

---

### patients

| Field      | Type                          | Constraints      |
| ---------- | ----------------------------- | ---------------- |
| id         | BIGINT                        | PK, AI           |
| uuid       | CHAR(36)                      | UNIQUE           |
| doctor_id  | BIGINT                        | FK -> doctors.id |
| name       | VARCHAR(255)                  | NOT NULL         |
| lastname   | VARCHAR(255)                  | NOT NULL         |
| dni        | VARCHAR(20)                   | NULL             |
| phone      | VARCHAR(20)                   | NULL             |
| email      | VARCHAR(255)                  | NULL             |
| birth_date | DATE                          | NULL             |
| gender     | ENUM('MALE','FEMALE','OTHER') | NULL             |
| created_at | TIMESTAMP                     |                  |
| updated_at | TIMESTAMP                     |                  |

---

### consultations

| Field      | Type                                                         | Constraints       |
| ---------- | ------------------------------------------------------------ | ----------------- |
| id         | BIGINT                                                       | PK, AI            |
| uuid       | CHAR(36)                                                     | UNIQUE            |
| doctor_id  | BIGINT                                                       | FK -> doctors.id  |
| patient_id | BIGINT                                                       | FK -> patients.id |
| type       | ENUM('LENS_MEASURE', 'CATARACT_SURGERY', 'GENERAL', 'OTHER') | NOT NULL          |
| price      | DECIMAL(10,2)                                                | NOT NULL          |
| date       | DATE                                                         | NOT NULL          |
| notes      | TEXT                                                         | NULL              |
| created_at | TIMESTAMP                                                    |                   |
| updated_at | TIMESTAMP                                                    |                   |

---

### medical_histories

| Field           | Type      | Constraints            |
| --------------- | --------- | ---------------------- |
| id              | BIGINT    | PK, AI                 |
| consultation_id | BIGINT    | FK -> consultations.id |
| summary         | TEXT      | NULL                   |
| diagnosis       | TEXT      | NULL                   |
| treatment       | TEXT      | NULL                   |
| observations    | TEXT      | NULL                   |
| created_at      | TIMESTAMP |                        |
| updated_at      | TIMESTAMP |                        |

---

## ⚡ **Relaciones**

- `Doctor` tiene muchos `Patient`
- `Doctor` tiene muchos `Consultation`
- `Patient` tiene muchas `Consultation`
- `Consultation` tiene un `MedicalHistory`

---

## 🧠 **Flujo básico del sistema**

1️⃣ Doctor se registra y se loguea → obtiene token  
2️⃣ Crea sus pacientes  
3️⃣ Registra una consulta para un paciente  
4️⃣ En la consulta carga el historial médico  
5️⃣ Listados / búsquedas / filtros: por paciente, por fecha, por tipo

---

## 📝 **Endpoints sugeridos**

- `POST /api/login`
- `POST /api/logout`
- `GET /api/patients`
- `POST /api/patients`
- `GET /api/patients/{uuid}`
- `PUT /api/patients/{uuid}`
- `DELETE /api/patients/{uuid}`
- `GET /api/consultations`
- `POST /api/consultations`
- `GET /api/consultations/{uuid}`
- `PUT /api/consultations/{uuid}`
- `DELETE /api/consultations/{uuid}`
- `POST /api/consultations/{uuid}/medical-history`
- `GET /api/consultations/{uuid}/medical-history`
- `PUT /api/consultations/{uuid}/medical-history`

---

## 🚀 **Roadmap**

- [ ] Diagramar base de datos (MySQL Workbench o dbdiagram.io)
- [ ] Crear migraciones
- [ ] Crear factories (tests + seeders)
- [ ] Montar controladores API
- [ ] Configurar Sanctum
- [ ] Configurar Filament si se desea
- [ ] Escribir tests básicos (login, CRUDs)

---

## 💡 **Consideraciones futuras**

- Posibilidad de multiclínica (añadir `clinic_location`)
- Adjuntos en historial (archivos de exámenes)
- Dashboard con estadísticas
- Multi-doctor (team de doctores)

---

# Fin del documento

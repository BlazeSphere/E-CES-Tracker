# E-CES Tracker: Data Dictionary

This document provides a technical reference for the database schema used in the Community Extension Services tracking system.

---

### 1. Users Table
Manages authentication, institutional identification, and role-based access control.

| Field Name | Data Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique auto-incrementing identifier for the user. |
| `id_number` | String | Institutional ID number for tracking faculty/staff. |
| `name` | String | Full name of the user. |
| `email` | String | Unique institutional email address used for login. |
| `password` | String | Hashed security credential for account access. |
| `role` | Integer | System access level: `0` (Super Admin), `1` (Admin). |
| `department` | String | The school code (e.g., SIT) assigned to the administrator. |
| `status` | String | Account state: `active` or `inactive` (locks account). |
| `timestamps` | Timestamps | Records of account creation and last update. |

---

### 2. Projects Table
Stores data for community service initiatives across different schools.

| Field Name | Data Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the CES project. |
| `project_name` | String | Formal title of the community service project. |
| `description` | Text | Detailed summary of project goals and objectives. |
| `category` | String | Classification (e.g., Outreach, Environmental, Health). |
| `department` | String | The school/department that owns and manages the project. |
| `status` | String | Current lifecycle stage: `Planned`, `In Progress`, `Completed`. |
| `budget` | Decimal | Allocated institutional funds for project execution. |
| `volunteers_count` | Integer | Total number of student/faculty volunteers involved. |
| `beneficiaries_count`| Integer | Estimated number of individuals reached by the project. |
| `impact_score` | Decimal | Calculated effectiveness rating (0.00 to 5.00) based on metrics. |
| `adopted_community_id`| BigInt (FK) | Reference to the specific partner community being served. |
| `user_id` | BigInt (FK) | Reference to the Administrator (Person in Charge). |

---

### 3. Schools Table
Maintains the master list of departments/colleges within the institution.

| Field Name | Data Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the school record. |
| `name` | String | Full formal name of the college (e.g., School of Information Technology). |
| `code` | String | Short unique acronym (e.g., SIT, SBHTM, SE). |
| `description` | Text | Brief overview of the department's focus area. |
| `timestamps` | Timestamps | Records of when the school code was registered/modified. |

---

### 4. Surveys Table
Manages dynamic feedback forms linked to projects and events.

| Field Name | Data Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the survey form. |
| `project_id` | BigInt (FK) | Links the survey to a specific institutional project. |
| `title` | String | The display title of the evaluation or feedback form. |
| `description` | Text | Instructions or context provided to respondents. |
| `status` | Enum | Current state of the form: `draft`, `active`, `closed`. |
| `form_data` | JSON | Structured storage for dynamic questions and logic. |
| `created_by` | BigInt (FK) | The user ID of the administrator who built the survey. |

---

### 5. Audit Logs Table
Provides full system traceability and accountability.

| Field Name | Data Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the activity log. |
| `user_id` | BigInt (FK) | The user who performed the recorded action. |
| `action` | String | High-level summary of the task (e.g., "Project Created"). |
| `description` | Text | Technical detail of the change, including target record info. |
| `ip_address` | String | The network address from which the action originated. |
| `user_agent` | Text | Browser and OS metadata of the performing user. |
| `created_at` | Timestamp | Precise date and time the action was finalized. |

---

### 6. Adopted Communities Table
Tracks official partner communities and service areas.

| Field Name | Data Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the partner community. |
| `name` | String | Full name of the Barangay or Organization. |
| `code` | String | Unique partner identifier (e.g., BGY-001). |
| `address` | String | Physical location or service boundary of the community. |
| `timestamps` | Timestamps | Historical tracking of community adoption status. |
